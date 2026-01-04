<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return redirect()->back();
        }

        $items = Item::where('name', 'like', "%$query%")
            ->orWhere('product_code', 'like', "%$query%")
            ->orWhere('sku', 'like', "%$query%")
            ->limit(10)->get();

        $customers = Customer::where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->orWhere('phone', 'like', "%$query%")
            ->limit(10)->get();

        $suppliers = Supplier::where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->orWhere('phone', 'like', "%$query%")
            ->limit(10)->get();

        return view('search.results', compact('items', 'customers', 'suppliers', 'query'));
    }
}
