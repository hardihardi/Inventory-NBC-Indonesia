<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Pembelian;
use App\Models\Expense;
use App\Models\CashFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function dashboard(Request $request)
    {
        $startDate = $request->query('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->query('end_date', now()->format('Y-m-d'));

        // Totals based on Period
        $totalCashIn = CashFlow::where('type', 'in')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');
        $totalCashOut = CashFlow::where('type', 'out')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');
        
        // Final Balance (All time)
        $currentBalance = CashFlow::where('type', 'in')->sum('amount') - CashFlow::where('type', 'out')->sum('amount');

        // Net Movement for Period
        $netProfit = $totalCashIn - $totalCashOut;

        // Piutang (Receivables) - All time total but specific overdue
        $totalPiutang = Sale::where('payment_status', '!=', 'paid')
            ->selectRaw('SUM(grand_total - paid_amount) as total')
            ->first()->total ?? 0;
            
        $overduePiutang = Sale::where('payment_status', '!=', 'paid')
            ->where('due_date', '<', now())
            ->selectRaw('SUM(grand_total - paid_amount) as total')
            ->first()->total ?? 0;

        // Hutang (Debt) - All time total but specific overdue
        $totalHutang = Pembelian::where('payment_status', '!=', 'paid')
            ->selectRaw('SUM(total_amount - paid_amount) as total')
            ->first()->total ?? 0;
            
        $overdueHutang = Pembelian::where('payment_status', '!=', 'paid')
            ->where('due_date', '<', now())
            ->selectRaw('SUM(total_amount - paid_amount) as total')
            ->first()->total ?? 0;

        // Recent Cash Flow
        $recentCashFlows = CashFlow::latest()->take(10)->get();

        // Expense Categorization (Doughnut Chart Data)
        $expenseBreakdown = CashFlow::where('type', 'out')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();

        // Monthly Data for Chart (last 6 months - standardized)
        $monthlyCashFlow = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthKey = $date->format('Y-m');
            
            $in = CashFlow::where('type', 'in')->whereRaw('DATE_FORMAT(transaction_date, "%Y-%m") = ?', [$monthKey])->sum('amount');
            $out = CashFlow::where('type', 'out')->whereRaw('DATE_FORMAT(transaction_date, "%Y-%m") = ?', [$monthKey])->sum('amount');
            
            $monthlyCashFlow->push([
                'month' => $monthKey,
                'label' => $date->translatedFormat('M Y'),
                'in' => $in,
                'out' => $out
            ]);
        }

        // Top Overdue Receivables
        $topReceivables = Sale::where('payment_status', '!=', 'paid')
            ->where('due_date', '<', now())
            ->with('customer')
            ->orderBy('due_date', 'asc')
            ->take(5)
            ->get();

        // Top Overdue Payables
        $topPayables = Pembelian::where('payment_status', '!=', 'paid')
            ->where('due_date', '<', now())
            ->with('supplier')
            ->orderBy('due_date', 'asc')
            ->take(5)
            ->get();

        return view('finance.dashboard', compact(
            'totalCashIn', 'totalCashOut', 'currentBalance', 'netProfit',
            'totalPiutang', 'totalHutang', 'recentCashFlows', 'monthlyCashFlow',
            'overduePiutang', 'overdueHutang', 'expenseBreakdown',
            'topReceivables', 'topPayables', 'startDate', 'endDate'
        ));
    }

    public function cashFlow(Request $request)
    {
        $query = CashFlow::with('user')->latest('transaction_date');

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $cashFlows = $query->paginate(20);

        return view('finance.cash_flow', compact('cashFlows'));
    }

    public function receivables()
    {
        $receivables = Sale::where('payment_status', '!=', 'paid')
            ->with('customer')
            ->latest('sale_date')
            ->paginate(15);
            
        return view('finance.receivables', compact('receivables'));
    }

    public function payables()
    {
        $payables = Pembelian::where('payment_status', '!=', 'paid')
            ->with('supplier')
            ->latest('purchase_date')
            ->paginate(15);
            
        return view('finance.payables', compact('payables'));
    }
}
