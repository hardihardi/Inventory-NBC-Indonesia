<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLog;

class TrashController extends Controller
{
    /**
     * Menampilkan daftar data yang dihapus (Soft Deletes).
     */
    public function index(Request $request)
    {
        $type = $request->query('type', 'item');
        $data = [];

        switch ($type) {
            case 'item':
                $data = \App\Models\Item::onlyTrashed()->with(['category', 'unit'])->latest('deleted_at')->paginate(15);
                break;
            case 'category':
                $data = \App\Models\Category::onlyTrashed()->latest('deleted_at')->paginate(15);
                break;
            case 'customer':
                $data = \App\Models\Customer::onlyTrashed()->latest('deleted_at')->paginate(15);
                break;
            case 'supplier':
                $data = \App\Models\Supplier::onlyTrashed()->latest('deleted_at')->paginate(15);
                break;
            case 'sale':
                $data = \App\Models\Sale::onlyTrashed()->with('customer')->latest('deleted_at')->paginate(15);
                break;
            case 'pembelian':
                $data = \App\Models\Pembelian::onlyTrashed()->with('supplier')->latest('deleted_at')->paginate(15);
                break;
            case 'production':
                $data = \App\Models\Production::onlyTrashed()->with('item')->latest('deleted_at')->paginate(15);
                break;
            case 'warehouse':
                $data = \App\Models\Warehouse::onlyTrashed()->latest('deleted_at')->paginate(15);
                break;
            case 'sale_return':
                $data = \App\Models\SaleReturn::onlyTrashed()->with('sale')->latest('deleted_at')->paginate(15);
                break;
            case 'retur_pembelian':
                $data = \App\Models\ReturPembelian::onlyTrashed()->with('pembelian.supplier')->latest('deleted_at')->paginate(15);
                break;
            case 'expense':
                $data = \App\Models\Expense::onlyTrashed()->with('category')->latest('deleted_at')->paginate(15);
                break;
        }

        return view('settings.trash.index', compact('data', 'type'));
    }

    /**
     * Memulihkan data yang dihapus.
     */
    public function restore($type, $id)
    {
        try {
            DB::beginTransaction();
            $modelClass = $this->getModelClass($type);
            $record = $modelClass::onlyTrashed()->findOrFail($id);
            $record->restore();

            ActivityLog::log('Restore Data', "Memulihkan data " . ucfirst($type) . ": " . ($record->name ?? $record->code ?? $record->invoice_number ?? $id));
            
            DB::commit();
            return back()->with('success', 'Data berhasil dipulihkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memulihkan data: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data secara permanen.
     */
    public function forceDelete($type, $id)
    {
        try {
            DB::beginTransaction();
            $modelClass = $this->getModelClass($type);
            $record = $modelClass::onlyTrashed()->findOrFail($id);
            
            $name = ($record->name ?? $record->code ?? $record->invoice_number ?? $id);
            $record->forceDelete();

            ActivityLog::log('Hapus Permanen', "Menghapus permanen " . ucfirst($type) . ": " . $name);
            
            DB::commit();
            return back()->with('success', 'Data dihapus secara permanen.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data secara permanen: ' . $e->getMessage());
        }
    }

    private function getModelClass($type)
    {
        return [
            'item' => \App\Models\Item::class,
            'category' => \App\Models\Category::class,
            'customer' => \App\Models\Customer::class,
            'supplier' => \App\Models\Supplier::class,
            'sale' => \App\Models\Sale::class,
            'pembelian' => \App\Models\Pembelian::class,
            'production' => \App\Models\Production::class,
            'warehouse' => \App\Models\Warehouse::class,
            'sale_return' => \App\Models\SaleReturn::class,
            'retur_pembelian' => \App\Models\ReturPembelian::class,
            'expense' => \App\Models\Expense::class,
        ][$type] ?? abort(404);
    }
}
