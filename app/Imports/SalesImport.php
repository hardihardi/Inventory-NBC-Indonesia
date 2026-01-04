<?php

namespace App\Imports;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Item;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SalesImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // Group by invoice number
        $groupedSales = $rows->groupBy('invoice_number');

        foreach ($groupedSales as $invoiceNumber => $saleRows) {
            DB::beginTransaction();
            try {
                $firstRow = $saleRows->first();
                
                // Resolve Customer
                $customer = Customer::where('name', 'like', '%' . $firstRow['customer_name'] . '%')->first();
                
                // Parse Date
                try {
                    $saleDate = Carbon::parse($firstRow['sale_date']);
                } catch (\Exception $e) {
                    $saleDate = now();
                }

                // Create or Update Sale
                // Note: Using invoice_number as unique key
                $sale = Sale::updateOrCreate(
                    ['invoice_number' => $invoiceNumber],
                    [
                        'sale_date' => $saleDate,
                        'customer_id' => $customer->id ?? null,
                        'customer_name' => $firstRow['customer_name'] ?? ($customer->name ?? 'Imported Sale'),
                        'payment_method' => $firstRow['payment_method'] ?? 'cash',
                        'payment_status' => $firstRow['payment_status'] ?? 'paid',
                        'notes' => $firstRow['notes'] ?? 'Imported via CSV',
                        'user_id' => Auth::id() ?? 1,
                        'total_amount' => 0, // Will calculate below
                        'grand_total' => 0,
                    ]
                );

                // Clear existing items if updating
                $sale->items()->delete();

                $totalAmount = 0;
                foreach ($saleRows as $row) {
                    $item = Item::where('sku', $row['item_sku'])->first();
                    if (!$item) continue;

                    $qty = (float)$row['quantity'];
                    $price = (float)($row['unit_price'] ?? $item->price);
                    $subtotal = $qty * $price;

                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'item_id' => $item->id,
                        'item_name' => $item->name,
                        'quantity' => $qty,
                        'unit_price' => $price,
                        'subtotal' => $subtotal,
                    ]);

                    $totalAmount += $subtotal;
                }

                $sale->update([
                    'total_amount' => $totalAmount,
                    'grand_total' => $totalAmount - ($sale->discount_amount ?? 0) + ($sale->tax_amount ?? 0),
                    'paid_amount' => $totalAmount, // Assume paid if not specified
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                // Optionally log error or throw
                throw $e;
            }
        }
    }
}
