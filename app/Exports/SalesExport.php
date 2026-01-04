<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sale::with(['customer', 'items'])->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No. Invoice',
            'Tanggal Penjualan',
            'Pelanggan',
            'Total Bruto',
            'Potongan (Diskon)',
            'Pajak',
            'Total Akhir (Net)',
            'Metode Pembayaran',
            'Status Pembayaran',
            'Catatan',
            'Daftar Barang'
        ];
    }

    public function map($sale): array
    {
        $details = $sale->items->map(function($item) {
            return "{$item->item_name} (x{$item->quantity})";
        })->implode('; ');

        return [
            $sale->invoice_number,
            $sale->sale_date->format('Y-m-d'),
            $sale->customer_name ?? ($sale->customer->name ?? 'Umum'),
            $sale->total_amount,
            $sale->discount_amount,
            $sale->tax_amount,
            $sale->grand_total,
            $sale->payment_method,
            $sale->payment_status,
            $sale->notes,
            $details
        ];
    }
}
