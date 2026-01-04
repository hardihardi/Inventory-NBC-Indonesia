<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class ValuationController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');
        $warehouseId = $request->query('warehouse_id');
        $mode = $request->query('mode', 'cost'); // 'cost', 'sale', 'average'
        
        $query = Item::with(['category', 'unit', 'warehouseStocks'])
            ->withMax('saleItems as last_sold_date', 'created_at');

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Deep Analytical Query
        $items = $query->get()->map(function ($item) use ($mode, $warehouseId) {
            // Determine Price
            if ($mode === 'sale') {
                $price = $item->price ?? 0;
            } elseif ($mode === 'average') {
                // Calculate Average Purchase Price from history
                $price = \App\Models\PembelianItem::where('item_id', $item->id)
                    ->avg('unit_price') ?? $item->purchase_price ?? 0;
            } else {
                $price = $item->purchase_price ?? 0;
            }

            // Determine Stock (Global or Warehouse specific)
            if ($warehouseId) {
                $stock = $item->warehouseStocks->where('warehouse_id', $warehouseId)->sum('stock');
            } else {
                $stock = $item->stock;
            }

            $item->current_stock = $stock;
            $item->active_price = $price;
            $item->valuation = $stock * $price;
            
            // Stock Status Analysis
            $item->is_dead = (!$item->last_sold_date || \Carbon\Carbon::parse($item->last_sold_date)->lt(now()->subDays(90))) && $stock > 0;
            $item->is_low = $stock <= $item->min_stock && $stock > 0;
            
            $item->status_label = 'Healthy';
            $item->status_color = 'success';
            if ($item->is_dead) {
                $item->status_label = 'Dead Stock';
                $item->status_color = 'danger';
            } elseif ($item->is_low) {
                $item->status_label = 'Low Stock';
                $item->status_color = 'warning';
            } elseif ($stock <= 0) {
                $item->status_label = 'Out of Stock';
                $item->status_color = 'secondary';
            }

            return $item;
        });

        // Metrics
        $totalValuation = $items->sum('valuation');
        $totalItems = $items->where('current_stock', '>', 0)->count();
        $topItem = $items->where('current_stock', '>', 0)->sortByDesc('valuation')->first();
        $deadStockValue = $items->where('is_dead', true)->sum('valuation');
        
        // Potential Profit (if mode is cost/average)
        $potentialProfit = 0;
        if ($mode !== 'sale') {
            $potentialProfit = $items->sum(function($item) {
                return $item->current_stock * (($item->price ?? 0) - $item->active_price);
            });
        }

        // Charts
        $categoryData = $items->where('current_stock', '>', 0)->groupBy('category.name')->map->sum('valuation');
        $statusData = $items->where('current_stock', '>', 0)->groupBy('status_label')->map->count();

        $categories = Category::all();
        $warehouses = \App\Models\Warehouse::all();

        return view('reports.valuation.index', compact(
            'items', 'totalValuation', 'categories', 'warehouses',
            'categoryId', 'warehouseId', 'mode', 'totalItems',
            'topItem', 'categoryData', 'statusData', 'deadStockValue', 'potentialProfit'
        ));
    }

    public function print(Request $request)
    {
        $categoryId = $request->query('category_id');
        $warehouseId = $request->query('warehouse_id');
        $mode = $request->query('mode', 'cost');
        
        $query = Item::with(['category', 'unit', 'warehouseStocks']);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $items = $query->get()->map(function ($item) use ($mode, $warehouseId) {
            // Price logic
            if ($mode === 'sale') {
                $price = $item->price ?? 0;
            } elseif ($mode === 'average') {
                $price = \App\Models\PembelianItem::where('item_id', $item->id)->avg('unit_price') ?? $item->purchase_price ?? 0;
            } else {
                $price = $item->purchase_price ?? 0;
            }

            // Stock logic
            $stock = $warehouseId 
                ? $item->warehouseStocks->where('warehouse_id', $warehouseId)->sum('stock')
                : $item->stock;

            $item->current_stock = $stock;
            $item->active_price = $price;
            $item->valuation = $stock * $price;
            return $item;
        })->filter(function($item) {
            return $item->current_stock > 0;
        });

        $totalValuation = $items->sum('valuation');
        $company = \App\Models\CompanySetting::first();
        $warehouse = $warehouseId ? \App\Models\Warehouse::find($warehouseId) : null;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.valuation.print', compact('items', 'totalValuation', 'company', 'mode', 'warehouse'));
        return $pdf->stream('laporan-valuasi-stok-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $categoryId = $request->query('category_id');
        $warehouseId = $request->query('warehouse_id');
        $mode = $request->query('mode', 'cost');
        
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\ValuationExport($categoryId, $mode, $warehouseId), 
            'valuasi-stok-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
