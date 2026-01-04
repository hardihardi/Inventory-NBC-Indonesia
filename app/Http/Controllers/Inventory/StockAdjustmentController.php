<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\StockAdjustment;
use App\Models\Item;
use App\Models\Warehouse;
use App\Models\WarehouseStock;
use App\Models\StockLedger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockAdjustmentController extends Controller
{
    public function index()
    {
        $adjustments = StockAdjustment::with(['item', 'warehouse', 'creator'])->latest()->paginate(10);
        $items = Item::all();
        $warehouses = Warehouse::all();
        return view('inventory.adjustments.index', compact('adjustments', 'items', 'warehouses'));
    }

    public function create()
    {
        $items = Item::all();
        $warehouses = Warehouse::all();
        return view('inventory.adjustments.create', compact('items', 'warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'qty_adjustment' => 'required|numeric',
            'reason' => 'required|string',
        ]);

        $ws = WarehouseStock::where('item_id', $request->item_id)
            ->where('warehouse_id', $request->warehouse_id)
            ->first();

        $qty_before = $ws ? $ws->stock : 0;

        StockAdjustment::create([
            'adjustment_no' => 'ADJ-' . time(),
            'item_id' => $request->item_id,
            'warehouse_id' => $request->warehouse_id,
            'qty_before' => $qty_before,
            'qty_adjustment' => $request->qty_adjustment,
            'qty_after' => $qty_before + $request->qty_adjustment,
            'reason' => $request->reason,
            'created_by' => Auth::id(),
            'status' => 'pending',
        ]);

        return redirect()->route('inventory.adjustments.index')->with('success', 'Penyesuaian stok diajukan.');
    }

    public function approveLevel1(StockAdjustment $adjustment)
    {
        if (!Auth::user()->hasPermission('adjustment.approve')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak akses untuk menyetujui penyesuaian stok.');
        }

        $adjustment->update([
            'status' => 'level_1_approved',
            'level_1_approved_by' => Auth::id(),
            'level_1_approved_at' => now(),
        ]);

        \App\Models\ActivityLog::log('Inventory', "Supervisor menyetujui penyesuaian: {$adjustment->adjustment_no}");

        if (request()->ajax()) {
            return response()->json(['success' => 'Persetujuan Supervisor (L1) berhasil.']);
        }
        return redirect()->back()->with('success', 'Persetujuan Supervisor (L1) berhasil.');
    }

    public function approveFinal(StockAdjustment $adjustment)
    {
        // Final approval usually by Admin or Manager
        if (!in_array(Auth::user()->role, ['admin', 'procurement'])) {
            return redirect()->back()->with('error', 'Hanya Manajer atau Admin yang dapat melakukan validasi akhir.');
        }

        if ($adjustment->status !== 'level_1_approved') {
            return redirect()->back()->with('error', 'Harus disetujui Supervisor terlebih dahulu.');
        }

        DB::transaction(function () use ($adjustment) {
            $ws = WarehouseStock::firstOrCreate(
                ['item_id' => $adjustment->item_id, 'warehouse_id' => $adjustment->warehouse_id],
                ['stock' => $adjustment->qty_before]
            );

            $ws->increment('stock', $adjustment->qty_adjustment);

            // Log Stock Movement
            StockLedger::log(
                $adjustment->item_id,
                $adjustment->warehouse_id,
                $adjustment->qty_adjustment,
                $ws->fresh()->stock,
                'adjustment',
                $adjustment->id,
                StockAdjustment::class,
                $adjustment->reason
            );

            // Sync total stock to item table
            $totalStock = WarehouseStock::where('item_id', $adjustment->item_id)->sum('stock');
            Item::where('id', $adjustment->item_id)->update(['stock' => $totalStock]);

            $adjustment->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);
        });

        if (request()->ajax()) {
            return response()->json(['success' => 'Penyesuaian stok disetujui dan stok diperbarui.']);
        }
        return redirect()->back()->with('success', 'Penyesuaian stok disetujui dan stok diperbarui.');
    }

    public function reject(StockAdjustment $adjustment)
    {
        if (!Auth::user()->hasPermission('adjustment.approve') && !in_array(Auth::user()->role, ['admin', 'procurement'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak akses untuk menolak penyesuaian ini.');
        }

        if ($adjustment->status === 'approved') {
            return redirect()->back()->with('error', 'Penyesuaian yang sudah selesai tidak dapat ditolak.');
        }

        $adjustment->update([
            'status' => 'rejected',
        ]);

        \App\Models\ActivityLog::log('Inventory', "Menolak penyesuaian stok: {$adjustment->adjustment_no}");

        if (request()->ajax()) {
            return response()->json(['success' => 'Penyesuaian stok ditolak.']);
        }
        return redirect()->back()->with('success', 'Penyesuaian stok ditolak.');
    }

    public function update(Request $request, StockAdjustment $adjustment)
    {
        if ($adjustment->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya penyesuaian berstatus pending yang dapat diubah.');
        }

        $request->validate([
            'item_id' => 'required|exists:items,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'qty_adjustment' => 'required|numeric',
            'reason' => 'required|string',
        ]);

        $ws = WarehouseStock::where('item_id', $request->item_id)
            ->where('warehouse_id', $request->warehouse_id)
            ->first();

        $qty_before = $ws ? $ws->stock : 0;

        $adjustment->update([
            'item_id' => $request->item_id,
            'warehouse_id' => $request->warehouse_id,
            'qty_before' => $qty_before,
            'qty_adjustment' => $request->qty_adjustment,
            'qty_after' => $qty_before + $request->qty_adjustment,
            'reason' => $request->reason,
        ]);

        return redirect()->route('inventory.adjustments.index')->with('success', 'Penyesuaian stok berhasil diperbarui.');
    }

    public function destroy(StockAdjustment $adjustment)
    {
        if ($adjustment->status === 'approved') {
            return redirect()->back()->with('error', 'Penyesuaian yang sudah selesai tidak dapat dihapus.');
        }

        $adjustment->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => 'Penyesuaian stok berhasil dihapus.']);
        }
        return redirect()->route('inventory.adjustments.index')->with('success', 'Penyesuaian stok berhasil dihapus.');
    }
}
