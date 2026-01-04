<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ValuationExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $categoryId;
    protected $warehouseId;
    protected $mode;

    public function __construct($categoryId = null, $mode = 'cost', $warehouseId = null)
    {
        $this->categoryId = $categoryId;
        $this->mode = $mode;
        $this->warehouseId = $warehouseId;
    }

    public function collection()
    {
        $query = Item::with(['category', 'unit', 'warehouseStocks']);

        if ($this->categoryId) {
            $query->where('category_id', $this->categoryId);
        }

        return $query->get()->filter(function($item) {
            $stock = $this->warehouseId 
                ? $item->warehouseStocks->where('warehouse_id', $this->warehouseId)->sum('stock')
                : $item->stock;
            return $stock > 0;
        });
    }

    public function headings(): array
    {
        $warehouseLabel = $this->warehouseId 
            ? ' (Gudang: ' . (\App\Models\Warehouse::find($this->warehouseId)->name ?? 'Unknown') . ')'
            : '';

        return [
            'SKU',
            'Nama Produk',
            'Kategori',
            'Stok' . $warehouseLabel,
            'Satuan',
            'Harga Satuan (' . strtoupper($this->mode) . ')',
            'Total Valuasi'
        ];
    }

    public function map($item): array
    {
        // Calculate Stock
        $stock = $this->warehouseId 
            ? $item->warehouseStocks->where('warehouse_id', $this->warehouseId)->sum('stock')
            : $item->stock;

        // Calculate Price
        if ($this->mode === 'sale') {
            $price = $item->price ?? 0;
        } elseif ($this->mode === 'average') {
            $price = \App\Models\PembelianItem::where('item_id', $item->id)->avg('unit_price') ?? $item->purchase_price ?? 0;
        } else {
            $price = $item->purchase_price ?? 0;
        }

        $valuation = $stock * $price;

        return [
            $item->sku,
            $item->name,
            $item->category->name ?? '-',
            $stock,
            $item->unit->short_name ?? '-',
            $price,
            $valuation
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E2EFDA');
        
        return [];
    }
}
