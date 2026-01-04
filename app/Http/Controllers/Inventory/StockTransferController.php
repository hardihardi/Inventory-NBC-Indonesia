<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\StockTransfer;
use App\Models\Item;
use App\Models\Warehouse;
use App\Models\WarehouseStock;
use App\Models\StockLedger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockTransferController extends Controller
{
    public function index()
    {
        $transfers = StockTransfer::with(['item', 'fromWarehouse', 'toWarehouse', 'creator'])->latest()->paginate(10);
        $items = Item::all();
        $warehouses = Warehouse::all();
        return view('inventory.transfers.index', compact('transfers', 'items', 'warehouses'));
    }

    public function create()
    {
        $items = Item::all();
        $warehouses = Warehouse::all();
        return view('inventory.transfers.create', compact('items', 'warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'from_warehouse_id' => 'required|exists:warehouses,id',
            'to_warehouse_id' => 'required|exists:warehouses,id|different:from_warehouse_id',
            'qty' => 'required|numeric|min:0.01',
        ], [
            'different' => ':attribute harus berbeda dengan :other.',
            'required' => ':attribute wajib diisi.',
            'exists' => ':attribute tidak valid.',
            'numeric' => ':attribute harus berupa angka.',
            'min' => ':attribute minimal :min.',
        ], [
            'item_id' => 'Produk',
            'from_warehouse_id' => 'Gudang Asal',
            'to_warehouse_id' => 'Gudang Tujuan',
            'qty' => 'Jumlah Transfer',
        ]);

        // Check stock availability
        $wsSource = WarehouseStock::where('item_id', $request->item_id)
            ->where('warehouse_id', $request->from_warehouse_id)
            ->first();

        if (!$wsSource || $wsSource->stock < $request->qty) {
            return redirect()->back()->with('error', 'Stok di gudang asal tidak mencukupi.');
        }

        StockTransfer::create([
            'transfer_no' => 'TRF-' . time(),
            'item_id' => $request->item_id,
            'from_warehouse_id' => $request->from_warehouse_id,
            'to_warehouse_id' => $request->to_warehouse_id,
            'qty' => $request->qty,
            'status' => 'pending',
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('inventory.transfers.index')->with('success', 'Permintaan transfer stok diajukan.');
    }

    public function approve(StockTransfer $transfer)
    {
        if (!Auth::user()->hasPermission('transfer.approve')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak akses untuk menyetujui transfer stok.');
        }

        DB::transaction(function () use ($transfer) {
            $wsSource = WarehouseStock::where('item_id', $transfer->item_id)
                ->where('warehouse_id', $transfer->from_warehouse_id)
                ->first();

            if (!$wsSource || $wsSource->stock < $transfer->qty) {
                throw new \Exception('Stok tidak mencukupi saat eksekusi transfer.');
            }

            $wsSource->decrement('stock', $transfer->qty);

            // Log Stock Out (Source)
            StockLedger::log(
                $transfer->item_id,
                $transfer->from_warehouse_id,
                -$transfer->qty,
                $wsSource->fresh()->stock,
                'transfer',
                $transfer->id,
                StockTransfer::class,
                "Transfer out to {$transfer->toWarehouse->name}"
            );

            $wsDest = WarehouseStock::firstOrCreate(
                ['item_id' => $transfer->item_id, 'warehouse_id' => $transfer->to_warehouse_id],
                ['stock' => 0]
            );
            $wsDest->increment('stock', $transfer->qty);

            // Log Stock In (Destination)
            StockLedger::log(
                $transfer->item_id,
                $transfer->to_warehouse_id,
                $transfer->qty,
                $wsDest->fresh()->stock,
                'transfer',
                $transfer->id,
                StockTransfer::class,
                "Transfer in from {$transfer->fromWarehouse->name}"
            );

            $transfer->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'transfer_date' => now(),
            ]);
        });

        if (request()->ajax()) {
            return response()->json(['success' => 'Transfer stok berhasil disetujui dan stok dipindahkan.']);
        }
        return redirect()->back()->with('success', 'Transfer stok berhasil disetujui dan stok dipindahkan.');
    }

    public function reject(StockTransfer $transfer)
    {
        if (!Auth::user()->hasPermission('transfer.approve')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak akses untuk menolak transfer stok ini.');
        }

        if ($transfer->status === 'approved') {
            return redirect()->back()->with('error', 'Transfer yang sudah selesai tidak dapat ditolak.');
        }

        $transfer->update([
            'status' => 'rejected',
        ]);

        \App\Models\ActivityLog::log('Inventory', "Menolak transfer stok: {$transfer->transfer_no}");

        if (request()->ajax()) {
            return response()->json(['success' => 'Permintaan transfer stok ditolak.']);
        }
        return redirect()->back()->with('success', 'Permintaan transfer stok ditolak.');
    }

    public function update(Request $request, StockTransfer $transfer)
    {
        if ($transfer->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya transfer berstatus pending yang dapat diubah.');
        }

        $request->validate([
            'item_id' => 'required|exists:items,id',
            'from_warehouse_id' => 'required|exists:warehouses,id',
            'to_warehouse_id' => 'required|exists:warehouses,id|different:from_warehouse_id',
            'qty' => 'required|numeric|min:0.01',
        ], [
            'different' => ':attribute harus berbeda dengan :other.',
            'required' => ':attribute wajib diisi.',
            'exists' => ':attribute tidak valid.',
            'numeric' => ':attribute harus berupa angka.',
            'min' => ':attribute minimal :min.',
        ], [
            'item_id' => 'Produk',
            'from_warehouse_id' => 'Gudang Asal',
            'to_warehouse_id' => 'Gudang Tujuan',
            'qty' => 'Jumlah Transfer',
        ]);

        // Check stock availability in new source warehouse
        $wsSource = WarehouseStock::where('item_id', $request->item_id)
            ->where('warehouse_id', $request->from_warehouse_id)
            ->first();

        if (!$wsSource || $wsSource->stock < $request->qty) {
            return redirect()->back()->with('error', 'Stok di gudang asal tidak mencukupi.');
        }

        $transfer->update([
            'item_id' => $request->item_id,
            'from_warehouse_id' => $request->from_warehouse_id,
            'to_warehouse_id' => $request->to_warehouse_id,
            'qty' => $request->qty,
            'notes' => $request->notes,
        ]);

        return redirect()->route('inventory.transfers.index')->with('success', 'Transfer stok berhasil diperbarui.');
    }

    public function destroy(StockTransfer $transfer)
    {
        if ($transfer->status === 'approved') {
            return redirect()->back()->with('error', 'Transfer yang sudah selesai tidak dapat dihapus.');
        }

        $transfer->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => 'Transfer stok berhasil dihapus.']);
        }
        return redirect()->route('inventory.transfers.index')->with('success', 'Transfer stok berhasil dihapus.');
    }
}
