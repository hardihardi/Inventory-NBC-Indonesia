<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Label Produk - PT NBC Indonesia</title>
    <style>
        /* CSS Reset for Thermal Printers */
        @page {
            size: 50mm 30mm;
            margin: 0;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
            -webkit-print-color-adjust: exact;
        }

        .label-container {
            width: 50mm;
            height: 30mm;
            padding: 2mm;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
            background: #fff;
            page-break-after: always;
        }

        /* Border only for screen preview */
        @media screen {
            body { background: #f0f2f5; padding: 20px; display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; }
            .label-container { border: 1px dashed #ccc; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
            .no-print { width: 100%; text-align: center; margin-bottom: 20px; }
        }

        @media print {
            .no-print { display: none !important; }
            body { background: #fff; padding: 0; }
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 0.5pt solid #000;
            padding-bottom: 1mm;
            margin-bottom: 1.5mm;
        }

        .company-info {
            flex: 1;
        }

        .company-name {
            font-size: 6.5pt;
            font-weight: 800;
            color: #000;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.2mm;
        }

        .brand-text {
            font-size: 5.5pt;
            color: #333;
            margin: 0;
            font-weight: 600;
        }

        .content {
            display: flex;
            gap: 2mm;
            height: 18mm;
        }

        .qr-section {
            width: 16mm;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .qr-code svg {
            width: 16mm !important;
            height: 16mm !important;
        }

        .sku-text {
            font-size: 5pt;
            font-weight: bold;
            font-family: monospace;
            margin-top: 0.5mm;
            text-align: center;
            width: 100%;
            overflow: hidden;
            white-space: nowrap;
        }

        .details-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .item-name {
            font-size: 7.5pt;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 1mm;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            color: #000;
        }

        .spec-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5mm 2mm;
        }

        .spec-item {
            display: flex;
            flex-direction: column;
        }

        .spec-label {
            font-size: 4.5pt;
            color: #666;
            text-transform: uppercase;
            font-weight: 600;
        }

        .spec-value {
            font-size: 5.5pt;
            font-weight: 700;
            color: #000;
            white-space: nowrap;
            overflow: hidden;
        }

        .footer-tag {
            position: absolute;
            bottom: 1.5mm;
            right: 2mm;
            font-size: 4.5pt;
            font-style: italic;
            color: #999;
        }

        .btn { padding: 10px 24px; border-radius: 50px; font-weight: bold; cursor: pointer; text-decoration: none; border: none; font-size: 14px; transition: 0.2s; }
        .btn-primary { background: #0d6efd; color: #fff; box-shadow: 0 4px 12px rgba(13,110,253,0.3); }
        .btn-primary:hover { background: #0b5ed7; transform: translateY(-1px); }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print me-2"></i>Cetak Sekarang
        </button>
        <p style="font-size: 10pt; color: #666; margin-top: 15px;">Target: 50x30mm Thermal Paper. Pastikan Margin diatur ke "None" pada dialog print.</p>
    </div>

    @foreach ($items as $item)
    <div class="label-container">
        {{-- Header Section --}}
        <div class="header">
            <div class="company-info">
                <p class="company-name">{{ $company->name ?? 'PT NBC INDONESIA' }}</p>
                <p class="brand-text">{{ $item->brand ?? 'Textile Division' }}</p>
            </div>
            <div style="font-size: 5pt; font-weight: bold; text-align: right;">
                {{ $item->category->name ?? 'PRODUCT' }}
            </div>
        </div>

        {{-- Main Content --}}
        <div class="content">
            <div class="qr-section">
                <div class="qr-code">
                    {!! $item->qr_code_svg !!}
                </div>
                <div class="sku-text">{{ $item->sku }}</div>
            </div>

            <div class="details-section">
                <div class="item-name">{{ $item->name }}</div>
                
                <div class="spec-grid">
                    @if($item->gsm)
                    <div class="spec-item">
                        <span class="spec-label">GSM</span>
                        <span class="spec-value">{{ $item->gsm }}</span>
                    </div>
                    @endif
                    
                    @if($item->width)
                    <div class="spec-item">
                        <span class="spec-label">Width</span>
                        <span class="spec-value">{{ $item->width }}</span>
                    </div>
                    @endif

                    @if($item->color_name)
                    <div class="spec-item" style="grid-column: span 2;">
                        <span class="spec-label">Color</span>
                        <span class="spec-value">{{ $item->color_name }}</span>
                    </div>
                    @endif

                    @if(!$item->gsm && !$item->width && !$item->color_name && $item->technical_spec)
                    <div class="spec-item" style="grid-column: span 2;">
                        <span class="spec-label">Spec</span>
                        <span class="spec-value">{{ \Illuminate\Support\Str::limit($item->technical_spec, 25) }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="footer-tag">System Integrated v1.0</div>
    </div>
    @endforeach

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
