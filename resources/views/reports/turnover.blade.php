@extends('layouts.app')

@section('title', 'Laporan Perputaran Stok')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold text-gradient">
            <i class="fas fa-sync-alt me-2"></i>Analisis Perputaran Stok
        </h4>
        <div class="d-flex gap-2">
            <form action="{{ route('reports.turnover') }}" method="GET" class="d-flex gap-2">
                <select name="days" class="form-select" onchange="this.form.submit()">
                    <option value="30" {{ $days == 30 ? 'selected' : '' }}>30 Hari Terakhir</option>
                    <option value="60" {{ $days == 60 ? 'selected' : '' }}>60 Hari Terakhir</option>
                    <option value="90" {{ $days == 90 ? 'selected' : '' }}>90 Hari Terakhir (Default)</option>
                    <option value="180" {{ $days == 180 ? 'selected' : '' }}>180 Hari Terakhir</option>
                </select>
            </form>
            <button onclick="window.print()" class="btn btn-outline-primary">
                <i class="fas fa-print me-1"></i> Cetak
            </button>
        </div>
    </div>

    <div class="row g-4">
        {{-- Fast Moving Items --}}
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-header bg-white border-bottom-0 p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-soft-success p-3 rounded-3 me-3">
                            <i class="fas fa-bolt text-success fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Produk Fast Moving</h5>
                            <small class="text-muted">Item dengan volume penjualan tertinggi ({{ $days }} hari)</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-uppercase small text-muted">
                                    <th class="ps-4">Item</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Terjual</th>
                                    <th class="text-end pe-4">Stok Saat Ini</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fastMoving as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $item->name }}</div>
                                        <small class="text-muted">{{ $item->sku }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-info text-info">{{ $item->category->name ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="fw-bold text-success">{{ number_format($item->total_sold, 0, ',', '.') }}</div>
                                        <small class="text-muted">{{ $item->unit->name ?? 'unit' }}</small>
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="fw-bold">{{ number_format($item->stock, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <p class="text-muted">Tidak ada data penjualan dalam periode ini.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($fastMoving->count() > 0)
                <div class="card-footer bg-white border-top-0 p-4">
                    <div class="alert alert-info border-0 shadow-sm mb-0">
                        <i class="fas fa-info-circle me-2"></i> 
                        <strong>Saran Strategi:</strong> Segera lakukan restock untuk produk di atas karena permintaannya sangat tinggi.
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Slow Moving Items --}}
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-header bg-white border-bottom-0 p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-soft-danger p-3 rounded-3 me-3">
                            <i class="fas fa-hourglass-end text-danger fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Produk Slow Moving</h5>
                            <small class="text-muted">Stok mengendap tanpa penjualan ({{ $days }} hari)</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-uppercase small text-muted">
                                    <th class="ps-4">Item</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Stok Fisik</th>
                                    <th class="text-end pe-4">Nilai Aset (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($slowMoving as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $item->name }}</div>
                                        <small class="text-muted">{{ $item->sku }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-secondary text-secondary">{{ $item->category->name ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="fw-bold">{{ number_format($item->stock, 0, ',', '.') }}</div>
                                        <small class="text-muted">{{ $item->unit->name ?? 'unit' }}</small>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="fw-bold text-danger">{{ number_format($item->stock * ($item->purchase_price ?? 0), 0, ',', '.') }}</div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <p class="text-muted">Semua produk Anda bergerak aktif!</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($slowMoving->count() > 0)
                <div class="card-footer bg-white border-top-0 p-4">
                    <div class="alert alert-warning border-0 shadow-sm mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i> 
                        <strong>Saran Strategi:</strong> Consider promo/diskon atau bundling untuk mengurangi modal yang tertahan pada item-item ini.
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); }
    .bg-soft-danger { background-color: rgba(220, 53, 69, 0.1); }
    .bg-soft-info { background-color: rgba(13, 110, 253, 0.1); }
    .bg-soft-secondary { background-color: rgba(108, 117, 125, 0.1); }
    .text-gradient {
        background: linear-gradient(135deg, var(--bs-primary), var(--bs-secondary));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    @media print {
        .btn, form, .card-footer { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
        .container-fluid { padding: 0 !important; }
    }
</style>
@endpush
