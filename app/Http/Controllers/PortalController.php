<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Pembelian;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortalController extends Controller
{
    public function supplierDashboard()
    {
        $user = Auth::user();
        $supplier = Supplier::where('email', $user->email)->first();

        if (!$supplier) {
            return redirect()->route('dashboard')->with('error', 'Supplier record not found for your email.');
        }

        $purchases = Pembelian::where('supplier_id', $supplier->id)->latest()->take(10)->get();
        $totalPurchases = Pembelian::where('supplier_id', $supplier->id)->sum('total_amount');
        $pendingPurchases = Pembelian::where('supplier_id', $supplier->id)->where('status', 'pending')->count();

        return view('portal.supplier.dashboard', compact('supplier', 'purchases', 'totalPurchases', 'pendingPurchases'));
    }

    public function customerDashboard()
    {
        $user = Auth::user();
        $customer = Customer::where('email', $user->email)->first();

        if (!$customer) {
            return redirect()->route('dashboard')->with('error', 'Customer record not found for your email.');
        }

        $sales = Sale::where('customer_id', $customer->id)->latest()->take(10)->get();
        $totalSpent = Sale::where('customer_id', $customer->id)->sum('grand_total');
        $unpaidSales = Sale::where('customer_id', $customer->id)->where('payment_status', 'unpaid')->count();

        return view('portal.customer.dashboard', compact('customer', 'sales', 'totalSpent', 'unpaidSales'));
    }
}
