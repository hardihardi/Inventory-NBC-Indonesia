<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Bulanan - {{ $filterMonth }}/{{ $filterYear }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 8pt; color: #333; line-height: 1.25; }
        @page { margin: 1cm; }
        
        .header-table { width: 100%; border-bottom: 2px solid #0d47a1; padding-bottom: 10px; margin-bottom: 15px; }
        .company-name { font-size: 14pt; font-weight: bold; color: #0d47a1; }
        .report-title { font-size: 12pt; font-weight: bold; text-align: right; text-transform: uppercase; }
        
        .summary-box { background: #f8f9fa; border: 1px solid #dee2e6; padding: 12px; margin-bottom: 15px; }
        .summary-box table { width: 100%; }
        .summary-item { text-align: center; }
        .summary-label { font-size: 7pt; color: #666; text-transform: uppercase; font-weight: bold; }
        .summary-value { font-size: 11pt; font-weight: bold; }

        table.main-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.main-table th { background-color: #0d47a1; color: #ffffff; font-weight: bold; text-align: left; border: 1px solid #0d47a1; padding: 6px 5px; font-size: 7.5pt; }
        table.main-table td { border: 1px solid #eee; padding: 6px 5px; vertical-align: top; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-success { color: #2e7d32; font-weight: bold; }
        .text-primary { color: #0d47a1; font-weight: bold; }
        
        .footer { position: fixed; bottom: 0; width: 100%; font-size: 7pt; text-align: right; color: #999; border-top: 1px solid #eee; padding-top: 5px; }
    </style>
</head>
<body>
    @php
        $periode = \Carbon\Carbon::createFromDate($filterYear, $filterMonth, 1);
    @endphp
    <table class="header-table">
        <tr>
            <td style="width: 50%;">
                <div class="company-name">{{ $company->name ?? 'PT NBC INDONESIA' }}</div>
                <div style="font-size: 7pt;">{{ $company->address ?? '' }}</div>
                <div style="font-size: 7pt;">Telp: {{ $company->phone ?? '' }} | Email: {{ $company->email ?? '' }}</div>
            </td>
            <td style="text-align: right; width: 50%;">
                <div class="report-title">LAPORAN PENJUALAN BULANAN</div>
                <div style="font-size: 9pt;">Periode: {{ $periode->translatedFormat('F Y') }}</div>
                <div style="font-size: 7pt; color: #666;">Waktu Cetak: {{ date('d/m/Y H:i') }}</div>
            </td>
        </tr>
    </table>

    <div class="summary-box">
        <table>
            <tr>
                <td class="summary-item">
                    <div class="summary-label">Net Benang/Kain</div>
                    <div class="summary-value">Rp {{ number_format($netSalesTextile, 0, ',', '.') }}</div>
                </td>
                <td class="summary-item">
                    <div class="summary-label">Net Kimia/Penunjang</div>
                    <div class="summary-value">Rp {{ number_format($netSalesPenunjang, 0, ',', '.') }}</div>
                </td>
                <td class="summary-item">
                    <div class="summary-label">Total Retur</div>
                    <div class="summary-value text-danger">Rp {{ number_format($totalMonthlyReturns, 0, ',', '.') }}</div>
                </td>
                <td class="summary-item">
                    <div class="summary-label text-primary">Total Penjualan Bersih</div>
                    <div class="summary-value text-primary">Rp {{ number_format($totalNetMonthlySales, 0, ',', '.') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th width="4%" class="text-center">No</th>
                <th width="12%">Tgl Transaksi</th>
                <th width="15%">No. Invoice</th>
                <th width="15%">Pelanggan</th>
                <th>Ringkasan Item</th>
                <th width="8%" class="text-center">Qty</th>
                <th width="12%" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($salesThisMonth as $sale)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $sale->sale_date->format('d/m/Y') }}</td>
                <td><div style="font-weight: bold;">{{ $sale->invoice_number }}</div></td>
                <td>{{ $sale->customer_name ?: 'Umum' }}</td>
                <td>
                    <div style="font-size: 7.5pt; color: #555;">
                        {{ $sale->items->map(function($i) { return $i->item->name . ' ('.(float)$i->quantity.')'; })->join(', ') }}
                    </div>
                </td>
                <td class="text-center">{{ (float)$sale->items->sum('quantity') }}</td>
                <td class="text-right fw-bold">Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-5">Tidak ada data transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Sistem Inventaris NBC Indonesia | Halaman 1 dari 1 | Dicetak secara otomatis
    </div>
</body>
</html>