<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Item::with(['category', 'unit'])->get();
    }

    public function headings(): array
    {
        return [
            'Nama Barang',
            'SKU',
            'Kode Produk',
            'Kategori',
            'Satuan',
            'Harga Beli',
            'Harga Jual',
            'Stok',
            'Stok Minimum',
            'Deskripsi',
            'Barcode',
            'Komposisi',
            'Spec Teknis',
            'GSM',
            'Lebar',
            'Brand',
            'Warna',
            'Kode Warna',
            'Tipe Cat',
            'Volume',
            'Size',
            'Texture',
            'Motif',
            'Grade',
            'Tipe Finish'
        ];
    }

    /**
    * @var Item $item
    */
    public function map($item): array
    {
        return [
            $item->name,
            $item->sku,
            $item->product_code,
            $item->category->name ?? '',
            $item->unit->name ?? '',
            $item->purchase_price,
            $item->price,
            $item->stock,
            $item->min_stock,
            $item->description,
            $item->barcode,
            $item->composition,
            $item->technical_spec,
            $item->gsm,
            $item->width,
            $item->brand,
            $item->color_name,
            $item->color_code,
            $item->paint_type,
            $item->volume,
            $item->size,
            $item->texture,
            $item->motif,
            $item->grade,
            $item->finish_type,
        ];
    }
}
