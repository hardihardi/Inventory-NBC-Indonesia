<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\ProductionMaterial;
use App\Models\Item;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\WarehouseStock;
use App\Models\StockLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductionController extends Controller
{
    /**
     * Menampilkan daftar permintaan material (Produksi / PPIC).
     */
    public function index(Request $request)
    {
        $query = Production::with(['item', 'user'])->latest();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhereHas('item', fn($sub) => $sub->where('name', 'like', "%{$search}%"));
            });
        }

        $productions = $query->paginate(15);
        
        // Stats for PPIC tracking
        $stats = [
            'pending' => Production::where('status', 'planned')->count(),
            'approved' => Production::where('status', 'approved')->count(),
            'ready' => Production::where('status', 'ready')->count(),
            'in_progress' => Production::where('status', 'in_progress')->count(),
        ];

        return view('inventory.production.index', compact('productions', 'stats'));
    }

    /**
     * Real-time Stock Check for PPIC.
     */
    public function stockCheck(Request $request)
    {
        $categories = Category::whereIn('type', ['yarn', 'chemical', 'dyestuff', 'sparepart', 'general'])->get();
        
        $query = Item::with(['category', 'unit', 'warehouseStocks.warehouse']);
        
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        } else {
            // Default: only show material-related items if no search
            $query->whereIn('category_id', $categories->pluck('id'));
        }

        $items = $query->paginate(20)->withQueryString();

        return view('inventory.production.stock_check', compact('items', 'categories'));
    }

    /**
     * Form rencana produksi baru.
     */
    public function create()
    {
        // Ambil data barang dengan eager loading
        $allItems = Item::with(['category', 'unit'])->get();
        
        // Pisahkan kandidat Output (Kain/Fabric)
        $outputItems = $allItems->filter(function($item) {
            return in_array(strtolower($item->category->type ?? ''), ['fabric', 'general']);
        });

        // Pisahkan kandidat Material (Benang, Kimia, Zat Warna)
        $materialItems = $allItems->filter(function($item) {
            return in_array(strtolower($item->category->type ?? ''), ['yarn', 'chemical', 'dyestuff', 'sparepart']);
        });

        // Generate kode otomatis
        $today = date('Ymd');
        $count = Production::whereDate('created_at', date('Y-m-d'))->count() + 1;
        $code = "PROD-{$today}-" . str_pad($count, 3, '0', STR_PAD_LEFT);

        return view('inventory.production.create', compact('outputItems', 'materialItems', 'code'));
    }

    /**
     * Simpan rencana produksi.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:productions,code',
            'item_id' => 'required|exists:items,id',
            'qty_planned' => 'required|numeric|min:0.01',
            'start_date' => 'required|date',
            'materials' => 'required|array|min:1',
            'materials.*.item_id' => 'required|exists:items,id',
            'materials.*.qty_needed' => 'required|numeric|min:0.01',
            'machine_name' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $production = Production::create([
                'code' => $request->code,
                'item_id' => $request->item_id,
                'qty_planned' => $request->qty_planned,
                'status' => 'planned',
                'start_date' => $request->start_date,
                'notes' => $request->notes,
                'machine_name' => $request->machine_name,
                'user_id' => Auth::id(),
            ]);

            foreach ($request->materials as $mat) {
                ProductionMaterial::create([
                    'production_id' => $production->id,
                    'item_id' => $mat['item_id'],
                    'qty_needed' => $mat['qty_needed'],
                    'qty_used' => 0 // Awalnya 0
                ]);
            }

            DB::commit();
            
            \App\Models\ActivityLog::log('Permintaan Material', "Membuat permintaan material baru: {$production->code}");

            return redirect()->route('inventory.production.index')->with('success', 'Permintaan material berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal membuat permintaan material: ' . $e->getMessage());
        }
    }

    /**
     * Detail produksi.
     */
    public function show(Production $production)
    {
        $production->load(['item.unit', 'materials.item' => function($q) {
            $q->with(['unit', 'warehouseStocks.warehouse']);
        }, 'user']);
        
        return view('inventory.production.show', compact('production'));
    }

    public function edit(Production $production)
    {
        if ($production->status != 'planned') {
            return redirect()->route('inventory.production.show', $production)->with('error', 'Produksi yang sudah dimulai tidak dapat diubah rencananya.');
        }
        $production->load(['materials.item', 'item.unit']);
        
        // Ambil data barang dengan eager loading
        $allItems = Item::with(['category', 'unit'])->get();
        
        // Pisahkan kandidat Output (Kain/Fabric)
        $outputItems = $allItems->filter(function($item) {
            return in_array(strtolower($item->category->type ?? ''), ['fabric', 'general']);
        });

        // Pisahkan kandidat Material (Benang, Kimia, Zat Warna)
        $materialItems = $allItems->filter(function($item) {
            return in_array(strtolower($item->category->type ?? ''), ['yarn', 'chemical', 'dyestuff', 'sparepart']);
        });

        return view('inventory.production.edit', compact('production', 'outputItems', 'materialItems'));
    }

    /**
     * Update status atau progress.
     */
    public function update(Request $request, Production $production)
    {
        // Handle Cancel
        if ($request->action == 'cancel') {
             if ($production->status == 'completed') {
                 return back()->with('error', 'Produksi yang sudah selesai tidak bisa dibatalkan.');
             }
             $production->update(['status' => 'cancelled']);
             return back()->with('success', 'Produksi/Permintaan dibatalkan.');
        }

        // Handle Approve (Supervisor/Admin)
        if ($request->action == 'approve') {
            if (!Auth::user()->hasPermission('production.approve')) {
                return back()->with('error', 'Anda tidak memiliki hak akses untuk menyetujui permintaan material.');
            }
            $production->update(['status' => 'approved']);
            \App\Models\ActivityLog::log('Produksi', "Menyetujui permintaan material: {$production->code}");
            return back()->with('success', 'Permintaan material disetujui. Gudang akan menyiapkan barang.');
        }

        // Handle Mark as Ready (Warehouse)
        if ($request->action == 'mark_ready') {
            $production->update(['status' => 'ready']);
            \App\Models\ActivityLog::log('Gudang', "Material SIAP untuk diambil: {$production->code}");
            return back()->with('success', 'Status diperbarui: Material SIAP AMBIL.');
        }

        // Handle Start
        if ($request->action == 'start') {
            $production->update(['status' => 'in_progress']);
            \App\Models\ActivityLog::log('Produksi', "Mulai memproses produksi: {$production->code}");
            return back()->with('success', 'Produksi dimulai. Material dianggap telah keluar dari gudang.');
        }

        // Handle Update Checkpoint
        if ($request->action == 'update_usage') {
            $production->update([
                'qty_actual' => $request->qty_actual,
                'notes' => $request->notes
            ]);
            
            if ($request->materials) {
                foreach ($request->materials as $matId => $usage) {
                    ProductionMaterial::where('id', $matId)->update(['qty_used' => $usage]);
                }
            }
            return back()->with('success', 'Progress diperbarui.');
        }

        // Handle Full Edit (Update Plan)
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'qty_planned' => 'required|numeric|min:0.01',
            'start_date' => 'required|date',
            'materials' => 'required|array|min:1',
            'materials.*.item_id' => 'required|exists:items,id',
            'materials.*.qty_needed' => 'required|numeric|min:0.01',
            'machine_name' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $production->update([
                'item_id' => $request->item_id,
                'qty_planned' => $request->qty_planned,
                'start_date' => $request->start_date,
                'notes' => $request->notes,
                'machine_name' => $request->machine_name,
            ]);

            // Re-sync materials
            $production->materials()->delete();
            foreach ($request->materials as $mat) {
                ProductionMaterial::create([
                    'production_id' => $production->id,
                    'item_id' => $mat['item_id'],
                    'qty_needed' => $mat['qty_needed'],
                    'qty_used' => 0
                ]);
            }

            DB::commit();
            return redirect()->route('inventory.production.show', $production)->with('success', 'Permintaan material berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memperbarui permintaan material: ' . $e->getMessage());
        }
    }
    
    /**
     * Selesaikan produksi (deduct stock).
     */
    public function complete(Request $request, Production $production)
    {
        if ($production->status == 'completed') return back();

        $request->validate([
            'qty_actual' => 'required|numeric|min:0',
            'waste_qty' => 'nullable|numeric|min:0',
            'waste_reason' => 'nullable|string',
            'machine_name' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $finalQty = $request->qty_actual;
            $totalCost = 0;
            
            // 1. Generate Batch Number (BCH-YYYYMMDD-SEQUENCE)
            $today = date('Ymd');
            $batchCount = Production::where('batch_number', 'like', "BCH-{$today}-%")->count() + 1;
            $batchNumber = "BCH-{$today}-" . str_pad($batchCount, 3, '0', STR_PAD_LEFT);

            // 2. Transaksi Bahan Baku (Kurangi Stok & Hitung Biaya)
            foreach ($production->materials as $material) {
                // Gunakan qty_used dari DB (dikumpulkan selama progress)
                $used = $material->qty_used > 0 ? $material->qty_used : $material->qty_needed;
                
                $item = $material->item;
                
                // Hitung biaya berdasarkan qty_used * purchase_price
                $totalCost += ($used * ($item->purchase_price ?? 0));

                if ($item->stock < $used) {
                    throw new \Exception("Stok bahan baku {$item->name} tidak cukup. Dibutuhkan: $used, Tersedia: {$item->stock}");
                }
                
                $item->stock -= $used;
                $item->save();

                $defaultWarehouse = Warehouse::where('is_default', true)->first() ?? Warehouse::first();
                // Update Warehouse Stock
                $ws = WarehouseStock::firstOrCreate(
                    ['item_id' => $item->id, 'warehouse_id' => $defaultWarehouse->id],
                    ['stock' => $item->stock + $used]
                );
                $ws->decrement('stock', $used);

                // Log Stock Ledger
                StockLedger::log(
                    $item->id,
                    $defaultWarehouse->id,
                    -$used,
                    $ws->fresh()->stock,
                    'production',
                    $production->id,
                    Production::class,
                    "Usage for production: {$production->code} (Batch: $batchNumber)"
                );
                
                // Update qty_used final
                $material->qty_used = $used;
                $material->save();
            }

            // 3. Transaksi Barang Jadi (Tambah Stok)
            $finishedGood = $production->item;
            $finishedGood->stock += $finalQty;
            $finishedGood->save();

            // Update Warehouse Stock (Finished Good)
            $defaultWarehouse = Warehouse::where('is_default', true)->first() ?? Warehouse::first();
            $wsFG = WarehouseStock::firstOrCreate(
                ['item_id' => $finishedGood->id, 'warehouse_id' => $defaultWarehouse->id],
                ['stock' => $finishedGood->stock - $finalQty]
            );
            $wsFG->increment('stock', $finalQty);

            // Log Stock Ledger (Finished Good)
            StockLedger::log(
                $finishedGood->id,
                $defaultWarehouse->id,
                $finalQty,
                $wsFG->fresh()->stock,
                'production',
                $production->id,
                Production::class,
                "Finished goods from: {$production->code} (Batch: $batchNumber)"
            );

            // 4. Update Production Record
            $production->update([
                'status' => 'completed',
                'end_date' => now(),
                'qty_actual' => $finalQty,
                'waste_qty' => $request->waste_qty ?? 0,
                'waste_reason' => $request->waste_reason,
                'machine_name' => $request->machine_name,
                'batch_number' => $batchNumber,
                'total_cost' => $totalCost,
                'notes' => $request->notes ?? $production->notes
            ]);

            DB::commit();
            $unitName = $finishedGood->unit->name ?? 'item';
            \App\Models\ActivityLog::log('Permintaan Material', "Menyelesaikan permintaan material: {$production->code}. Batch: {$batchNumber}, Output: {$finalQty} {$unitName}, Biaya: " . number_format($totalCost, 0, ',', '.'));
            
            return redirect()->route('inventory.production.show', $production)->with('success', 'Permintaan material selesai diproses! Batch: ' . $batchNumber);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyelesaikan permintaan material: ' . $e->getMessage());
        }
    }

    public function destroy(Production $production)
    {
        try {
            DB::beginTransaction();

            if ($production->status == 'completed') {
                $defaultWarehouse = Warehouse::where('is_default', true)->first() ?? Warehouse::first();

                // Revert Finished Good stock
                $finishedGood = $production->item;
                $revertQty = $production->qty_actual ?? $production->qty_planned;
                $finishedGood->decrement('stock', $revertQty);

                // Update Warehouse Stock
                $wsFG = WarehouseStock::where('item_id', $finishedGood->id)->where('warehouse_id', $defaultWarehouse->id)->first();
                if ($wsFG) {
                    $wsFG->decrement('stock', $revertQty);
                }

                // Log Stock Reversion (Finished Good)
                StockLedger::log(
                    $finishedGood->id,
                    $defaultWarehouse->id,
                    -$revertQty,
                    $wsFG ? $wsFG->fresh()->stock : 0,
                    'return',
                    $production->id,
                    Production::class,
                    "Revert Finished Good (Hapus Produksi {$production->code})"
                );

                // Revert Materials stock (add back)
                foreach ($production->materials as $material) {
                    $used = $material->qty_used > 0 ? $material->qty_used : $material->qty_needed;
                    $material->item->increment('stock', $used);

                    $wsMat = WarehouseStock::where('item_id', $material->item_id)->where('warehouse_id', $defaultWarehouse->id)->first();
                    if ($wsMat) {
                        $wsMat->increment('stock', $used);
                    }

                    // Log Stock Reversion (Material)
                    StockLedger::log(
                        $material->item_id,
                        $defaultWarehouse->id,
                        $used,
                        $wsMat ? $wsMat->fresh()->stock : 0,
                        'return',
                        $production->id,
                        Production::class,
                        "Revert Material Usage (Hapus Produksi {$production->code})"
                    );
                }
            }

            $production->materials()->delete();
            $production->delete();

            DB::commit();
            
            if (request()->ajax()) {
                return response()->json(['success' => 'Data produksi berhasil dihapus.']);
            }
            return redirect()->route('inventory.production.index')->with('success', 'Data produksi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            if (request()->ajax()) {
                return response()->json(['error' => 'Gagal menghapus produksi: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menghapus produksi: ' . $e->getMessage());
        }
    }
}
