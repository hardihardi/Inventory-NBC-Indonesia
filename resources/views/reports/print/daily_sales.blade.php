<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Harian - {{ $filterDate }}</title>
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
        
        .item-spec { font-size: 6.5pt; color: #666; font-style: italic; }
        .item-price { font-size: 7pt; color: #888; }
        
        .footer { position: fixed; bottom: 0; width: 100%; font-size: 7pt; text-align: right; color: #999; border-top: 1px solid #eee; padding-top: 5px; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td style="width: 50%;">
                <div class="company-name">{{ $company->name ?? 'PT NBC INDONESIA' }}</div>
                <div style="font-size: 7pt;">{{ $company->address ?? '' }}</div>
                <div style="font-size: 7pt;">Telp: {{ $company->phone ?? '' }} | Email: {{ $company->email ?? '' }}</div>
            </td>
            <td style="text-align: right; width: 50%;">
                <div class="report-title">LAPORAN PENJUALAN HARIAN</div>
                <div style="font-size: 9pt;">Tanggal: {{ \Carbon\Carbon::parse($filterDate)->translatedFormat('d F Y') }}</div>
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
                    <div class="summary-value text-danger">Rp {{ number_format($totalDailyReturns, 0, ',', '.') }}</div>
                </td>
                <td class="summary-item">
                    <div class="summary-label text-primary">Total Pendapatan Bersih</div>
                    <div class="summary-value text-primary">Rp {{ number_format($totalNetDailySales, 0, ',', '.') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th width="4%" class="text-center">No</th>
                <th width="12%">No. Invoice</th>
                <th width="12%">Pelanggan</th>
                <th>Detail Item (Item, Qty, Harga)</th>
                <th width="12%" class="text-right">Biaya Tambahan</th>
                <th width="12%" class="text-right">Grand Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($salesToday as $sale)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>
                    <div style="font-weight: bold;">{{ $sale->invoice_number }}</div>
                    <div style="font-size: 7pt; color: #888;">Jam: {{ $sale->sale_date->format('H:i') }}</div>
                </td>
                <td>{{ $sale->customer_name ?: 'Umum' }}</td>
                <td style="padding: 0;">
                    <table style="width: 100%; border: none; border-collapse: collapse;">
                        @foreach($sale->items as $item)
                        <tr style="{{ !$loop->last ? 'border-bottom: 1px dashed #eee;' : '' }}">
                            <td style="border: none; padding: 4px 5px;">
                                <div style="font-weight: bold;">{{ $item->item->name }}</div>
                                @php
                                    $specs = array_filter([$item->item->brand, $item->item->composition, $item->item->gsm ? $item->item->gsm.'GSM' : null, $item->item->width ? 'L:'.$item->item->width.'"' : null]);
                                @endphp
                                @if($specs)<div class="item-spec">{{ implode(' | ', $specs) }}</div>@endif
                            </td>
                            <td style="border: none; padding: 4px 5px; width: 30%; text-align: right;" class="item-price">
                                {{ number_format($item->quantity, 0) }} {{ $item->item->unit->short_name }} x {{ number_format($item->unit_price, 0) }}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </td>
                <td class="text-right">Rp {{ number_format($sale->additional_cost, 0, ',', '.') }}</td>
                <td class="text-right text-primary">Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-5">Tidak ada data transaksi hari ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Sistem Inventaris NBC Indonesia | Halaman 1 dari 1 | Dicetak pada {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>