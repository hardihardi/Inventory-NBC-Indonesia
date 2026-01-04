<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Pembelian;
use App\Models\Sale;
use App\Models\SaleReturn; // <-- 1. Import model SaleReturn
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Utama
     * Mengumpulkan KPI (Penjualan, Retur, Valuasi), Grafik Tren, 
     * Stok Rendah, dan Aktivitas Terbaru untuk ringkasan operasional.
     */
    public function index()
    {
        // === 1. Data untuk Kartu Statistik Utama (KPI Cards) ===

        // Penjualan & Retur Hari Ini
        $todaySales = Sale::whereDate('sale_date', today())->sum('grand_total');
        $todayReturns = SaleReturn::whereDate('return_date', today())->sum('total_returned_amount'); // <-- Hitung retur hari ini
        $netTodaySales = $todaySales - $todayReturns; // <-- Hitung penjualan bersih
        $todayTransactionsCount = Sale::whereDate('sale_date', today())->count();

        // Pembelian Bulan Ini
        $thisMonthPurchases = Pembelian::whereMonth('purchase_date', now()->month)
                                      ->whereYear('purchase_date', now()->year)
                                      ->sum('total_amount');
        $thisMonthPurchasesCount = Pembelian::whereMonth('purchase_date', now()->month)
                                           ->whereYear('purchase_date', now()->year)
                                           ->count();

        // Total Produk & Kategori
        $totalItems = Item::count();
        $totalCategories = Category::count();


        // === 2. Data untuk Grafik (Charts) ===

        // Grafik Penjualan Bersih 7 Hari Terakhir
        $salesData = [];
        $salesLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $salesLabels[] = $date->isoFormat('dd, DD MMM');
            // Kalkulasi penjualan bersih untuk setiap hari di grafik
            $dailyGrossSales = Sale::whereDate('sale_date', $date)->sum('grand_total');
            $dailyTotalReturns = SaleReturn::whereDate('return_date', $date)->sum('total_returned_amount');
            $salesData[] = $dailyGrossSales - $dailyTotalReturns;
        }

        // Grafik Distribusi Stok
        $categoryDistribution = Category::with(['items' => function($q) {
            $q->select('id', 'category_id', 'stock');
        }])->get()->mapWithKeys(function ($category) {
            $totalStock = $category->items->sum('stock');
            return [$category->name => $totalStock];
        });

        $totalStockAll = $categoryDistribution->sum();
        $categoryDistribution = $categoryDistribution->map(function ($stock) use ($totalStockAll) {
            return $totalStockAll > 0 ? ($stock / $totalStockAll) * 100 : 0;
        });
        
        $categoryColors = ['#0d6efd', '#fd7e14', '#198754', '#6c757d', '#dc3545', '#ffc107', '#0dcaf0'];


        // === 3. Data untuk Tabel Informasi ===
        
        // Stok Hampir Habis
        $lowStockItems = Item::with('category')->where('stock', '<=', 10)->orderBy('stock', 'asc')->take(5)->get();

        // Transaksi Terakhir
        $recentTransactions = Sale::with('items')->latest()->take(5)->get();

        // Produk Terlaris (Top Selling) - 30 hari terakhir
        $topSellingItems = \App\Models\SaleItem::select('item_id', \DB::raw('SUM(quantity) as total_qty'))
            ->whereHas('sale', fn($q) => $q->where('sale_date', '>=', now()->subDays(30)))
            ->groupBy('item_id')
            ->orderBy('total_qty', 'desc')
            ->with('item')
            ->take(5)
            ->get();

        // Aktivitas Terbaru
        $recentActivity = \App\Models\ActivityLog::with('user')->latest()->take(5)->get();

        // === 4. Data Tekstil Lanjutan (Yield & Konsumsi) ===
        
        // Yield Produksi (Efisiensi) - 30 hari terakhir
        $completedProductions = \App\Models\Production::where('status', 'completed')
            ->where('end_date', '>=', now()->subDays(30))
            ->get();
        
        $totalPlanned = $completedProductions->sum('qty_planned');
        $totalActual = $completedProductions->sum('qty_actual');
        $productionYield = $totalPlanned > 0 ? ($totalActual / $totalPlanned) * 100 : 100;

        // Total Valuasi Seluruh Produk
        $totalValuation = Item::all()->sum(function($item) {
            return $item->stock * ($item->purchase_price ?? 0);
        });

        // Bahan Baku Slow Moving (Dead Stock) - 0 Sales dalam 90 hari terakhir & stok > 0
        $slowMovingItems = Item::where('stock', '>', 0)
            ->whereDoesntHave('saleItems', function($q) {
                $q->whereHas('sale', fn($s) => $s->where('sale_date', '>=', now()->subDays(90)));
            })
            ->with(['category', 'unit'])
            ->take(5)
            ->get();

        // Top Konsumsi Bahan Baku (Raw Materials) - 30 hari terakhir
        $topConsumption = \App\Models\ProductionMaterial::select('item_id', \DB::raw('SUM(qty_used) as total_used'))
            ->whereHas('production', fn($q) => $q->where('status', 'completed')->where('end_date', '>=', now()->subDays(30)))
            ->groupBy('item_id')
            ->orderBy('total_used', 'desc')
            ->with(['item.unit'])
            ->take(5)
            ->get();

        // === 5. Kirim semua data ke view ===
        return view('dashboard.index', compact(
            'netTodaySales',
            'todayTransactionsCount',
            'todayReturns',
            'thisMonthPurchases',
            'thisMonthPurchasesCount',
            'totalItems',
            'totalCategories',
            'lowStockItems',
            'recentTransactions',
            'salesData',
            'salesLabels',
            'categoryDistribution',
            'categoryColors',
            'topSellingItems',
            'recentActivity',
            'productionYield',
            'topConsumption',
            'totalValuation',
            'slowMovingItems'
        ));
    }
}
