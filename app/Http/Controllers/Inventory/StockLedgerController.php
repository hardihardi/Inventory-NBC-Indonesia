<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\StockLedger;
use App\Models\Item;
use App\Models\Warehouse;
use App\Models\CompanySetting;
use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class StockLedgerController extends Controller
{
    /**
     * Menampilkan Jurnal Stok Global.
     */
    public function index(Request $request)
    {
        $query = StockLedger::with(['item.category', 'item.color', 'warehouse', 'user'])->orderBy('created_at', 'desc');

        // Filter Berdasarkan Kategori
        if ($request->filled('category_id')) {
            $query->whereHas('item', function($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        // Filter Berdasarkan Tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter Berdasarkan Gudang
        if ($request->filled('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        // Filter Berdasarkan Tipe (IN/OUT)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter Berdasarkan Produk (Search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('item', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Summary Stats (Based on current filters)
        $statsQuery = clone $query;
        // If no date filters, default to current month for stats
        if (!$request->filled('start_date') && !$request->filled('end_date')) {
            $statsQuery->whereMonth('created_at', date('m'))
                       ->whereYear('created_at', date('Y'));
        }

        $stats = [
            'total_in' => (clone $statsQuery)->where('type', 'in')->sum('qty_change'),
            'total_out' => (clone $statsQuery)->where('type', 'out')->sum('qty_change'),
        ];
        $stats['net'] = $stats['total_in'] - $stats['total_out'];

        // Jika request export
        if ($request->has('export')) {
            $ledgers = $query->get();
            $company = CompanySetting::first();
            $pdf = Pdf::loadView('inventory.reports.stock_ledger.export.global', compact('ledgers', 'company', 'stats'))->setPaper('a4', 'landscape');
            return $pdf->download('jurnal-stok-' . date('Y-m-d') . '.pdf');
        }

        $ledgers = $query->paginate(25)->withQueryString();
        $warehouses = Warehouse::all();
        $categories = Category::all();

        return view('inventory.reports.stock_ledger.index', compact('ledgers', 'warehouses', 'categories', 'stats'));
    }

    /**
     * Menampilkan Kartu Stok per Item.
     */
    public function itemCard(Request $request, Item $item)
    {
        $query = StockLedger::where('item_id', $item->id)
            ->with(['warehouse', 'user'])
            ->orderBy('created_at', 'asc');

        if ($request->filled('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        // Filter Berdasarkan Tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Calculate Opening Balance
        $openingBalance = 0;
        if ($request->filled('start_date')) {
            $lastBefore = StockLedger::where('item_id', $item->id)
                ->where('created_at', '<', Carbon::parse($request->start_date)->startOfDay());
            
            if ($request->filled('warehouse_id')) {
                $lastBefore->where('warehouse_id', $request->warehouse_id);
            }
            
            $lastBefore = $lastBefore->orderBy('created_at', 'desc')->first();
            $openingBalance = $lastBefore ? $lastBefore->qty_after : 0;
            
            // If there's absolutely no transaction before start_date, 
            // the opening balance is technically the qty_before of the first transaction ever.
            if (!$lastBefore) {
                 $firstEver = StockLedger::where('item_id', $item->id);
                 if ($request->filled('warehouse_id')) {
                     $firstEver->where('warehouse_id', $request->warehouse_id);
                 }
                 $firstEver = $firstEver->orderBy('created_at', 'asc')->first();
                 $openingBalance = $firstEver ? $firstEver->qty_before : 0;
            }
        }

        $ledgers = $query->get();
        $warehouses = Warehouse::all();

        // Jika request export
        if ($request->has('export')) {
            $company = CompanySetting::first();
            $pdf = Pdf::loadView('inventory.reports.stock_ledger.export.item', compact('ledgers', 'item', 'company', 'openingBalance'))->setPaper('a4', 'portrait');
            return $pdf->download('kartu-stok-' . $item->sku . '.pdf');
        }

        return view('inventory.reports.stock_ledger.item_card', compact('item', 'ledgers', 'warehouses', 'openingBalance'));
    }
    /**
     * Menampilkan Ringkasan Stok (Opening, In, Out, Closing).
     */
    public function summary(Request $request)
    {
        $startDate = $request->query('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->query('end_date', now()->format('Y-m-d'));
        $categoryId = $request->query('category_id');
        $warehouseId = $request->query('warehouse_id');

        $query = Item::with(['category', 'unit']);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $items = $query->get()->map(function ($item) use ($startDate, $endDate, $warehouseId) {
            // 1. Opening Balance (Saldo Sebelum Start Date)
            $openingQuery = StockLedger::where('item_id', $item->id)
                ->where('created_at', '<', Carbon::parse($startDate)->startOfDay());
            if ($warehouseId) $openingQuery->where('warehouse_id', $warehouseId);
            
            $lastBefore = $openingQuery->orderBy('created_at', 'desc')->first();
            $item->opening_qty = $lastBefore ? $lastBefore->qty_after : 0;
            
            // Handle case where NO transaction before start_date
            if (!$lastBefore) {
                $firstEver = StockLedger::where('item_id', $item->id);
                if ($warehouseId) $firstEver->where('warehouse_id', $warehouseId);
                $firstEver = $firstEver->orderBy('created_at', 'asc')->first();
                $item->opening_qty = $firstEver ? $firstEver->qty_before : 0;
            }

            // 2. Qty In in Period
            $inQuery = StockLedger::where('item_id', $item->id)
                ->where('type', 'in')
                ->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
            if ($warehouseId) $inQuery->where('warehouse_id', $warehouseId);
            $item->qty_in = $inQuery->sum('qty_change');

            // 3. Qty Out in Period
            $outQuery = StockLedger::where('item_id', $item->id)
                ->where('type', 'out')
                ->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
            if ($warehouseId) $outQuery->where('warehouse_id', $warehouseId);
            $item->qty_out = $outQuery->sum('qty_change');

            // 4. Closing Balance
            $item->closing_qty = $item->opening_qty + $item->qty_in - $item->qty_out;

            return $item;
        });

        $categories = Category::all();
        $warehouses = Warehouse::all();

        return view('inventory.reports.stock_ledger.summary', compact('items', 'categories', 'warehouses', 'startDate', 'endDate', 'categoryId', 'warehouseId'));
    }

    /**
     * Export Ringkasan Stok ke PDF atau Excel.
     */
    public function exportSummary(Request $request)
    {
        $startDate = $request->query('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->query('end_date', now()->format('Y-m-d'));
        $categoryId = $request->query('category_id');
        $warehouseId = $request->query('warehouse_id');
        $format = $request->query('format', 'pdf');

        $category = $categoryId ? Category::find($categoryId) : null;
        $warehouse = $warehouseId ? Warehouse::find($warehouseId) : null;
        $filters = [
            'category' => $category ? $category->name : 'Semua Kategori',
            'warehouse' => $warehouse ? $warehouse->name : 'Semua Gudang'
        ];

        // Logic Re-calculation for Export (same as summary but without pagination)
        $query = Item::with(['category', 'unit']);
        if ($categoryId) $query->where('category_id', $categoryId);
        $items = $query->get()->map(function ($item) use ($startDate, $endDate, $warehouseId) {
            $openingQuery = StockLedger::where('item_id', $item->id)->where('created_at', '<', Carbon::parse($startDate)->startOfDay());
            if ($warehouseId) $openingQuery->where('warehouse_id', $warehouseId);
            $lastBefore = $openingQuery->orderBy('created_at', 'desc')->first();
            $item->opening_qty = $lastBefore ? $lastBefore->qty_after : 0;
            if (!$lastBefore) {
                $firstEver = StockLedger::where('item_id', $item->id);
                if ($warehouseId) $firstEver->where('warehouse_id', $warehouseId);
                $firstEver = $firstEver->orderBy('created_at', 'asc')->first();
                $item->opening_qty = $firstEver ? $firstEver->qty_before : 0;
            }
            $inQuery = StockLedger::where('item_id', $item->id)->where('type', 'in')->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
            if ($warehouseId) $inQuery->where('warehouse_id', $warehouseId);
            $item->qty_in = $inQuery->sum('qty_change');
            $outQuery = StockLedger::where('item_id', $item->id)->where('type', 'out')->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
            if ($warehouseId) $outQuery->where('warehouse_id', $warehouseId);
            $item->qty_out = $outQuery->sum('qty_change');
            $item->closing_qty = $item->opening_qty + $item->qty_in - $item->qty_out;
            return $item;
        });

        if ($format === 'excel') {
            return \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\StockSummaryExport($items, $startDate, $endDate, $filters),
                'ringkasan-stok-' . $startDate . '-to-' . $endDate . '.xlsx'
            );
        }

        $company = CompanySetting::first();
        $pdf = Pdf::loadView('inventory.reports.stock_ledger.export.summary_print', compact('items', 'startDate', 'endDate', 'company', 'filters'))
                  ->setPaper('a4', 'landscape');
        
        return $pdf->download('ringkasan-stok-' . $startDate . '-to-' . $endDate . '.pdf');
    }
}
