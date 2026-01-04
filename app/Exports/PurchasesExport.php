<?php

namespace App\Exports;

use App\Models\Pembelian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PurchasesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pembelian::with(['supplier', 'items'])->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No. Transaksi',
            'No. Faktur Vendor',
            'Tanggal Pembelian',
            'Nama Supplier',
            'Total Belanja Bruto',
            'Jumlah Dibayarkan',
            'Metode Pembayaran',
            'Status Pembayaran',
            'Catatan Vendor/Internal',
            'Daftar Barang'
        ];
    }

    public function map($pembelian): array
    {
        $details = $pembelian->items->map(function($item) {
            return "{$item->item_name} (x{$item->quantity})";
        })->implode('; ');

        return [
            $pembelian->purchase_number,
            $pembelian->invoice_number,
            $pembelian->purchase_date->format('Y-m-d'),
            $pembelian->supplier->name ?? 'Unknown',
            $pembelian->total_amount,
            $pembelian->paid_amount,
            $pembelian->payment_method,
            $pembelian->payment_status,
            $pembelian->notes,
            $details
        ];
    }
}
