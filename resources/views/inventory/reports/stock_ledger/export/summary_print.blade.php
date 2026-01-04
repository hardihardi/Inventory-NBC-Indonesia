<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ringkasan Laporan Stok</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 9pt; color: #333; margin: 0; padding: 0; }
        .header { border-bottom: 2px solid #06609C; padding-bottom: 10px; margin-bottom: 15px; }
        .company-name { font-size: 14pt; font-weight: bold; color: #06609C; text-transform: uppercase; }
        .report-title { font-size: 12pt; font-weight: bold; text-align: right; margin-top: -22px; color: #444; }
        .info-table { width: 100%; margin-bottom: 15px; }
        .info-table td { padding: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; table-layout: fixed; }
        th { background-color: #f2f2f2; border: 1px solid #ccc; padding: 8px 5px; text-align: center; font-size: 8pt; text-transform: uppercase; }
        td { padding: 6px 5px; border: 1px solid #eee; font-size: 8pt; vertical-align: middle; word-wrap: break-word; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .bg-light { background-color: #fafafa; }
        .fw-bold { font-weight: bold; }
        .footer { position: fixed; bottom: 0; width: 100%; font-size: 7pt; color: #999; text-align: center; padding-top: 10px; border-top: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ $company->name ?? 'PT NBC INDONESIA' }}</div>
        <div class="report-title">Ringkasan Laporan Stok</div>
    </div>

    <table class="info-table">
        <tr>
            <td width="12%">Periode</td>
            <td width="38%">: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} sd {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</td>
            <td width="12%">Gudang</td>
            <td width="38%">: {{ $filters['warehouse'] }}</td>
        </tr>
        <tr>
            <td>Kategori</td>
            <td>: {{ $filters['category'] }}</td>
            <td>Tgl Cetak</td>
            <td>: {{ now()->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>Unit Kerja</td>
            <td>: Manajemen Inventaris</td>
            <td>Dicetak Oleh</td>
            <td>: {{ auth()->user()->name }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="32%">Nama Barang / SKU</th>
                <th width="10%">Satuan</th>
                <th width="13%">Saldo Awal</th>
                <th width="13%">Total Masuk</th>
                <th width="13%">Total Keluar</th>
                <th width="16%">Saldo Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $item->name }}</strong><br>
                    <span style="color: #666; font-size: 7pt;">{{ $item->sku }}</span>
                </td>
                <td class="text-center">{{ $item->unit->short_name ?? $item->unit->name ?? '-' }}</td>
                <td class="text-end">{{ number_format($item->opening_qty, 0, ',', '.') }}</td>
                <td class="text-end" style="color: green;">+{{ number_format($item->qty_in, 0, ',', '.') }}</td>
                <td class="text-end" style="color: red;">-{{ number_format($item->qty_out, 0, ',', '.') }}</td>
                <td class="text-end fw-bold">{{ number_format($item->closing_qty, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #f2f2f2; font-weight: bold;">
                <td colspan="3" class="text-end">GRAND TOTAL MUTASI</td>
                <td class="text-end">{{ number_format($items->sum('opening_qty'), 0, ',', '.') }}</td>
                <td class="text-end" style="color: green;">+{{ number_format($items->sum('qty_in'), 0, ',', '.') }}</td>
                <td class="text-end" style="color: red;">-{{ number_format($items->sum('qty_out'), 0, ',', '.') }}</td>
                <td class="text-end">{{ number_format($items->sum('closing_qty'), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Ringkasan Mutasi Stok Per Periode - PT NBC Indonesia - Halaman 1 dari 1
    </div>
</body>
</html>
