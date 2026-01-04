@extends('layouts.app')

@section('title', 'Laporan Laba Rugi - Teknis Tekstil')

@section('content')
<div class="container-fluid">
    {{-- Header Halaman dengan Filter --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div>
            <h4 class="mb-0 fw-bold text-gradient">
                <i class="fas fa-industry me-2"></i>Laporan Laba Rugi Tekstil
            </h4>
            <p class="text-muted small mb-0">Analisis Keuangan & Biaya Produksi</p>
        </div>
        <form action="{{ route('reports.profit_loss') }}" method="GET" class="d-flex align-items-center gap-2 mt-2 mt-md-0">
            @include('reports.partials.month_year_filter')
            <button type="submit" class="btn btn-primary d-flex align-items-center">
                <i class="fas fa-search me-1"></i> <span class="d-none d-sm-inline">Tampilkan</span>
            </button>
            @if(Auth::user()->hasPermission('reports.print'))
            <a href="{{ route('reports.print_profit_loss', ['month' => $filterMonth, 'year' => $filterYear]) }}"
                target="_blank" class="btn btn-success d-flex align-items-center">
                <i class="fas fa-print me-1"></i> <span class="d-none d-sm-inline">Cetak PDF</span>
            </a>
            @endif
        </form>
    </div>

    <div class="row">
        {{-- Ringkasan Utama --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body p-0">
                    <div class="p-4 bg-primary text-white">
                        <h6 class="text-uppercase opacity-75 mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">Laba Bersih Periode Ini</h6>
                        <h2 class="fw-bold mb-0">
                            @if($labaRugiBersih < 0)
                                (Rp {{ number_format(abs($labaRugiBersih), 0, ',', '.') }})
                            @else
                                Rp {{ number_format($labaRugiBersih, 0, ',', '.') }}
                            @endif
                        </h2>
                        <div class="mt-3">
                            <span class="badge bg-white bg-opacity-25 py-2 px-3">
                                <i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::createFromDate($filterYear, $filterMonth, 1)->isoFormat('MMMM YYYY') }}
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Profit Margin</span>
                            <span class="fw-bold text-primary">
                                {{ $totalPendapatanBersih > 0 ? number_format(($labaRugiBersih / $totalPendapatanBersih) * 100, 1) : 0 }}%
                            </span>
                        </div>
                        <div class="progress shadow-sm" style="height: 10px;">
                            <div class="progress-bar bg-primary" role="progressbar" 
                                style="width: {{ $totalPendapatanBersih > 0 ? max(0, min(100, ($labaRugiBersih / $totalPendapatanBersih) * 100)) : 0 }}%"></div>
                        </div>
                        <hr class="my-4">
                        <div class="row text-center g-2">
                            <div class="col-6">
                                <div class="p-2 border rounded">
                                    <small class="text-muted d-block">Sales Growth</small>
                                    <span class="fw-bold text-success"><i class="fas fa-arrow-up me-1"></i> -</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 border rounded">
                                    <small class="text-muted d-block">Cost Efficiency</small>
                                    <span class="fw-bold text-info"><i class="fas fa-check-circle me-1"></i> Good</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Perhitungan Laba Rugi --}}
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title mb-0 fw-bold">Detail Analisis Keuangan</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <tbody>
                                {{-- 1. PENDAPATAN --}}
                                <tr class="bg-light">
                                    <td colspan="2" class="fw-bold py-3"><i class="fas fa-money-bill-wave text-success me-2"></i>I. PENDAPATAN</td>
                                </tr>
                                <tr>
                                    <td class="ps-4">Penjualan Benang & Kain</td>
                                    <td class="text-end">Rp {{ number_format($penjualanTextile ?? 0, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-4">Penjualan Kimia & Penunjang</td>
                                    <td class="text-end">Rp {{ number_format($penjualanPenunjang ?? 0, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-4 text-danger">Retur Penjualan (-)</td>
                                    <td class="text-end text-danger">- Rp {{ number_format($returPenjualan, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="fw-bold border-top">
                                    <td class="ps-4">PENDAPATAN BERSIH</td>
                                    <td class="text-end">Rp {{ number_format($totalPendapatanBersih, 0, ',', '.') }}</td>
                                </tr>

                                {{-- 2. HPP --}}
                                <tr class="bg-light">
                                    <td colspan="2" class="fw-bold py-3"><i class="fas fa-tools text-warning me-2"></i>II. HARGA POKOK PRODUKSI (HPP)</td>
                                </tr>
                                <tr>
                                    <td class="ps-4">Biaya Pemakaian Bahan Baku (Materials Used)</td>
                                    <td class="text-end text-danger">Rp {{ number_format($materialUsageCost, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="fw-bold border-top">
                                    <td class="ps-4">LABA KOTOR PRODUKSI</td>
                                    <td class="text-end text-primary">Rp {{ number_format($labaKotor, 0, ',', '.') }}</td>
                                </tr>

                                {{-- 3. BIAYA OPERASIONAL --}}
                                <tr class="bg-light">
                                    <td colspan="2" class="fw-bold py-3"><i class="fas fa-chart-line text-info me-2"></i>III. BIAYA OPERASIONAL & UMUM</td>
                                </tr>
                                @forelse($expenseGroups as $cat => $amount)
                                <tr>
                                    <td class="ps-4">Beban {{ $cat }}</td>
                                    <td class="text-end text-danger">Rp {{ number_format($amount, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="ps-4 text-muted italic">Tidak ada catatan pengeluaran operasional.</td>
                                </tr>
                                @endforelse
                                <tr class="fw-bold border-top">
                                    <td class="ps-4">TOTAL BIAYA OPERASIONAL</td>
                                    <td class="text-end text-danger">- Rp {{ number_format($totalExpenses, 0, ',', '.') }}</td>
                                </tr>

                                {{-- 4. HASIL AKHIR --}}
                                <tr class="{{ $labaRugiBersih >= 0 ? 'bg-success text-white' : 'bg-danger text-white' }}">
                                    <td class="fw-bold py-3 ps-4" style="font-size: 1.1rem;">LABA / (RUGI) BERSIH</td>
                                    <td class="text-end fw-bold py-3 pe-4" style="font-size: 1.1rem;">
                                        @if($labaRugiBersih < 0)
                                            (Rp {{ number_format(abs($labaRugiBersih), 0, ',', '.') }})
                                        @else
                                            Rp {{ number_format($labaRugiBersih, 0, ',', '.') }}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-info border-0 shadow-sm d-flex align-items-center">
        <i class="fas fa-info-circle me-3 fa-2x"></i>
        <div>
            <strong>Info Sistem Produksi:</strong> Laba Kotor dihitung berdasarkan nilai pemakaian bahan baku dari laporan produksi yang berstatus <strong>"Completed"</strong>. Biaya pembelian barang langsung tetap dihitung sebagai pergerakan stok namun tidak langsung mengurangi laba sampai barang tersebut digunakan atau terjual.
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .text-gradient {
        background: linear-gradient(135deg, #0D47A1, #1976D2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .table > :not(caption) > * > * {
        padding: 0.75rem 1.25rem;
    }
</style>
@endpush