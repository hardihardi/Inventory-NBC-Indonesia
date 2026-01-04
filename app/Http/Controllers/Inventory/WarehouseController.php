<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Warehouse;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::latest()->paginate(10);
        return view('inventory.warehouses.index', compact('warehouses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:warehouses,code',
            'address' => 'nullable|string',
        ]);

        Warehouse::create($validated);
        return redirect()->back()->with('success', 'Gudang berhasil ditambahkan.');
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:warehouses,code,' . $warehouse->id,
            'address' => 'nullable|string',
        ]);

        $warehouse->update($validated);
        return redirect()->back()->with('success', 'Gudang berhasil diperbarui.');
    }

    public function destroy(Warehouse $warehouse)
    {
        if ($warehouse->is_default) {
            $msg = 'Gudang utama tidak bisa dihapus.';
            if (request()->ajax()) {
                return response()->json(['error' => $msg], 422);
            }
            return redirect()->back()->with('error', $msg);
        }

        // Check for dependencies
        if ($warehouse->transfersFrom()->exists() || $warehouse->transfersTo()->exists()) {
            $msg = 'Gudang tidak bisa dihapus karena memiliki riwayat transfer stok.';
            if (request()->ajax()) {
                return response()->json(['error' => $msg], 422);
            }
            return redirect()->back()->with('error', $msg);
        }

        if ($warehouse->adjustments()->exists()) {
            return redirect()->back()->with('error', 'Gudang tidak bisa dihapus karena memiliki riwayat penyesuaian stok.');
        }

        if ($warehouse->ledgers()->exists()) {
            return redirect()->back()->with('error', 'Gudang tidak bisa dihapus karena memiliki riwayat log stok.');
        }

        if ($warehouse->stocks()->where('stock', '>', 0)->exists()) {
            $msg = 'Gudang tidak bisa dihapus karena masih memiliki barang dengan stok tersedia.';
            if (request()->ajax()) {
                return response()->json(['error' => $msg], 422);
            }
            return redirect()->back()->with('error', $msg);
        }

        try {
            // Delete related empty stock records
            $warehouse->stocks()->delete();
            
            $warehouse->delete();
            
            if (request()->ajax()) {
                return response()->json(['success' => 'Gudang berhasil dihapus.']);
            }
            return redirect()->back()->with('success', 'Gudang berhasil dihapus.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Gagal menghapus gudang: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Gagal menghapus gudang: ' . $e->getMessage());
        }
    }
}
