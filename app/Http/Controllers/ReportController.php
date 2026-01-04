<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Pembelian;
use App\Models\Category;
use App\Models\SaleReturn;
use App\Models\ReturPembelian;
use App\Models\SaleItem;
use App\Models\SaleReturnItem;
use App\Models\PembelianItem;
use App\Models\ReturPembelianItem;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CompanySetting;

class ReportController extends Controller
{
    /**
     * Mendapatkan ID kategori berdasarkan tipe.
     */
    private function getCategoryIdsByType(): array
    {
        return [
            'textile' => Category::whereIn('type', ['yarn', 'fabric'])->pluck('id'),
            'penunjang' => Category::whereIn('type', ['chemical', 'dyestuff', 'sparepart', 'general'])->pluck('id'),
        ];
    }

    public function dailySales(Request $request)
    {
        $filterDate = $request->input('date', today()->toDateString());
        $categoryIds = $this->getCategoryIdsByType();

        // Penjualan Kotor
        $grossSalesTextile = SaleItem::whereHas('sale', fn($q) => $q->whereDate('sale_date', $filterDate))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['textile']))
            ->sum('subtotal');
        $grossSalesPenunjang = SaleItem::whereHas('sale', fn($q) => $q->whereDate('sale_date', $filterDate))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['penunjang']))
            ->sum('subtotal');

        // Retur Penjualan
        $dailyReturnsTextile = SaleReturnItem::whereHas('saleReturn', fn($q) => $q->whereDate('return_date', $filterDate))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['textile']))
            ->sum('subtotal');
        $dailyReturnsPenunjang = SaleReturnItem::whereHas('saleReturn', fn($q) => $q->whereDate('return_date', $filterDate))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['penunjang']))
            ->sum('subtotal');

        $totalDailyReturns = $dailyReturnsTextile + $dailyReturnsPenunjang;
        $netSalesTextile = $grossSalesTextile - $dailyReturnsTextile;
        $netSalesPenunjang = $grossSalesPenunjang - $dailyReturnsPenunjang;
        $totalNetDailySales = $netSalesTextile + $netSalesPenunjang;

        $salesToday = Sale::whereDate('sale_date', $filterDate)->with(['user', 'items.item.category', 'items.item.unit'])->get();

        return view('reports.daily_sales_categorized', compact(
            'netSalesTextile', 'netSalesPenunjang', 'totalDailyReturns', 'totalNetDailySales', 'salesToday', 'filterDate'
        ));
    }

    public function monthlySales(Request $request)
    {
        $filterMonth = $request->input('month', now()->month);
        $filterYear = $request->input('year', now()->year);
        $categoryIds = $this->getCategoryIdsByType();
        
        // Penjualan Kotor
        $grossSalesTextile = SaleItem::whereHas('sale', fn($q) => $q->whereMonth('sale_date', $filterMonth)->whereYear('sale_date', $filterYear))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['textile']))->sum('subtotal');
        $grossSalesPenunjang = SaleItem::whereHas('sale', fn($q) => $q->whereMonth('sale_date', $filterMonth)->whereYear('sale_date', $filterYear))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['penunjang']))->sum('subtotal');

        // Retur Penjualan
        $monthlyReturnsTextile = SaleReturnItem::whereHas('saleReturn', fn($q) => $q->whereMonth('return_date', $filterMonth)->whereYear('return_date', $filterYear))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['textile']))->sum('subtotal');
        $monthlyReturnsPenunjang = SaleReturnItem::whereHas('saleReturn', fn($q) => $q->whereMonth('return_date', $filterMonth)->whereYear('return_date', $filterYear))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['penunjang']))->sum('subtotal');

        $totalMonthlyReturns = $monthlyReturnsTextile + $monthlyReturnsPenunjang;
        $netSalesTextile = $grossSalesTextile - $monthlyReturnsTextile;
        $netSalesPenunjang = $grossSalesPenunjang - $monthlyReturnsPenunjang;
        $totalNetMonthlySales = $netSalesTextile + $netSalesPenunjang;

        $salesThisMonth = Sale::whereMonth('sale_date', $filterMonth)->whereYear('sale_date', $filterYear)->with(['user', 'items.item.category'])->get();

        return view('reports.monthly_sales_categorized', compact(
            'netSalesTextile', 'netSalesPenunjang', 'totalMonthlyReturns', 'totalNetMonthlySales', 'salesThisMonth', 'filterMonth', 'filterYear'
        ));
    }

    public function profitLoss(Request $request)
    {
        $filterMonth = $request->input('month', now()->month);
        $filterYear = $request->input('year', now()->year);
        $categoryIds = $this->getCategoryIdsByType();
        $company = CompanySetting::first();

        // 1. PENDAPATAN (Sales)
        $penjualanTextile = SaleItem::whereHas('sale', fn($q) => $q->whereMonth('sale_date', $filterMonth)->whereYear('sale_date', $filterYear))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['textile']))->sum('subtotal');
        $penjualanPenunjang = SaleItem::whereHas('sale', fn($q) => $q->whereMonth('sale_date', $filterMonth)->whereYear('sale_date', $filterYear))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['penunjang']))->sum('subtotal');

        $returPenjualan = SaleReturnItem::whereHas('saleReturn', fn($q) => $q->whereMonth('return_date', $filterMonth)->whereYear('return_date', $filterYear))
            ->sum('subtotal');
        
        $totalPendapatanBersih = ($penjualanTextile + $penjualanPenunjang) - $returPenjualan;
        
        // 2. HPP (COGS - Manufacturing Style)
        $materialUsageCost = 0;
        $completedProductions = \App\Models\Production::where('status', 'completed')
            ->whereMonth('end_date', $filterMonth)
            ->whereYear('end_date', $filterYear)
            ->with('materials.item')
            ->get();

        foreach ($completedProductions as $prod) {
            foreach ($prod->materials as $mat) {
                $used = $mat->qty_used > 0 ? $mat->qty_used : $mat->qty_needed;
                $materialUsageCost += ($used * ($mat->item->purchase_price ?? 0));
            }
        }

        // 3. OPERATIONAL EXPENSES
        $expenses = \App\Models\Expense::whereMonth('expense_date', $filterMonth)
            ->whereYear('expense_date', $filterYear)
            ->with('category')
            ->get();
        
        $totalExpenses = $expenses->sum('amount');
        $expenseGroups = $expenses->groupBy('category.name')->map->sum('amount');

        // Perhitungan
        $labaKotor = $totalPendapatanBersih - $materialUsageCost;
        $labaRugiBersih = $labaKotor - $totalExpenses;

        return view('reports.profit_loss_categorized', compact(
            'filterMonth', 'filterYear', 'penjualanTextile', 'penjualanPenunjang', 
            'returPenjualan', 'totalPendapatanBersih', 'materialUsageCost', 
            'labaKotor', 'totalExpenses', 'expenseGroups', 'labaRugiBersih', 'company'
        ));
    }

    public function printDailySales(Request $request)
    {
        $filterDate = $request->input('date', today()->toDateString());
        $categoryIds = $this->getCategoryIdsByType();
        $company = CompanySetting::first();

        $grossSalesTextile = SaleItem::whereHas('sale', fn($q) => $q->whereDate('sale_date', $filterDate))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['textile']))->sum('subtotal');
        $grossSalesPenunjang = SaleItem::whereHas('sale', fn($q) => $q->whereDate('sale_date', $filterDate))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['penunjang']))->sum('subtotal');

        $dailyReturnsTextile = SaleReturnItem::whereHas('saleReturn', fn($q) => $q->whereDate('return_date', $filterDate))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['textile']))->sum('subtotal');
        $dailyReturnsPenunjang = SaleReturnItem::whereHas('saleReturn', fn($q) => $q->whereDate('return_date', $filterDate))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['penunjang']))->sum('subtotal');

        $totalDailyReturns = $dailyReturnsTextile + $dailyReturnsPenunjang;
        $netSalesTextile = $grossSalesTextile - $dailyReturnsTextile;
        $netSalesPenunjang = $grossSalesPenunjang - $dailyReturnsPenunjang;
        $totalNetDailySales = $netSalesTextile + $netSalesPenunjang;

        $salesToday = Sale::whereDate('sale_date', $filterDate)->with(['user', 'items.item.category', 'items.item.unit'])->latest()->get();

        $data = compact('netSalesTextile', 'netSalesPenunjang', 'totalDailyReturns', 'totalNetDailySales', 'salesToday', 'filterDate', 'company');
        
        $pdf = Pdf::loadView('reports.print.daily_sales', $data);
        return $pdf->stream('laporan-penjualan-harian-' . $filterDate . '.pdf');
    }

    public function printMonthlySales(Request $request)
    {
        $filterMonth = $request->input('month', now()->month);
        $filterYear = $request->input('year', now()->year);
        $categoryIds = $this->getCategoryIdsByType();
        $company = CompanySetting::first();
        
        $grossSalesTextile = SaleItem::whereHas('sale', fn($q) => $q->whereMonth('sale_date', $filterMonth)->whereYear('sale_date', $filterYear))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['textile']))->sum('subtotal');
        $grossSalesPenunjang = SaleItem::whereHas('sale', fn($q) => $q->whereMonth('sale_date', $filterMonth)->whereYear('sale_date', $filterYear))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['penunjang']))->sum('subtotal');

        $monthlyReturnsTextile = SaleReturnItem::whereHas('saleReturn', fn($q) => $q->whereMonth('return_date', $filterMonth)->whereYear('return_date', $filterYear))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['textile']))->sum('subtotal');
        $monthlyReturnsPenunjang = SaleReturnItem::whereHas('saleReturn', fn($q) => $q->whereMonth('return_date', $filterMonth)->whereYear('return_date', $filterYear))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['penunjang']))->sum('subtotal');

        $totalMonthlyReturns = $monthlyReturnsTextile + $monthlyReturnsPenunjang;
        $netSalesTextile = $grossSalesTextile - $monthlyReturnsTextile;
        $netSalesPenunjang = $grossSalesPenunjang - $monthlyReturnsPenunjang;
        $totalNetMonthlySales = $netSalesTextile + $netSalesPenunjang;

        $salesThisMonth = Sale::whereMonth('sale_date', $filterMonth)->whereYear('sale_date', $filterYear)->with(['user', 'items.item'])->latest()->get();

        $data = compact('netSalesTextile', 'netSalesPenunjang', 'totalMonthlyReturns', 'totalNetMonthlySales', 'salesThisMonth', 'filterMonth', 'filterYear', 'company');

        $pdf = Pdf::loadView('reports.print.monthly_sales', $data);
        return $pdf->stream('laporan-penjualan-bulanan-' . $filterYear . '-' . $filterMonth . '.pdf');
    }

    public function printProfitLoss(Request $request)
    {
        $filterMonth = $request->input('month', now()->month);
        $filterYear = $request->input('year', now()->year);
        $categoryIds = $this->getCategoryIdsByType();
        $company = CompanySetting::first();

        // 1. PENDAPATAN
        $penjualanTextile = SaleItem::whereHas('sale', fn($q) => $q->whereMonth('sale_date', $filterMonth)->whereYear('sale_date', $filterYear))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['textile']))->sum('subtotal');
        $penjualanPenunjang = SaleItem::whereHas('sale', fn($q) => $q->whereMonth('sale_date', $filterMonth)->whereYear('sale_date', $filterYear))
            ->whereHas('item', fn($q) => $q->whereIn('category_id', $categoryIds['penunjang']))->sum('subtotal');

        $returPenjualan = SaleReturnItem::whereHas('saleReturn', fn($q) => $q->whereMonth('return_date', $filterMonth)->whereYear('return_date', $filterYear))
            ->sum('subtotal');
        
        $totalPendapatanBersih = ($penjualanTextile + $penjualanPenunjang) - $returPenjualan;
        
        // 2. HPP (Material Usage)
        $materialUsageCost = 0;
        $completedProductions = \App\Models\Production::where('status', 'completed')
            ->whereMonth('end_date', $filterMonth)
            ->whereYear('end_date', $filterYear)
            ->with('materials.item')
            ->get();

        foreach ($completedProductions as $prod) {
            foreach ($prod->materials as $mat) {
                $used = $mat->qty_used > 0 ? $mat->qty_used : $mat->qty_needed;
                $materialUsageCost += ($used * ($mat->item->purchase_price ?? 0));
            }
        }

        // 3. EXPENSES
        $expenses = \App\Models\Expense::whereMonth('expense_date', $filterMonth)
            ->whereYear('expense_date', $filterYear)
            ->with('category')
            ->get();
        
        $totalExpenses = $expenses->sum('amount');
        $expenseGroups = $expenses->groupBy('category.name')->map->sum('amount');

        $labaKotor = $totalPendapatanBersih - $materialUsageCost;
        $labaRugiBersih = $labaKotor - $totalExpenses;

        $data = compact(
            'filterMonth', 'filterYear', 'penjualanTextile', 'penjualanPenunjang', 
            'returPenjualan', 'totalPendapatanBersih', 'materialUsageCost', 
            'labaKotor', 'totalExpenses', 'expenseGroups', 'labaRugiBersih', 'company'
        );

        $pdf = Pdf::loadView('reports.print.profit_loss', $data);
        return $pdf->stream('laporan-laba-rugi-' . $filterYear . '-' . $filterMonth . '.pdf');
    }

    /**
     * Laporan Analisis Perputaran Stok (Slow & Fast Moving).
     * Membantu Manajer menentukan strategi pengadaan.
     */
    public function turnover(Request $request)
    {
        $days = $request->query('days', 90);
        $startDate = now()->subDays($days);
        
        // 1. Fast Moving (Berdasarkan Volume Penjualan Tertinggi)
        $fastMoving = \App\Models\Item::with(['category', 'unit'])
            ->withCount(['saleItems as total_sold' => function($q) use ($startDate) {
                $q->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                  ->where('sales.sale_date', '>=', $startDate)
                  ->select(\DB::raw('SUM(quantity)'));
            }])
            ->having('total_sold', '>', 0)
            ->orderBy('total_sold', 'desc')
            ->take(20)
            ->get();

        // 2. Slow Moving (Stok > 0 tapi tidak terjual dalam X hari)
        $slowMoving = \App\Models\Item::with(['category', 'unit'])
            ->where('stock', '>', 0)
            ->whereDoesntHave('saleItems', function($q) use ($startDate) {
                $q->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                  ->where('sales.sale_date', '>=', $startDate);
            })
            ->orderBy('stock', 'desc')
            ->take(20)
            ->get();

        return view('reports.turnover', compact('fastMoving', 'slowMoving', 'days'));
    }
}