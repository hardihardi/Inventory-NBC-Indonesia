<?php

namespace App\Imports;

use App\Models\Pembelian;
use App\Models\PembelianItem;
use App\Models\Item;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PurchasesImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // Group by purchase_number or invoice_number (external)
        // If purchase_number is present, use it. Otherwise use invoice_number.
        $groupedPurchases = $rows->groupBy(function($item) {
            return $item['purchase_number'] ?? $item['invoice_number'];
        });

        foreach ($groupedPurchases as $identifier => $purchaseRows) {
            DB::beginTransaction();
            try {
                $firstRow = $purchaseRows->first();
                
                // Resolve Supplier
                $supplier = Supplier::where('name', 'like', '%' . ($firstRow['supplier'] ?? $firstRow['supplier_name']) . '%')->first();
                
                // Parse Date
                try {
                    $purchaseDate = Carbon::parse($firstRow['tanggal'] ?? $firstRow['purchase_date']);
                } catch (\Exception $e) {
                    $purchaseDate = now();
                }

                // Create or Update Purchase
                $pembelian = Pembelian::updateOrCreate(
                    ['purchase_number' => $firstRow['purchase_number'] ?? $identifier],
                    [
                        'invoice_number' => $firstRow['invoice_number'] ?? null,
                        'purchase_date' => $purchaseDate,
                        'supplier_id' => $supplier->id ?? null,
                        'payment_method' => $firstRow['payment_method'] ?? 'cash',
                        'payment_status' => $firstRow['payment_status'] ?? 'paid',
                        'notes' => $firstRow['notes'] ?? 'Imported via CSV',
                        'user_id' => Auth::id() ?? 1,
                        'total_amount' => 0, 
                        'paid_amount' => 0,
                    ]
                );

                // Clear existing items if updating
                $pembelian->items()->delete();

                $totalAmount = 0;
                foreach ($purchaseRows as $row) {
                    $item = Item::where('sku', $row['item_sku'])->first();
                    if (!$item) continue;

                    $qty = (float)$row['quantity'];
                    $price = (float)($row['unit_price'] ?? $item->cost_price); // Use cost_price if available
                    $subtotal = $qty * $price;

                    PembelianItem::create([
                        'pembelian_id' => $pembelian->id,
                        'item_id' => $item->id,
                        'item_name' => $item->name,
                        'quantity' => $qty,
                        'unit_price' => $price,
                        'subtotal' => $subtotal,
                    ]);

                    $totalAmount += $subtotal;
                }

                $pembelian->update([
                    'total_amount' => $totalAmount,
                    'paid_amount' => $firstRow['paid_amount'] ?? $totalAmount,
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }
}
