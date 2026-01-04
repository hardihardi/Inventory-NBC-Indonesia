<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StockSummaryExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $items;
    protected $startDate;
    protected $endDate;
    protected $filters;

    public function __construct($items, $startDate, $endDate, $filters = [])
    {
        $this->items = $items;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->filters = $filters;
    }

    public function collection()
    {
        return $this->items;
    }

    public function headings(): array
    {
        return [
            ['RINGKASAN LAPORAN STOK'],
            ['Periode: ' . date('d/m/Y', strtotime($this->startDate)) . ' sd ' . date('d/m/Y', strtotime($this->endDate))],
            ['Gudang: ' . ($this->filters['warehouse'] ?? 'Semua Gudang')],
            ['Kategori: ' . ($this->filters['category'] ?? 'Semua Kategori')],
            [''],
            [
                'SKU',
                'Nama Produk',
                'Kategori',
                'Satuan',
                'Saldo Awal',
                'Total Masuk (+)',
                'Total Keluar (-)',
                'Saldo Akhir'
            ]
        ];
    }

    public function map($item): array
    {
        return [
            $item->sku,
            $item->name,
            $item->category->name ?? '-',
            $item->unit->short_name ?? $item->unit->name ?? '-',
            $item->opening_qty,
            $item->qty_in,
            $item->qty_out,
            $item->closing_qty
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->items->count() + 6; // 6 rows of headers
        
        // Add Total Row
        $sheet->setCellValue('D' . ($lastRow + 1), 'GRAND TOTAL');
        $sheet->setCellValue('E' . ($lastRow + 1), $this->items->sum('opening_qty'));
        $sheet->setCellValue('F' . ($lastRow + 1), $this->items->sum('qty_in'));
        $sheet->setCellValue('G' . ($lastRow + 1), $this->items->sum('qty_out'));
        $sheet->setCellValue('H' . ($lastRow + 1), $this->items->sum('closing_qty'));

        $sheet->getStyle('A6:H6')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '06609C']]
        ]);

        $sheet->getStyle('A' . ($lastRow + 1) . ':H' . ($lastRow + 1))->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F2F2F2']]
        ]);

        return [
            1 => ['font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '06609C']]],
            2 => ['font' => ['italic' => true]],
            6 => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
        ];
    }
}
