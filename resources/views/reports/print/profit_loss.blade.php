<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Laba Rugi - {{ $filterMonth }}/{{ $filterYear }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 9pt; color: #333; line-height: 1.4; }
        @page { margin: 1.2cm; }
        
        .header-table { width: 100%; border-bottom: 2px solid #0d47a1; padding-bottom: 10px; margin-bottom: 20px; }
        .company-name { font-size: 15pt; font-weight: bold; color: #0d47a1; text-transform: uppercase; }
        .report-title { font-size: 13pt; font-weight: bold; text-align: right; }
        
        table.pl-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table.pl-table td { padding: 8px 5px; vertical-align: middle; border-bottom: 1px solid #f0f0f0; }
        
        .section-header { background-color: #0d47a1; color: #ffffff; font-weight: bold; text-transform: uppercase; font-size: 8.5pt; }
        .row-indent { padding-left: 25px !important; }
        .row-subtotal { font-weight: bold; border-top: 1px solid #333 !important; border-bottom: 1px solid #333 !important; background-color: #fafafa; }
        .row-grand-total { font-weight: bold; font-size: 11pt; color: #ffffff; background-color: #0d47a1; border: 2px solid #0d47a1; }
        
        .text-right { text-align: right; }
        .text-danger { color: #c62828; font-weight: bold; }
        .text-success { color: #2e7d32; font-weight: bold; }
        
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
                <div class="report-title">LAPORAN LABA RUGI</div>
                <div style="font-size: 9pt; color: #666;">Periode: {{ \Carbon\Carbon::createFromDate($filterYear, $filterMonth, 1)->translatedFormat('F Y') }}</div>
                <div style="font-size: 7.5pt; color: #888;">Dicetak: {{ date('d/m/Y H:i') }}</div>
            </td>
        </tr>
    </table>

    <table class="pl-table">
        <tbody>
            {{-- PENDAPATAN --}}
            <tr class="section-header">
                <td>I. PENDAPATAN OPERASIONAL</td>
                <td class="text-right">NOMINAL</td>
            </tr>
            <tr>
                <td class="row-indent">Penjualan Benang & Kain</td>
                <td class="text-right">Rp {{ number_format($penjualanTextile ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="row-indent">Penjualan Kimia & Penunjang</td>
                <td class="text-right">Rp {{ number_format($penjualanPenunjang ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="row-indent">Retur Penjualan (-)</td>
                <td class="text-right text-danger">(Rp {{ number_format($returPenjualan, 0, ',', '.') }})</td>
            </tr>
            <tr class="row-subtotal">
                <td>TOTAL PENDAPATAN BERSIH</td>
                <td class="text-right">Rp {{ number_format($totalPendapatanBersih, 0, ',', '.') }}</td>
            </tr>

            {{-- HPP --}}
            <tr><td colspan="2" style="border:none; padding: 10px 0;"></td></tr>
            <tr class="section-header">
                <td>II. HARGA POKOK PRODUKSI (HPP)</td>
                <td class="text-right"></td>
            </tr>
            <tr>
                <td class="row-indent">Pemakaian Bahan Baku (Direct Materials)</td>
                <td class="text-right text-danger">- Rp {{ number_format($materialUsageCost, 0, ',', '.') }}</td>
            </tr>
            <tr class="row-subtotal">
                <td>TOTAL BIAYA PRODUKSI (HPP)</td>
                <td class="text-right text-danger">- Rp {{ number_format($materialUsageCost, 0, ',', '.') }}</td>
            </tr>
            
            <tr class="row-subtotal" style="background-color: #e3f2fd;">
                <td>LABA KOTOR OPERASIONAL</td>
                <td class="text-right {{ $labaKotor >= 0 ? 'text-success' : 'text-danger' }}">
                    Rp {{ number_format($labaKotor, 0, ',', '.') }}
                </td>
            </tr>

            {{-- BIAYA OPERASIONAL --}}
            <tr><td colspan="2" style="border:none; padding: 10px 0;"></td></tr>
            <tr class="section-header">
                <td>III. BIAYA OPERASIONAL & UMUM</td>
                <td class="text-right"></td>
            </tr>
            @forelse($expenseGroups as $cat => $amount)
            <tr>
                <td class="row-indent">Beban {{ $cat }}</td>
                <td class="text-right text-danger">- Rp {{ number_format($amount, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td class="row-indent text-muted"><em>Tidak ada pengeluaran operasional</em></td>
                <td class="text-right">Rp 0</td>
            </tr>
            @endforelse
            <tr class="row-subtotal">
                <td>TOTAL BIAYA OPERASIONAL</td>
                <td class="text-right text-danger">- Rp {{ number_format($totalExpenses, 0, ',', '.') }}</td>
            </tr>

            {{-- LABA BERSIH --}}
            <tr><td colspan="2" style="border:none; padding: 20px 0;"></td></tr>
            <tr class="row-grand-total">
                <td style="padding: 15px;">NET PROFIT / (LOSS) BERSIH</td>
                <td class="text-right" style="padding: 15px;">
                    Rp {{ number_format($labaRugiBersih, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Sistem Informasi NBC Indonesia | Laporan Laba Rugi ini dihasilkan secara otomatis.
    </div>
</body>
</html>