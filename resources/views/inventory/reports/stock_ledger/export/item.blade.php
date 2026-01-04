<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Stok: {{ $item->name }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 8.5pt; color: #333; line-height: 1.3; }
        @page { margin: 1.2cm; }
        
        .header-table { width: 100%; border-bottom: 2px solid #0d47a1; padding-bottom: 10px; margin-bottom: 20px; }
        .company-name { font-size: 15pt; font-weight: bold; color: #0d47a1; text-transform: uppercase; }
        .report-title { font-size: 12pt; font-weight: bold; text-align: right; }
        
        .info-section { background: #f8f9fa; border: 1px solid #dee2e6; padding: 12px; margin-bottom: 20px; border-radius: 4px; }
        .info-table { width: 100%; border: none; }
        .info-table td { border: none; padding: 2px 0; vertical-align: top; }
        .label { font-weight: bold; color: #555; width: 100px; display: inline-block; }

        table.main-table { width: 100%; border-collapse: collapse; }
        table.main-table th { background-color: #0d47a1; color: #ffffff; font-weight: bold; text-align: left; border: 1px solid #0d47a1; padding: 7px 5px; }
        table.main-table td { border: 1px solid #eee; padding: 6px 5px; vertical-align: top; }
        
        .opening-balance { background-color: #fff9c4; font-weight: bold; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-success { color: #2e7d32; font-weight: bold; }
        .text-danger { color: #c62828; font-weight: bold; }
        
        .footer { position: fixed; bottom: 0; width: 100%; font-size: 7.5pt; text-align: right; color: #888; border-top: 1px solid #eee; padding-top: 5px; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td style="width: 60%;">
                <div class="company-name">{{ $company->name ?? 'PT NBC INDONESIA' }}</div>
                <div style="font-size: 7.5pt;">{{ $company->address ?? '' }}</div>
                <div style="font-size: 7.5pt;">Telp: {{ $company->phone ?? '' }} | Email: {{ $company->email ?? '' }}</div>
            </td>
            <td style="text-align: right; width: 40%;">
                <div class="report-title">KARTU STOK PRODUK</div>
                <div style="font-size: 9pt; color: #666;">Dicetak: {{ date('d/m/Y H:i') }}</div>
            </td>
        </tr>
    </table>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td width="55%">
                    <div><span class="label">Produk:</span> <strong>{{ $item->name }}</strong></div>
                    <div><span class="label">SKU:</span> {{ $item->sku }}</div>
                    <div><span class="label">Kategori:</span> {{ $item->category->name }}</div>
                </td>
                <td width="45%">
                    <div><span class="label">Gudang:</span> {{ request('warehouse_id') ? \App\Models\Warehouse::find(request('warehouse_id'))->name : 'Semua Gudang' }}</div>
                    <div><span class="label">Periode:</span> {{ request('start_date') ?: 'Semua' }} s/d {{ request('end_date') ?: 'Sekarang' }}</div>
                    <div><span class="label">Stok Akhir:</span> <strong>{{ number_format($item->stock, 0, ',', '.') }} {{ $item->unit->short_name }}</strong></div>
                </td>
            </tr>
        </table>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th width="15%">Tanggal</th>
                <th width="20%">Referensi / Tipe</th>
                <th width="15%">Gudang</th>
                <th class="text-center" width="12%">Masuk</th>
                <th class="text-center" width="12%">Keluar</th>
                <th class="text-center" width="12%">Saldo</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @if(request('start_date'))
            <tr class="opening-balance">
                <td colspan="3" class="text-right">SALDO AWAL ({{ date('d/m/Y', strtotime(request('start_date'))) }})</td>
                <td class="text-center">---</td>
                <td class="text-center">---</td>
                <td class="text-center">{{ number_format($openingBalance, 0, ',', '.') }}</td>
                <td><small>Stock level before start date</small></td>
            </tr>
            @endif
            @foreach($ledgers as $ledger)
            <tr>
                <td>{{ $ledger->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <span style="font-weight: bold;">
                        @php
                            $labels = [
                                'App\Models\StockAdjustment' => 'Penyesuaian',
                                'App\Models\StockTransfer' => 'Transfer',
                                'App\Models\Production' => 'Produksi',
                                'App\Models\Sale' => 'Penjualan',
                                'App\Models\Purchase' => 'Pembelian',
                            ];
                            echo $labels[$ledger->reference_type] ?? $ledger->reference_type;
                        @endphp
                    </span>
                </td>
                <td>{{ $ledger->warehouse->name }}</td>
                <td class="text-center text-success">
                    {{ $ledger->type == 'in' ? number_format($ledger->qty_change, 0, ',', '.') : '-' }}
                </td>
                <td class="text-center text-danger">
                    {{ $ledger->type == 'out' ? number_format($ledger->qty_change, 0, ',', '.') : '-' }}
                </td>
                <td class="text-center"><strong>{{ number_format($ledger->qty_after, 0, ',', '.') }}</strong></td>
                <td><small style="color: #666;">{{ $ledger->notes ?: '-' }}</small></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Sistem Inventaris NBC Indonesia | Dokumen ini sah dan dicetak secara elektronik.
    </div>
</body>
</html>
