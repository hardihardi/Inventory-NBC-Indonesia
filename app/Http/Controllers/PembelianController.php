<?php
namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Pembelian;
use App\Models\PembelianItem;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\WarehouseStock;
use App\Models\StockLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PurchasesExport;
use App\Imports\PurchasesImport;

class PembelianController extends Controller
{
    public function index()
    {
         $pembelians = Pembelian::latest()->with('supplier', 'items')->get();
    return view('pembelian.index', compact('pembelians'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $items = Item::all();
        return view('pembelian.create', compact('suppliers', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // --- Generate Nomor Pembelian Unik ---
            $currentDate = Carbon::parse($request->purchase_date);
            $prefix = 'PO-' . $currentDate->format('Ymd'); // Contoh: PO-20240527

            // Cari nomor pembelian terakhir untuk tanggal yang sama
            $lastPembelian = Pembelian::where('purchase_number', 'like', $prefix . '%')
                                        ->orderBy('purchase_number', 'desc')
                                        ->first();

            $sequence = 1;
            if ($lastPembelian) {
                // Ambil nomor urut dari nomor pembelian terakhir
                // Contoh: PO-20240527-0012 -> ambil 0012
                $lastNumber = (int) substr($lastPembelian->purchase_number, -4);
                $sequence = $lastNumber + 1;
            }

            // Format nomor urut menjadi 4 digit dengan leading zeros (0001, 0002, dst)
            $purchaseNumber = $prefix . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
            // --- Akhir Generate Nomor Pembelian Unik ---

            // --- Generate Nomor Faktur Internal (Hanya jika belum ada di request) ---
            $invoiceNumber = $request->invoice_number ?: $this->generateInvoiceNumber();

            // Determinisasi Status Pembayaran
            $paidAmount = $request->paid_amount ?? 0;
            $totalAmountComputed = 0;
            foreach ($request->input('items') as $itemData) {
                $totalAmountComputed += ($itemData['quantity'] * $itemData['price']);
            }

            $paymentStatus = 'paid';
            if ($paidAmount == 0) {
                $paymentStatus = 'credit';
            } elseif ($paidAmount < $totalAmountComputed) {
                $paymentStatus = 'partial';
            }

            $pembelian = Pembelian::create([
                'supplier_id' => $request->supplier_id,
                'purchase_date' => $request->purchase_date,
                'invoice_number' => $invoiceNumber,
                'reference_number' => $request->reference_number,
                'notes' => $request->notes,
                'total_amount' => $totalAmountComputed,
                'paid_amount' => $paidAmount,
                'payment_method' => $request->payment_method ?? 'cash',
                'payment_status' => $paymentStatus,
                'due_date' => $request->due_date,
                'user_id' => Auth::id(),
                'purchase_number' => $purchaseNumber,
            ]);

            $defaultWarehouse = Warehouse::where('is_default', true)->first() ?? Warehouse::first();

            foreach ($request->input('items') as $itemData) {
                $item = Item::findOrFail($itemData['item_id']);
                $subtotal = $itemData['quantity'] * $itemData['price'];

                PembelianItem::create([
                    'pembelian_id' => $pembelian->id,
                    'item_id' => $item->id,
                    'item_name' => $item->name,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['price'],
                    'subtotal' => $subtotal,
                ]);

                $item->increment('stock', $itemData['quantity']);

                // Update Warehouse Stock
                $ws = WarehouseStock::firstOrCreate(
                    ['item_id' => $item->id, 'warehouse_id' => $defaultWarehouse->id],
                    ['stock' => $item->stock - $itemData['quantity']]
                );
                $ws->increment('stock', $itemData['quantity']);

                // Log Stock Ledger
                StockLedger::log(
                    $item->id,
                    $defaultWarehouse->id,
                    $itemData['quantity'],
                    $ws->fresh()->stock,
                    'in',
                    $pembelian->id,
                    Pembelian::class,
                    "Pembelian {$pembelian->purchase_number}"
                );
            }

            // Record Cash Flow if there is payment
            if ($paidAmount > 0) {
                \App\Models\CashFlow::create([
                    'type' => 'out',
                    'amount' => min($paidAmount, $totalAmountComputed),
                    'transaction_date' => $request->purchase_date,
                    'category' => 'Pembelian',
                    'reference_type' => 'Pembelian',
                    'reference_id' => $pembelian->id,
                    'notes' => 'Pembayaran ' . $pembelian->purchase_number,
                    'user_id' => Auth::id()
                ]);
            }

            DB::commit();
            return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil disimpan dengan nomor ' . $purchaseNumber . '.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Anda bisa log $e->getMessage() untuk debugging lebih lanjut
            return redirect()->back()->withErrors(['error_simpan' => 'Terjadi kesalahan saat menyimpan pembelian: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Pembelian $pembelian)
    {
        $pembelian->load('supplier', 'user', 'items.item');
        return view('pembelian.show', compact('pembelian'));
    }

    public function edit(Pembelian $pembelian)
    {
        $suppliers = Supplier::all();
        $items = Item::all();
        $pembelian->load('items');
        return view('pembelian.edit', compact('pembelian', 'suppliers', 'items'));
    }

    public function update(Request $request, Pembelian $pembelian)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $updateData = [
                'supplier_id' => $request->supplier_id,
                'purchase_date' => $request->purchase_date,
                'reference_number' => $request->reference_number,
                'notes' => $request->notes,
            ];

            if ($request->invoice_number) {
                $updateData['invoice_number'] = $request->invoice_number;
            } elseif (!$pembelian->invoice_number) {
                // Jangan otomatis generate jika belum ada, biarkan manual lewat tombol di UI atau field input
                // Namun untuk menjaga kompatibilitas, kita bisa biarkan kosong jika tidak ada input
            }

            $pembelian->update($updateData);

            $defaultWarehouse = Warehouse::where('is_default', true)->first() ?? Warehouse::first();

            // 1. Revert OLD stock (Decrement because Pembelian adds stock)
            foreach ($pembelian->items as $oldItem) {
                $item = Item::find($oldItem->item_id);
                if ($item) {
                    $item->decrement('stock', $oldItem->quantity);

                    // Update Warehouse Stock
                    $ws = WarehouseStock::firstOrCreate(
                        ['item_id' => $item->id, 'warehouse_id' => $defaultWarehouse->id],
                        ['stock' => $item->stock + $oldItem->quantity]
                    );
                    $ws->decrement('stock', $oldItem->quantity);

                    // Log Stock Reversion
                    StockLedger::log(
                        $item->id,
                        $defaultWarehouse->id,
                        -$oldItem->quantity,
                        $ws->fresh()->stock,
                        'return',
                        $pembelian->id,
                        Pembelian::class,
                        "Revisi Pembelian {$pembelian->purchase_number} (Revert)"
                    );
                }
            }

            // 2. Clear old items
            $totalAmount = 0;
            $pembelian->items()->delete();

            // 3. Process NEW items
            foreach ($request->input('items') as $itemData) {
                $item = Item::findOrFail($itemData['item_id']);
                $subtotal = $itemData['quantity'] * $itemData['price'];
                $totalAmount += $subtotal;

                PembelianItem::create([
                    'pembelian_id' => $pembelian->id,
                    'item_id' => $item->id,
                    'item_name' => $item->name,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['price'],
                    'subtotal' => $subtotal,
                ]);

                $item->increment('stock', $itemData['quantity']);

                // Update Warehouse Stock
                $ws = WarehouseStock::firstOrCreate(
                    ['item_id' => $item->id, 'warehouse_id' => $defaultWarehouse->id],
                    ['stock' => $item->stock - $itemData['quantity']]
                );
                $ws->increment('stock', $itemData['quantity']);

                // Log Stock In (New)
                StockLedger::log(
                    $item->id,
                    $defaultWarehouse->id,
                    $itemData['quantity'],
                    $ws->fresh()->stock,
                    'in',
                    $pembelian->id,
                    Pembelian::class,
                    "Revisi Pembelian {$pembelian->purchase_number} (New)"
                );
            }

            $pembelian->update(['total_amount' => $totalAmount]);

            DB::commit();
            return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui pembelian.'])->withInput();
        }
    }

    public function destroy(Pembelian $pembelian)
    {
        DB::beginTransaction();
        try {
            $defaultWarehouse = Warehouse::where('is_default', true)->first() ?? Warehouse::first();

            foreach ($pembelian->items as $itemPembelian) {
                $item = Item::find($itemPembelian->item_id);
                if ($item) {
                    $item->decrement('stock', $itemPembelian->quantity);

                    // Update Warehouse Stock
                    $ws = WarehouseStock::firstOrCreate(
                        ['item_id' => $item->id, 'warehouse_id' => $defaultWarehouse->id],
                        ['stock' => $item->stock + $itemPembelian->quantity]
                    );
                    $ws->decrement('stock', $itemPembelian->quantity);

                    // Log Stock Return
                    StockLedger::log(
                        $item->id,
                        $defaultWarehouse->id,
                        -$itemPembelian->quantity,
                        $ws->fresh()->stock,
                        'return',
                        $pembelian->id,
                        Pembelian::class,
                        "Hapus Pembelian {$pembelian->purchase_number}"
                    );
                }
            }

            $pembelian->items()->delete();
            $pembelian->delete();

            DB::commit();
            
            if (request()->ajax()) {
                return response()->json(['success' => 'Pembelian berhasil dihapus.']);
            }
            return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->ajax()) {
                return response()->json(['error' => 'Terjadi kesalahan saat menghapus pembelian.'], 500);
            }
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus pembelian.']);
        }
    }

    /**
     * Helper function to generate a unique internal invoice number for Purchase.
     */
    private function generateInvoiceNumber()
    {
        $latestPembelian = Pembelian::whereNotNull('invoice_number')->latest('id')->first();
        $today = now()->format('Ymd');
        $nextNumber = 1;

        if ($latestPembelian) {
            $lastInvoiceNumber = $latestPembelian->invoice_number;
            // Format: FAK-20240527-0001
            $parts = explode('-', $lastInvoiceNumber);
            if (count($parts) === 3) {
                $lastDate = $parts[1];
                if ($lastDate === $today) {
                    $nextNumber = (int)$parts[2] + 1;
                }
            }
        }
        return 'FAK-' . $today . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * AJAX: Generate a new invoice number.
     */
    public function generateInvoiceAjax()
    {
        return response()->json([
            'status' => 'success',
            'number' => $this->generateInvoiceNumber()
        ]);
    }

    /**
     * POST: Generate and save invoice number for an existing purchase.
     */
    public function saveGeneratedInvoice(Pembelian $pembelian)
    {
        if ($pembelian->invoice_number) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nomor faktur sudah ada.'
            ], 400);
        }

        $pembelian->update([
            'invoice_number' => $this->generateInvoiceNumber()
        ]);

        return response()->json([
            'status' => 'success',
            'number' => $pembelian->invoice_number,
            'message' => 'Nomor faktur berhasil digenerate!'
        ]);
    }

    /**
     * Export purchase data to CSV.
     */
    public function export()
    {
        return Excel::download(new PurchasesExport, 'data-pembelian-' . date('Y-m-d') . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Import purchase data from CSV.
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt,xlsx',
        ]);

        try {
            Excel::import(new PurchasesImport, $request->file('file'));
            \App\Models\ActivityLog::log('Impor Pembelian', "Berhasil mengimpor data pembelian massal via CSV.");
            return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil diimpor!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->back()->with('error', 'Gagal mengimpor data. Error: ' . implode('; ', $errorMessages));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Purchase Import Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses file: ' . $e->getMessage());
        }
    }
}