<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Item;

class ScannerController extends Controller
{
    public function index()
    {
        return view('inventory.scanner');
    }

    public function scanResult(Request $request)
    {
        $code = $request->code;

        // Our QR codes point to route('inventory.items.show', $item->id)
        // Format: http://domain.com/inventory/items/{id}
        
        // Try to find the item ID from the URL
        if (preg_match('/inventory\/items\/(\d+)/', $code, $matches)) {
            $itemId = $matches[1];
            $item = Item::with(['category', 'unit'])->find($itemId);

            if ($item) {
                return response()->json([
                    'success' => true,
                    'item' => [
                        'id' => $item->id,
                        'name' => $item->name,
                        'sku' => $item->sku,
                        'stock' => $item->stock,
                        'unit' => $item->unit->short_name ?? $item->unit->name ?? 'Unit',
                        'price' => number_format($item->price, 0, ',', '.'),
                        'category' => $item->category->name ?? '-',
                        'image' => $item->image ? asset('storage/' . $item->image) : null,
                        'url' => route('inventory.items.show', $item->id),
                        'edit_url' => route('inventory.items.edit', $item->id)
                    ]
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Produk tidak ditemukan atau format QR tidak valid.'
        ]);
    }
}
