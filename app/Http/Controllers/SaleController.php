<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Item;
use App\Models\Customer;
use App\Models\Warehouse;
use App\Models\WarehouseStock;
use App\Models\StockLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;
use App\Imports\SalesImport;

class SaleController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi penjualan.
     */
    public function index(Request $request)
    {
        $query = Sale::with('user', 'items', 'customer')
            ->when($request->start_date, function ($query, $startDate) {
                return $query->whereDate('sale_date', '>=', $startDate);
            })
            ->when($request->end_date, function ($query, $endDate) {
                return $query->whereDate('sale_date', '<=', $endDate);
            })
            ->when($request->payment_method, function ($query, $paymentMethod) {
                return $query->where('payment_method', $paymentMethod);
            })
            ->latest();

        // PERUBAHAN DI SINI: Ganti paginate(10) menjadi get()
        // Ini akan mengirim SEMUA data ke view agar bisa dikelola oleh DataTables
        $sales = $query->get();
        
        return view('penjualan.transaksi.index', compact('sales'));
    }

    /**
     * Menampilkan form untuk membuat transaksi penjualan baru (halaman POS).
     */
    public function create()
    {
        $items = Item::where('stock', '>', 0)
                     ->orderBy('name')
                     ->get();
        $customers = Customer::orderBy('name')->get();
        return view('penjualan.transaksi.create', compact('items', 'customers'));
    }

    /**
     * Menyimpan transaksi penjualan baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price_per_unit' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,transfer',
            'paid_amount' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            $saleItemsData = [];
            $itemsToUpdateStock = [];

            $defaultWarehouse = Warehouse::where('is_default', true)->first() ?? Warehouse::first();

            foreach ($validated['items'] as $itemId => $itemData) {
                $item = Item::find($itemData['item_id']);
                if (!$item) {
                    throw ValidationException::withMessages([ 'items.' . $itemId => 'Item tidak ditemukan.']);
                }

                if ($item->stock < $itemData['quantity']) {
                    throw ValidationException::withMessages(['items.' . $itemId . '.quantity' => 'Stok ' . $item->name . ' tidak mencukupi. Tersedia: ' . $item->stock]);
                }

                $subtotal = $itemData['price_per_unit'] * $itemData['quantity'];
                $totalAmount += $subtotal;

                $saleItemsData[] = [
                    'item_id' => $item->id,
                    'item_name' => $item->name,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['price_per_unit'],
                    'subtotal' => $subtotal,
                ];

                $itemsToUpdateStock[$item->id] = $item->stock - $itemData['quantity'];
            }

            $discountAmount = $validated['discount_amount'] ?? 0;
            $taxAmount = $validated['tax_amount'] ?? 0;
            $grandTotal = $totalAmount - $discountAmount + $taxAmount;

            // Determinisasi Status Pembayaran
            $paymentStatus = 'paid';
            if ($validated['paid_amount'] == 0) {
                $paymentStatus = 'credit';
            } elseif ($validated['paid_amount'] < $grandTotal) {
                $paymentStatus = 'partial';
            }

            $sale = Sale::create([
                'invoice_number' => $this->generateInvoiceNumber(),
                'sale_date' => now(),
                'customer_id' => $validated['customer_id'] ?? null,
                'customer_name' => $validated['customer_name'] ?? 'Umum',
                'total_amount' => $totalAmount,
                'discount_amount' => $discountAmount,
                'tax_amount' => $taxAmount,
                'grand_total' => $grandTotal,
                'payment_method' => $validated['payment_method'],
                'paid_amount' => $validated['paid_amount'],
                'change_amount' => $validated['paid_amount'] > $grandTotal ? $validated['paid_amount'] - $grandTotal : 0,
                'payment_status' => $paymentStatus,
                'due_date' => $request->due_date,
                'user_id' => Auth::id(),
                'notes' => $request->notes,
            ]);

            $sale->items()->createMany($saleItemsData);

            // Record Cash Flow if there is payment
            if ($validated['paid_amount'] > 0) {
                \App\Models\CashFlow::create([
                    'type' => 'in',
                    'amount' => min($validated['paid_amount'], $grandTotal),
                    'transaction_date' => now(),
                    'category' => 'Penjualan',
                    'reference_type' => 'Sale',
                    'reference_id' => $sale->id,
                    'notes' => 'Pembayaran ' . $sale->invoice_number,
                    'user_id' => Auth::id()
                ]);
            }

            foreach ($itemsToUpdateStock as $itemId => $qtyToSubtract) {
                $item = Item::find($itemId);
                $item->decrement('stock', $qtyToSubtract);
                
                // Update Warehouse Stock
                $ws = WarehouseStock::firstOrCreate(
                    ['item_id' => $itemId, 'warehouse_id' => $defaultWarehouse->id],
                    ['stock' => $item->stock + $qtyToSubtract] // qty before
                );
                $ws->decrement('stock', $qtyToSubtract);

                // Log Stock Ledger
                StockLedger::log(
                    $itemId,
                    $defaultWarehouse->id,
                    -$qtyToSubtract,
                    $ws->fresh()->stock,
                    'out',
                    $sale->id,
                    Sale::class,
                    "Penjualan {$sale->invoice_number}"
                );
            }

            DB::commit(); 

            return redirect()->route('penjualan.transaksi.show', $sale)->with('success', 'Transaksi penjualan berhasil dibuat!');
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses transaksi: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail transaksi penjualan.
     */
    public function show(Sale $transaksi)
    {
        $transaksi->load('user', 'items.item');
        return view('penjualan.transaksi.show', compact('transaksi'));
    }

    /**
     * Menampilkan form edit transaksi.
     */
    public function edit(Sale $transaksi)
    {
        $transaksi->load('items.item', 'customer');
        $items = Item::all();
        $customers = Customer::orderBy('name')->get();
        return view('penjualan.transaksi.edit', compact('transaksi', 'items', 'customers'));
    }

    /**
     * Memperbarui transaksi penjualan.
     */
    public function update(Request $request, Sale $transaksi)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price_per_unit' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,transfer',
            'paid_amount' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $defaultWarehouse = Warehouse::where('is_default', true)->first() ?? Warehouse::first();

            // 1. Revert OLD stock
            foreach ($transaksi->items as $oldItem) {
                $item = Item::find($oldItem->item_id);
                if ($item) {
                    $item->increment('stock', $oldItem->quantity);

                    // Update Warehouse Stock
                    $ws = WarehouseStock::firstOrCreate(
                        ['item_id' => $item->id, 'warehouse_id' => $defaultWarehouse->id],
                        ['stock' => $item->stock - $oldItem->quantity]
                    );
                    $ws->increment('stock', $oldItem->quantity);

                    // Log Stock Return (Reversion)
                    StockLedger::log(
                        $item->id,
                        $defaultWarehouse->id,
                        $oldItem->quantity,
                        $ws->fresh()->stock,
                        'return',
                        $transaksi->id,
                        Sale::class,
                        "Revisi Penjualan {$transaksi->invoice_number} (Revert)"
                    );
                }
            }
            // 2. Delete OLD items
            $transaksi->items()->delete();

            // 3. Process NEW items and subtract NEW stock (Same logic as store)
            $totalAmount = 0;
            $saleItemsData = [];
            
            foreach ($validated['items'] as $itemId => $itemData) {
                $item = Item::find($itemData['item_id']);
                if (!$item || $item->stock < $itemData['quantity']) {
                    throw ValidationException::withMessages(['items' => 'Stok ' . ($item->name ?? 'produk') . ' tidak mencukupi.']);
                }

                $subtotal = $itemData['price_per_unit'] * $itemData['quantity'];
                $totalAmount += $subtotal;

                $saleItemsData[] = [
                    'item_id' => $item->id,
                    'item_name' => $item->name,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['price_per_unit'],
                    'subtotal' => $subtotal,
                ];

                $item->decrement('stock', $itemData['quantity']);

                // Update Warehouse Stock
                $ws = WarehouseStock::firstOrCreate(
                    ['item_id' => $item->id, 'warehouse_id' => $defaultWarehouse->id],
                    ['stock' => $item->stock + $itemData['quantity']]
                );
                $ws->decrement('stock', $itemData['quantity']);

                // Log Stock Out (New)
                StockLedger::log(
                    $item->id,
                    $defaultWarehouse->id,
                    -$itemData['quantity'],
                    $ws->fresh()->stock,
                    'out',
                    $transaksi->id,
                    Sale::class,
                    "Revisi Penjualan {$transaksi->invoice_number} (New)"
                );
            }

            $discountAmount = $validated['discount_amount'] ?? 0;
            $taxAmount = $validated['tax_amount'] ?? 0;
            $grandTotal = $totalAmount - $discountAmount + $taxAmount;

            // Determinisasi Status Pembayaran
            $paymentStatus = 'paid';
            if ($validated['paid_amount'] == 0) {
                $paymentStatus = 'credit';
            } elseif ($validated['paid_amount'] < $grandTotal) {
                $paymentStatus = 'partial';
            }

            // 4. Update the Sale record
            $transaksi->update([
                'customer_id' => $validated['customer_id'] ?? null,
                'customer_name' => $validated['customer_name'] ?? 'Umum',
                'total_amount' => $totalAmount,
                'discount_amount' => $discountAmount,
                'tax_amount' => $taxAmount,
                'grand_total' => $grandTotal,
                'payment_method' => $validated['payment_method'],
                'paid_amount' => $validated['paid_amount'],
                'change_amount' => $validated['paid_amount'] > $grandTotal ? $validated['paid_amount'] - $grandTotal : 0,
                'payment_status' => $paymentStatus,
                'due_date' => $request->due_date,
                'notes' => $request->notes,
            ]);

            $transaksi->items()->createMany($saleItemsData);

            // Sync Cash Flow (simplest way: delete old and create new for this sale)
            \App\Models\CashFlow::where('reference_type', 'Sale')->where('reference_id', $transaksi->id)->delete();
            if ($validated['paid_amount'] > 0) {
                \App\Models\CashFlow::create([
                    'type' => 'in',
                    'amount' => min($validated['paid_amount'], $grandTotal),
                    'transaction_date' => now(),
                    'category' => 'Penjualan',
                    'reference_type' => 'Sale',
                    'reference_id' => $transaksi->id,
                    'notes' => 'Update Pembayaran ' . $transaksi->invoice_number,
                    'user_id' => Auth::id()
                ]);
            }

            DB::commit();
            return redirect()->route('penjualan.transaksi.show', $transaksi)->with('success', 'Transaksi berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui transaksi: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Helper function to generate a unique invoice number.
     */
    private function generateInvoiceNumber()
    {
        $latestSale = Sale::latest('id')->first();
        $today = now()->format('Ymd');
        $nextNumber = 1;

        if ($latestSale) {
            $lastInvoiceNumber = $latestSale->invoice_number;
            $lastDate = substr($lastInvoiceNumber, 4, 8);

            if ($lastDate === $today) {
                $lastNum = (int) substr($lastInvoiceNumber, -4);
                $nextNumber = $lastNum + 1;
            }
        }
        return 'INV-' . $today . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
    
    public function printReceipt(Sale $transaksi)
    {
        $transaksi->load('items', 'user');
        
        $storeSettings = [
            'store_name' => 'TB SOGOL ANUGRAH MANDIRI',
            'store_address' => 'Jl. Contoh No.123, Kota Anda',
            'store_phone' => '(021) 12345678',
            'store_email' => 'info@perusahaan.com'
        ];
        
        return view('penjualan.struk', [
            'sale' => $transaksi,
            'settings' => (object)$storeSettings,
            'is_print_view' => true
        ]);
    }

    /**
     * Menghapus transaksi penjualan dan mengembalikan stok.
     */
    public function destroy(Sale $transaksi)
    {
        DB::beginTransaction();
        try {
            $defaultWarehouse = Warehouse::where('is_default', true)->first() ?? Warehouse::first();

            // Revert stock for each item in the sale
            foreach ($transaksi->items as $saleItem) {
                $item = Item::find($saleItem->item_id);
                if ($item) {
                    $item->increment('stock', $saleItem->quantity);

                    // Update Warehouse Stock
                    $ws = WarehouseStock::firstOrCreate(
                        ['item_id' => $item->id, 'warehouse_id' => $defaultWarehouse->id],
                        ['stock' => $item->stock - $saleItem->quantity]
                    );
                    $ws->increment('stock', $saleItem->quantity);

                    // Log Stock Return
                    StockLedger::log(
                        $item->id,
                        $defaultWarehouse->id,
                        $saleItem->quantity,
                        $ws->fresh()->stock,
                        'return',
                        $transaksi->id,
                        Sale::class,
                        "Hapus Penjualan {$transaksi->invoice_number}"
                    );
                }
            }

            // Delete the sale (cascading delete if configured, or manual delete of items)
            // Assuming no automatic cascading for simplicity of demonstration
            $transaksi->items()->delete();
            $transaksi->delete();

            DB::commit();
            
            if (request()->ajax()) {
                return response()->json(['success' => 'Transaksi berhasil dihapus dan stok dikembalikan.']);
            }
            return redirect()->route('penjualan.transaksi.index')->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->ajax()) {
                return response()->json(['error' => 'Terjadi kesalahan saat menghapus transaksi: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Export sales data to CSV.
     */
    public function export()
    {
        return Excel::download(new SalesExport, 'data-penjualan-' . date('Y-m-d') . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Import sales data from CSV.
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt,xlsx',
        ]);

        try {
            Excel::import(new SalesImport, $request->file('file'));
            \App\Models\ActivityLog::log('Impor Penjualan', "Berhasil mengimpor data penjualan massal via CSV.");
            return redirect()->route('penjualan.transaksi.index')->with('success', 'Data penjualan berhasil diimpor!');
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->back()->with('error', 'Gagal mengimpor data. Error: ' . implode('; ', $errorMessages));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Sales Import Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses file: ' . $e->getMessage());
        }
    }
}
