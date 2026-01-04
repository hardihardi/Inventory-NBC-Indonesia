<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::latest()->paginate(10);
        return view('master.units.index', compact('units'));
    }

    public function create()
    {
        return view('master.units.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:units,name',
            'short_name' => 'nullable|string|max:50',
        ]);

        Unit::create($validated);
        return redirect()->route('inventory.units.index')->with('success', 'Satuan berhasil ditambahkan!');
    }

    public function edit(Unit $unit)
    {
        return view('master.units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:units,name,' . $unit->id,
            'short_name' => 'nullable|string|max:50',
        ]);

        $unit->update($validated);
        return redirect()->route('inventory.units.index')->with('success', 'Satuan berhasil diperbarui!');
    }

    public function destroy(Unit $unit)
    {
        // Cek jika masih digunakan di item
        if ($unit->items()->exists()) {
            $msg = 'Satuan tidak bisa dihapus karena masih digunakan oleh produk.';
            if (request()->ajax()) {
                return response()->json(['error' => $msg], 422);
            }
            return redirect()->back()->with('error', $msg);
        }

        $unit->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => 'Satuan berhasil dihapus!']);
        }
        return redirect()->route('inventory.units.index')->with('success', 'Satuan berhasil dihapus!');
    }
}
