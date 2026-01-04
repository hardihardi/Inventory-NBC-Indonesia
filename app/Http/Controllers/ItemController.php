<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Warehouse;
use App\Models\WarehouseStock;
use App\Models\StockLedger;
use Illuminate\Http\Request;
use App\Imports\GeneralItemsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Exports\ItemsExport;
use App\Imports\ItemsImport;

class ItemController extends Controller
{
    /**
     * Menampilkan daftar semua item, dipisahkan berdasarkan kategori.
     */
    public function index(Request $request)
    {
        $query = Item::with(['category', 'unit'])->orderBy('name', 'asc');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('product_code', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        $items = $query->get();

        $yarnItems = $items->filter(fn($item) => strtolower($item->category->type ?? '') === 'yarn');
        $chemicalItems = $items->filter(fn($item) => strtolower($item->category->type ?? '') === 'chemical');
        $dyestuffItems = $items->filter(fn($item) => strtolower($item->category->type ?? '') === 'dyestuff');
        $fabricItems = $items->filter(fn($item) => strtolower($item->category->type ?? '') === 'fabric');
        $sparepartItems = $items->filter(fn($item) => strtolower($item->category->type ?? '') === 'sparepart');
        
        // Maintain others for compatibility if any
        $otherItems = $items->filter(function ($item) {
            return !in_array(strtolower($item->category->type ?? 'general'), ['yarn', 'chemical', 'dyestuff', 'fabric', 'sparepart']);
        });

        return view('inventory.items.index', compact(
            'yarnItems',
            'chemicalItems',
            'dyestuffItems',
            'fabricItems',
            'sparepartItems',
            'otherItems'
        ));
    }

    /**
     * Menampilkan form untuk membuat item baru.
     */
    public function create()
    {
        $categories = Category::all();
        $units = Unit::all();
        $warehouses = Warehouse::all();
        return view('inventory.items.create', compact('categories', 'units', 'warehouses'));
    }
    
    /**
     * Menyimpan item baru ke dalam database.
     * Alur: Validasi -> Upload Gambar -> Transaksi DB -> Simpan Item -> Catat Stok Awal -> Log Aktivitas
     */
    public function store(Request $request)
    {
        $category = Category::find($request->category_id);
        $categoryType = $category ? strtolower($category->type) : 'general';

        $rules = $this->getValidationRules($categoryType);
        $rules['warehouse_id'] = ['required', 'exists:warehouses,id'];
        
        $messages = $this->getValidationMessages();
        $attributes = $this->getValidationAttributes();
        $attributes['warehouse_id'] = 'Gudang';
        
        $validatedData = $request->validate($rules, $messages, $attributes);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $validatedData['image'] = $path;
        }
        
        DB::beginTransaction();
        try {
            $item = Item::create($validatedData);
            
            // Catat stok di gudang yang dipilih
            if ($item->stock > 0) {
                WarehouseStock::create([
                    'warehouse_id' => $request->warehouse_id,
                    'item_id' => $item->id,
                    'stock' => $item->stock,
                ]);

                // Log ke Stock Ledger
                StockLedger::log(
                    $item->id,
                    $request->warehouse_id,
                    $item->stock,
                    $item->stock,
                    'in',
                    $item->id,
                    'Item',
                    'Stok awal saat pendaftaran barang'
                );
            }

            \App\Models\ActivityLog::log('Tambah Barang', "Menambahkan barang baru: {$validatedData['name']}");
            
            DB::commit();

            return redirect()->route('inventory.items.index')
                             ->with('success', 'Barang berhasil ditambahkan!')
                             ->with('active_tab', $categoryType);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Store Item Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Menampilkan detail dari satu item.
     */
    public function show(Item $item)
    {
        $item->load(['category', 'unit', 'warehouseStocks.warehouse']);
        return view('inventory.items.show', compact('item'));
    }

    /**
     * Menampilkan form untuk mengedit item.
     */
    public function edit(Item $item)
    {
        $categories = Category::all();
        $units = Unit::all();
        $warehouses = Warehouse::all();
        
        // Ambil gudang pertama yang memiliki stok untuk item ini (sebagai default di form)
        $currentWarehouseStock = WarehouseStock::where('item_id', $item->id)->first();
        $item->warehouse_id = $currentWarehouseStock ? $currentWarehouseStock->warehouse_id : null;

        return view('inventory.items.edit', compact('item', 'categories', 'units', 'warehouses'));
    }

    /**
     * Memperbarui data item di database.
     * Alur: Validasi -> Handle Gambar -> Update Item -> Sync Gudang (jika pindah) -> Log
     */
    public function update(Request $request, Item $item)
    {
        $category = Category::find($request->category_id);
        $categoryType = $category ? strtolower($category->type) : 'general';
        
        $rules = $this->getValidationRules($categoryType, $item->id);
        $messages = $this->getValidationMessages();
        $attributes = $this->getValidationAttributes();
        $validatedData = $request->validate($rules, $messages, $attributes);

        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $path = $request->file('image')->store('items', 'public');
            $validatedData['image'] = $path;
        }

        DB::beginTransaction();
        try {
            // Bersihkan data lama yang mungkin tidak relevan lagi
            $item->fill($this->clearIrrelevantData($validatedData, $categoryType));
            $item->save();

            // Handle Warehouse update
            if ($request->warehouse_id) {
                $existingStock = WarehouseStock::where('item_id', $item->id)->first();
                if ($existingStock) {
                    if ($existingStock->warehouse_id != $request->warehouse_id) {
                        $oldWarehouseId = $existingStock->warehouse_id;
                        $existingStock->update(['warehouse_id' => $request->warehouse_id]);
                        
                        // Log movement
                        StockLedger::log(
                            $item->id,
                            $request->warehouse_id,
                            0, // No qty change, just location change
                            $item->stock,
                            'in',
                            $item->id,
                            'Item',
                            "Pindah lokasi dari gudang ID: $oldWarehouseId"
                        );
                    }
                } else if ($item->stock > 0) {
                    WarehouseStock::create([
                        'warehouse_id' => $request->warehouse_id,
                        'item_id' => $item->id,
                        'stock' => $item->stock,
                    ]);
                }
            }

            \App\Models\ActivityLog::log('Edit Barang', "Memperbarui data barang: {$item->name}");
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update Item Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->route('inventory.items.index')
                         ->with('success', 'Barang berhasil diperbarui!')
                         ->with('active_tab', $categoryType);
    }
    
    /**
     * Menghapus item dari database.
     */
    public function destroy(Request $request, Item $item)
    {
        if ($item->saleItems()->exists() || $item->purchaseItems()->exists()) {
             $errorMessage = 'Barang "' . $item->name . '" tidak dapat dihapus karena sudah memiliki riwayat transaksi.';
            if ($request->ajax()) {
                return response()->json(['error' => $errorMessage], 422);
            }
            return redirect()->route('inventory.items.index')->with('error', $errorMessage);
        }

        $categoryType = $item->category ? strtolower($item->category->type) : 'general';
        $itemName = $item->name;
        $item->delete();
        \App\Models\ActivityLog::log('Hapus Barang', "Menghapus barang: {$itemName}");

        if ($request->ajax()) {
            return response()->json(['success' => "Barang '$itemName' berhasil dihapus."]);
        }

        return redirect()->route('inventory.items.index')
                         ->with('success', "Barang '$itemName' berhasil dihapus!")
                         ->with('active_tab', $categoryType);
    }

    /**
     * Mencetak label/barcode untuk item terpilih.
     */
    public function printLabels(Request $request)
    {
        $ids = $request->input('ids');
        $qtys = $request->input('qtys');

        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        
        if (is_string($qtys)) {
            $qtys = explode(',', $qtys);
        }

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Silakan pilih produk terlebih dahulu.');
        }

        // Map quantity to item ID
        $qtyMap = [];
        foreach ($ids as $index => $id) {
            $qtyMap[$id] = isset($qtys[$index]) ? (int)$qtys[$index] : 1;
        }

        $items = Item::whereIn('id', $ids)->with(['unit', 'category'])->get();
        $company = \App\Models\CompanySetting::first();

        // Create a flattened list of items based on their requested quantity
        $printItems = [];
        foreach ($items as $item) {
            $quantity = $qtyMap[$item->id] ?? 1;
            
            // Generate QR once for each unique item
            $item->qr_code_svg = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(50)->generate($item->sku);
            
            for ($i = 0; $i < $quantity; $i++) {
                $printItems[] = $item;
            }
        }

        return view('inventory.items.print_labels', [
            'items' => $printItems,
            'company' => $company
        ]);
    }

    public function generateCodes(Request $request)
    {
        try {
            $type = $request->query('type');
            $categoryId = $request->query('category_id');
            $itemName = $request->query('item_name', '');

            switch ($type) {
                case 'product_code':
                    $latestItem = Item::latest('id')->first();
                    $nextNumber = ($latestItem ? $latestItem->id : 0) + 1;
                    $code = 'PRD-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
                    while (Item::where('product_code', $code)->exists()) {
                        $nextNumber++;
                        $code = 'PRD-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
                    }
                    return response()->json(['code' => $code]);

                case 'barcode':
                    // Generate 12 digits first (899 prefix for Indonesia + 9 random digits)
                    $digits = '899' . str_pad(mt_rand(0, 999999999), 9, '0', STR_PAD_LEFT);
                    
                    // Calculate EAN-13 Checksum
                    $sumEven = 0;
                    $sumOdd = 0;
                    
                    // EAN-13 calculation (positions are 0-indexed in string, so odd indices are even positions in spec)
                    for ($i = 0; $i < 12; $i++) {
                        if ($i % 2 === 0) {
                            $sumOdd += (int)$digits[$i]; // Weight 1
                        } else {
                            $sumEven += (int)$digits[$i]; // Weight 3
                        }
                    }
                    
                    $total = $sumOdd + ($sumEven * 3);
                    $remainder = $total % 10;
                    $checkDigit = ($remainder === 0) ? 0 : (10 - $remainder);
                    
                    $barcode = $digits . $checkDigit;
                    
                    // Ensure uniqueness
                    while (Item::where('barcode', $barcode)->exists()) {
                        $digits = '899' . str_pad(mt_rand(0, 999999999), 9, '0', STR_PAD_LEFT);
                         // Recalculate Checksum
                        $sumEven = 0; $sumOdd = 0;
                        for ($i = 0; $i < 12; $i++) {
                            if ($i % 2 === 0) $sumOdd += (int)$digits[$i];
                            else $sumEven += (int)$digits[$i];
                        }
                        $total = $sumOdd + ($sumEven * 3);
                        $remainder = $total % 10;
                        $checkDigit = ($remainder === 0) ? 0 : (10 - $remainder);
                        $barcode = $digits . $checkDigit;
                    }
                    
                    return response()->json(['code' => $barcode]);

                case 'sku':
                    if (!$categoryId) {
                        return response()->json(['error' => 'Kategori harus dipilih'], 400);
                    }
                    
                    $category = Category::find($categoryId);
                    $catPrefix = $category ? strtoupper(substr($category->name, 0, 3)) : 'GEN';
                    $namePart = $itemName ? strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $itemName), 0, 3)) : 'ITM';
                    $randomPart = strtoupper(substr(uniqid(), -4));
                    
                    $sku = "SKU-{$catPrefix}-{$namePart}-{$randomPart}";
                    while (Item::where('sku', $sku)->exists()) {
                        $randomPart = strtoupper(substr(uniqid(), -4));
                        $sku = "SKU-{$catPrefix}-{$namePart}-{$randomPart}";
                    }
                    return response()->json(['code' => $sku]);

                default:
                    return response()->json(['error' => 'Tipe tidak valid'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Generate Code Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Mengimpor data item dari file Excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'category_type' => 'required|in:general,yarn,fabric,chemical,dyestuff,sparepart',
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        $categoryType = $request->category_type;
        $importer = null;

        switch ($categoryType) {
            case 'yarn': $importer = new \App\Imports\YarnItemsImport; break;
            case 'fabric': $importer = new \App\Imports\FabricItemsImport; break;
            case 'general': $importer = new GeneralItemsImport; break;
            case 'chemical':
            case 'dyestuff':
            case 'sparepart':
                $importer = new GeneralItemsImport; // Use general for these for now
                break;
        }

        try {
            if ($importer) {
                Excel::import($importer, $request->file('file'));
                \App\Models\ActivityLog::log('Impor Barang', "Berhasil mengimpor data barang kategori: {$categoryType}");
                return redirect()->route('inventory.items.index')
                                ->with('success', 'Data barang berhasil diimpor!')
                                ->with('active_tab', $categoryType);
            }
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->back()->with('error', 'Gagal mengimpor data. Error: ' . implode('; ', $errorMessages));
        } catch (\Exception $e) {
            Log::error('Import Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses file: ' . $e->getMessage());
        }
    }

    /**
     * Helper untuk mendapatkan aturan validasi berdasarkan tipe kategori.
     */
    private function getValidationRules(string $type, int $itemId = null): array
    {
        // PERBAIKAN: 'purchase_price' dipindahkan ke aturan dasar (base rules)
        $rules = [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'product_code' => ['nullable', 'string', 'max:50', 'unique:items,product_code,' . $itemId],
            'barcode' => ['nullable', 'string', 'max:50', 'unique:items,barcode,' . $itemId],
            'sku' => ['nullable', 'string', 'max:50', 'unique:items,sku,' . $itemId],
            'purchase_price' => ['required', 'numeric', 'min:0'], // Harga Modal
            'price' => ['required', 'numeric', 'min:0'], // Harga Jual
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
        switch ($type) {
            case 'yarn':
            case 'fabric':
                return array_merge($rules, [
                    'color_name' => ['nullable', 'string', 'max:100'],
                    'color_code' => ['nullable', 'string', 'max:50'],
                    'composition' => ['nullable', 'string', 'max:100'],
                    'technical_spec' => ['nullable', 'string', 'max:100'],
                    'gsm' => ['nullable', 'string', 'max:50'],
                    'width' => ['nullable', 'string', 'max:50'],
                    'brand' => ['nullable', 'string', 'max:100'],
                    'unit_id' => ['required', 'exists:units,id'],
                ]);
            case 'chemical':
            case 'dyestuff':
                return array_merge($rules, [
                    'brand' => ['nullable', 'string', 'max:100'],
                    'unit_id' => ['required', 'exists:units,id'],
                ]);
            default: // 'sparepart', 'generic', etc.
                return array_merge($rules, [
                    'brand' => ['nullable', 'string', 'max:100'],
                    'unit_id' => ['required', 'exists:units,id'],
                ]);
        }
    }

    /**
     * Helper untuk membersihkan data yang tidak relevan saat update.
     */
    private function clearIrrelevantData(array $data, string $type): array
    {
        $allFields = [
            'color_name', 'color_code', 'unit_id',
            'composition', 'technical_spec', 'gsm', 'width', 'brand'
        ];
        $relevantFields = [];

        switch ($type) {
            case 'yarn':
            case 'fabric':
                $relevantFields = ['color_name', 'color_code', 'unit_id', 'composition', 'technical_spec', 'gsm', 'width', 'brand'];
                break;
            case 'chemical':
            case 'dyestuff':
                $relevantFields = ['unit_id', 'brand'];
                break;
            default:
                $relevantFields = ['unit_id', 'brand'];
                break;
        }

        foreach ($allFields as $field) {
            if (!in_array($field, $relevantFields)) {
                $data[$field] = null;
            }
        }
        return $data;
    }

    /**
     * Custom validation messages in Indonesian.
     */
    private function getValidationMessages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'unique' => ':attribute sudah terdaftar.',
            'numeric' => ':attribute harus berupa angka.',
            'integer' => ':attribute harus berupa angka bulat.',
            'min' => ':attribute minimal :min.',
            'max' => ':attribute maksimal :max.',
            'image' => ':attribute harus berupa file gambar.',
            'mimes' => ':attribute harus format: :values.',
            'exists' => ':attribute tidak valid.',
        ];
    }

    /**
     * Custom attribute names for validation.
     */
    private function getValidationAttributes(): array
    {
        return [
            'category_id' => 'Kategori',
            'name' => 'Nama Barang',
            'purchase_price' => 'Harga Modal',
            'price' => 'Harga Jual',
            'stock' => 'Stok',
            'unit_id' => 'Satuan',
            'color_name' => 'Nama Warna',
            'color_code' => 'Kode Warna',
            'composition' => 'Komposisi',
            'technical_spec' => 'Spesifikasi Teknis',
            'gsm' => 'GSM',
            'width' => 'Lebar',
            'brand' => 'Brand/Merk',
            'warehouse_id' => 'Gudang',
        ];
    }

    /**
     * Export all items to CSV.
     */
    public function export()
    {
        return Excel::download(new ItemsExport, 'data-barang-' . date('Y-m-d') . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * General CSV Import for items.
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt,xlsx',
        ]);

        try {
            Excel::import(new ItemsImport, $request->file('file'));
            \App\Models\ActivityLog::log('Impor Barang', "Berhasil mengimpor data barang massal via CSV.");
            return redirect()->route('inventory.items.index')->with('success', 'Data barang berhasil diimpor!');
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->back()->with('error', 'Gagal mengimpor data. Error: ' . implode('; ', $errorMessages));
        } catch (\Exception $e) {
            Log::error('General Import Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses file: ' . $e->getMessage());
        }
    }

    /**
     * Download CSV Template for Items active.
     */
    public function downloadTemplate()
    {
        $headers = [
            'nama_barang', 'sku', 'kode_produk', 'kategori', 'satuan', 'harga_beli', 'harga_jual', 
            'stok', 'stok_minimum', 'deskripsi', 'barcode', 'komposisi', 'spec_teknis', 'gsm', 
            'lebar', 'brand', 'warna', 'kode_warna', 'tipe_cat', 'volume', 'size', 'texture', 
            'motif', 'grade', 'tipe_finish'
        ];

        $callback = function() use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=template-impor-barang.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ]);
    }
}
