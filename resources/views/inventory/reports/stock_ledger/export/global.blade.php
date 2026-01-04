<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pergerakan Stok - {{ date('d/m/Y') }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 8pt; color: #333; line-height: 1.2; }
        @page { margin: 1cm; }
        
        .header-table { width: 100%; border-bottom: 2px solid #0d47a1; padding-bottom: 10px; margin-bottom: 15px; }
        .company-name { font-size: 14pt; font-weight: bold; color: #0d47a1; }
        .report-title { font-size: 12pt; font-weight: bold; text-align: right; text-transform: uppercase; }
        
        .summary-box { background: #f8f9fa; border: 1px solid #dee2e6; padding: 10px; margin-bottom: 15px; }
        .summary-box table { width: 100%; }
        .summary-item { text-align: center; }
        .summary-label { font-size: 7pt; color: #666; text-transform: uppercase; font-weight: bold; }
        .summary-value { font-size: 11pt; font-weight: bold; }

        table.main-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.main-table th { background-color: #0d47a1; color: #ffffff; font-weight: bold; text-align: left; border: 1px solid #0d47a1; padding: 5px; }
        table.main-table td { border: 1px solid #eee; padding: 5px; vertical-align: top; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-success { color: #2e7d32; font-weight: bold; }
        .text-danger { color: #c62828; font-weight: bold; }
        
        .badge { display: inline-block; padding: 2px 4px; border-radius: 3px; font-size: 6.5pt; background: #eee; color: #444; border: 1px solid #ddd; }
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
                <div class="report-title">LAPORAN PERGERAKAN STOK</div>
                <div style="font-size: 8pt;">Periode: {{ request('start_date') ?: 'Awal' }} s/d {{ request('end_date') ?: date('d/m/Y') }}</div>
                <div style="font-size: 7pt; color: #666;">Dicetak pada: {{ date('d/m/Y H:i') }}</div>
            </td>
        </tr>
    </table>

    <div class="summary-box">
        <table>
            <tr>
                <td class="summary-item">
                    <div class="summary-label">Total Masuk (IN)</div>
                    <div class="summary-value text-success">+{{ number_format($stats['total_in'], 0, ',', '.') }}</div>
                </td>
                <td class="summary-item">
                    <div class="summary-label">Total Keluar (OUT)</div>
                    <div class="summary-value text-danger">-{{ number_format($stats['total_out'], 0, ',', '.') }}</div>
                </td>
                <td class="summary-item">
                    <div class="summary-label">Net Movement</div>
                    <div class="summary-value {{ $stats['net'] >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ $stats['net'] > 0 ? '+' : '' }}{{ number_format($stats['net'], 0, ',', '.') }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th width="10%">Tanggal</th>
                <th width="25%">Produk / SKU</th>
                <th width="12%">Gudang</th>
                <th class="text-center" width="8%">IN/OUT</th>
                <th class="text-center" width="8%">Saldo</th>
                <th>Referensi & Catatan</th>
                <th width="10%">User</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ledgers as $ledger)
            <tr>
                <td>{{ $ledger->created_at->format('d/m/Y') }}<br><small style="color: #888;">{{ $ledger->created_at->format('H:i') }} WIB</small></td>
                <td>
                    @if($ledger->item)
                        <div style="font-weight: bold;">{{ $ledger->item->name }}</div>
                        <div style="font-size: 7pt; color: #666;">SKU: {{ $ledger->item->sku }}</div>
                    @else
                        <div style="color: #999; font-style: italic;">Produk dihapus</div>
                    @endif
                </td>
                <td>{{ $ledger->warehouse->name }}</td>
                <td class="text-center {{ $ledger->type == 'in' ? 'text-success' : 'text-danger' }}">
                    {{ $ledger->type == 'in' ? '+' : '-' }}{{ number_format($ledger->qty_change, 0, ',', '.') }}
                </td>
                <td class="text-center"><strong>{{ number_format($ledger->qty_after, 0, ',', '.') }}</strong></td>
                <td>
                    <span class="badge">
                        @php
                            $labels = [
                                'App\Models\StockAdjustment' => 'Adj',
                                'App\Models\StockTransfer' => 'Trf',
                                'App\Models\Production' => 'Prod',
                                'App\Models\Sale' => 'Sls',
                                'App\Models\Purchase' => 'Pur',
                            ];
                            echo $labels[$ledger->reference_type] ?? $ledger->reference_type;
                        @endphp
                    </span>
                    <span style="font-size: 7pt; color: #444;">{{ $ledger->notes ?: '-' }}</span>
                </td>
                <td>{{ $ledger->user->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Halaman 1 dari 1 | Sistem Inventaris NBC Indonesia | Dicetak secara otomatis
    </div>
</body>
</html>
