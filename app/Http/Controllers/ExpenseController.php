<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Expense::with(['category', 'user'])->latest('expense_date');

        // Filter by Date Range
        if ($request->has(['start_date', 'end_date'])) {
            $query->whereBetween('expense_date', [$request->start_date, $request->end_date]);
        }

        // Filter by Category
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $expenses = $query->paginate(15);
        
        $categories = ExpenseCategory::all(); // For filter dropdown

        return view('finance.expenses.index', compact('expenses', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ExpenseCategory::all();
        return view('finance.expenses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'expense_date' => 'required|date',
            'category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'proof_image' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $data = $request->except('proof_image');
        $data['user_id'] = Auth::id();

        // Handle Image Upload
        if ($request->hasFile('proof_image')) {
            $path = $request->file('proof_image')->store('expenses', 'public');
            $data['proof_image'] = $path;
        }

        $expense = Expense::create($data);

        // Record Cash Flow
        \App\Models\CashFlow::create([
            'type' => 'out',
            'amount' => $expense->amount,
            'transaction_date' => $expense->expense_date,
            'category' => 'Biaya Operasional',
            'reference_type' => 'Expense',
            'reference_id' => $expense->id,
            'notes' => 'Pengeluaran: ' . $expense->description,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('finance.expenses.index')->with('success', 'Pengeluaran berhasil dicatat.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            if ($expense->proof_image) {
                Storage::disk('public')->delete($expense->proof_image);
            }
            
            // Delete related cash flow
            $expense->cashFlows()->delete();
            
            $expense->delete();

            \Illuminate\Support\Facades\DB::commit();
            
            if (request()->ajax()) {
                return response()->json(['success' => 'Pengeluaran berhasil dihapus.']);
            }
            return redirect()->route('finance.expenses.index')->with('success', 'Pengeluaran berhasil dihapus.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            if (request()->ajax()) {
                return response()->json(['error' => 'Gagal menghapus pengeluaran: ' . $e->getMessage()], 500);
            }
            return redirect()->route('finance.expenses.index')->with('error', 'Gagal menghapus pengeluaran: ' . $e->getMessage());
        }
    }
}
