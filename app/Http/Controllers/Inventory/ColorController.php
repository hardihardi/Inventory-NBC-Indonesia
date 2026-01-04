<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::latest()->get();
        return view('inventory.colors.index', compact('colors'));
    }

    public function create()
    {
        return view('inventory.colors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:colors,name',
            'hex_code' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        try {
            Color::create($request->all());
            return redirect()->route('inventory.colors.index')->with('success', 'Warna berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan warna: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Color $color)
    {
        return view('inventory.colors.edit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:colors,name,' . $color->id,
            'hex_code' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        try {
            $color->update($request->all());
            return redirect()->route('inventory.colors.index')->with('success', 'Warna berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui warna: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Color $color)
    {
        try {
            // Check if color is used in items (optional but good)
            // For now, simple delete
            $color->delete();
            return response()->json(['success' => 'Warna berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus warna: ' . $e->getMessage()], 500);
        }
    }
}
