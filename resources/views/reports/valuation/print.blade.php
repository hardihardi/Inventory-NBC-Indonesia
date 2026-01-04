<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Audit Valuasi Stok - {{ now()->format('Ymd') }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 10pt; color: #2d3436; margin: 0; padding: 0; }
        .header { border-bottom: 3px solid #0984e3; padding-bottom: 15px; margin-bottom: 25px; }
        .company-name { font-size: 18pt; font-weight: bold; color: #0984e3; }
        .company-info { font-size: 9pt; color: #636e72; }
        .report-title { font-size: 14pt; font-weight: bold; text-align: right; margin-top: -45px; text-transform: uppercase; color: #2d3436; }
        
        .info-table { width: 100%; margin-bottom: 20px; font-size: 9pt; }
        .info-table td { padding: 4px 0; }
        
        .summary-container { margin-bottom: 30px; }
        .summary-box { 
            display: inline-block; 
            width: 48%; 
            background: #f1f2f6; 
            padding: 15px; 
            border-radius: 8px;
            vertical-align: top;
        }
        .summary-title { font-size: 8pt; color: #636e72; text-transform: uppercase; margin-bottom: 5px; font-weight: bold; }
        .summary-value { font-size: 16pt; font-weight: bold; color: #0984e3; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { background-color: #0984e3; color: white; padding: 12px 10px; text-align: left; font-size: 8pt; text-transform: uppercase; }
        td { padding: 10px; border-bottom: 1px solid #dfe6e9; font-size: 9pt; }
        
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        
        .footer { position: fixed; bottom: 0; width: 100%; font-size: 8pt; color: #b2bec3; text-align: center; padding: 15px 0; border-top: 1px solid #dfe6e9; }
        .grand-total { background-color: #f1f2f6; }
        
        .badge { 
            padding: 3px 8px; 
            border-radius: 4px; 
            font-size: 8pt; 
            font-weight: bold;
        }
        .bg-primary { background: #0984e3; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ $company->name ?? 'PT NBC INDONESIA' }}</div>
        <div class="company-info">{{ $company->address ?? 'Warehouse & Textile Production Management System' }}</div>
        <div class="report-title">Audit Valuasi Stok</div>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%">Dicetak Pada</td>
            <td width="35%">: {{ now()->format('d F Y H:i') }}</td>
            <td width="15%">Basis Audit</td>
            <td width="35%">: {{ strtoupper($mode) }} ({{ $mode === 'sale' ? 'Potensi Jual' : ($mode === 'average' ? 'Rerata Beli' : 'Modal Dasar') }})</td>
        </tr>
        <tr>
            <td width="15%">Filter Gudang</td>
            <td width="35%">: {{ $warehouse ? $warehouse->name : 'Semua Gudang' }}</td>
            <td width="15%">Petugas Auditor</td>
            <td width="35%">: {{ auth()->user()->name }}</td>
        </tr>
    </table>

    <div class="summary-container">
        <div class="summary-box">
            <div class="summary-title">Nilai Total Valuasi</div>
            <div class="summary-value">Rp {{ number_format($totalValuation, 0, ',', '.') }}</div>
        </div>
        <div class="summary-box" style="margin-left: 2%;">
            <div class="summary-title">Total Varian Barang Teraudit</div>
            <div class="summary-value">{{ count($items) }} Produk</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="45%">Deskripsi Barang & SKU</th>
                <th width="15%" class="text-center">Stok Fisik</th>
                <th width="15%" class="text-end">Harga Satuan</th>
                <th width="20%" class="text-end">Subtotal Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    <div class="fw-bold">{{ $item->name }}</div>
                    <div style="font-size: 8pt; color: #636e72;">{{ $item->sku }} | {{ $item->category->name ?? 'N/A' }}</div>
                </td>
                <td class="text-center">
                    {{ number_format($item->current_stock, 0, ',', '.') }}
                    <span style="font-size: 8pt; color: #636e72;">{{ $item->unit->short_name ?? '' }}</span>
                </td>
                <td class="text-end">Rp {{ number_format($item->active_price, 0, ',', '.') }}</td>
                <td class="text-end fw-bold">Rp {{ number_format($item->valuation, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="grand-total">
                <td colspan="4" class="text-end fw-bold" style="padding: 15px;">TOTAL NILAI AUDIT</td>
                <td class="text-end fw-bold" style="padding: 15px; color: #0984e3; font-size: 11pt;">Rp {{ number_format($totalValuation, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dokumen ini diterbitkan secara digital oleh {{ config('app.name') }} dan sah tanpa tanda tangan fisik. <br>
        {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>
