<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('master.customers.index', compact('customers'));
    }

    public function create()
    {
        $categories = Customer::getCategories();
        return view('master.customers.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'category' => 'required|string|max:50',
            'other_category' => 'nullable|string|max:50|required_if:category,Other',
        ]);

        if ($validated['category'] === 'Other' && !empty($validated['other_category'])) {
            $validated['category'] = $validated['other_category'];
        }
        unset($validated['other_category']);

        Customer::create($validated);

        return redirect()->route('inventory.customers.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function show(Customer $customer)
    {
        $customer->load('sales.items');
        return view('master.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $categories = Customer::getCategories();
        return view('master.customers.edit', compact('customer', 'categories'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'category' => 'required|string|max:50',
            'other_category' => 'nullable|string|max:50|required_if:category,Other',
        ]);

        if ($validated['category'] === 'Other' && !empty($validated['other_category'])) {
            $validated['category'] = $validated['other_category'];
        }
        unset($validated['other_category']);

        $customer->update($validated);

        return redirect()->route('inventory.customers.index')->with('success', 'Pelanggan berhasil diperbarui!');
    }

    public function destroy(Request $request, Customer $customer)
    {
        // Cek jika ada riwayat transaksi
        if ($customer->sales()->exists()) {
            $msg = 'Pelanggan tidak bisa dihapus karena memiliki riwayat transaksi.';
            if ($request->ajax()) {
                return response()->json(['error' => $msg], 422);
            }
            return redirect()->back()->with('error', $msg);
        }

        $customer->delete();
        
        if ($request->ajax()) {
            return response()->json(['success' => 'Pelanggan berhasil dihapus!']);
        }
        return redirect()->route('inventory.customers.index')->with('success', 'Pelanggan berhasil dihapus!');
    }
}
