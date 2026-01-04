@extends('layouts.app')

@section('title', 'Valuasi Inventaris')

@section('content')
<div class="container-fluid py-2">
    <!-- Header Section -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 1rem; background: linear-gradient(135deg, #f8f9fa, #ffffff);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-3 mb-lg-0">
                    <h4 class="fw-bold text-primary mb-1"><i class="fas fa-coins me-2"></i>Audit Valuasi Stok</h4>
                    <p class="text-muted small mb-0">Audit nilai aset dan kesehatan inventaris di seluruh gudang.</p>
                </div>
                <div class="col-lg-7">
                    <form action="{{ route('reports.valuation.index') }}" method="GET" class="row g-2 justify-content-lg-end">
                        <div class="col-sm-4 col-md-4 col-lg-3">
                            <label class="x-small fw-bold text-muted text-uppercase mb-1 d-block">Gudang</label>
                            <select name="warehouse_id" class="form-select form-select-sm border-0 bg-light shadow-none select2">
                                <option value="">Semua Gudang</option>
                                @foreach($warehouses as $w)
                                    <option value="{{ $w->id }}" {{ $warehouseId == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-3">
                            <label class="x-small fw-bold text-muted text-uppercase mb-1 d-block">Kategori</label>
                            <select name="category_id" class="form-select form-select-sm border-0 bg-light shadow-none select2">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3 col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-sm w-100 shadow-sm px-3"><i class="fas fa-filter"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytical KPI Strip -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm bg-primary text-white overflow-hidden card-stat">
                <div class="card-body p-4 position-relative z-1">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-white bg-opacity-25 rounded-circle p-2"><i class="fas fa-vault fa-lg"></i></div>
                        <span class="x-small fw-bold text-uppercase opacity-75">Total Valuasi Aset</span>
                    </div>
                    <h3 class="fw-bold mb-1">Rp {{ number_format($totalValuation, 0, ',', '.') }}</h3>
                    <div class="d-flex align-items-center x-small opacity-75">
                        <i class="fas fa-tag me-1"></i> Mode: {{ $mode === 'sale' ? 'Harga Jual' : ($mode === 'average' ? 'Rerata Beli' : 'Modal Awal') }}
                    </div>
                </div>
                <div class="stat-decoration"></div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm bg-white card-stat">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-danger bg-opacity-10 rounded-circle p-2 text-danger"><i class="fas fa-stopwatch fa-lg"></i></div>
                        <span class="x-small fw-bold text-uppercase text-muted">Aset Stok Mati</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-danger">Rp {{ number_format($deadStockValue, 0, ',', '.') }}</h3>
                    <div class="d-flex align-items-center x-small text-muted fw-bold">
                        <i class="fas fa-info-circle me-1"></i> Tidak terjual > 90 hari
                    </div>
                </div>
            </div>
        </div>

        @if($mode !== 'sale')
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm bg-white card-stat">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle p-2 text-success"><i class="fas fa-chart-line fa-lg"></i></div>
                        <span class="x-small fw-bold text-uppercase text-muted">Potensi Laba Kotor</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-success">Rp {{ number_format($potentialProfit, 0, ',', '.') }}</h3>
                    <div class="d-flex align-items-center x-small text-muted fw-bold">
                        <i class="fas fa-arrow-up me-1"></i> Jika semua aset terjual
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm bg-white card-stat">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-info bg-opacity-10 rounded-circle p-2 text-info"><i class="fas fa-boxes fa-lg"></i></div>
                        <span class="x-small fw-bold text-uppercase text-muted">Total Varian Barang</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">{{ $totalItems }} Produk</h3>
                    <div class="d-flex align-items-center x-small text-muted fw-bold">
                        <i class="fas fa-check-circle me-1"></i> Stok tersedia ( > 0 )
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm bg-white card-stat">
                <div class="card-body p-4">
                    <h6 class="x-small fw-bold text-uppercase text-muted mb-3">Basis Perhitungan</h6>
                    <form action="{{ route('reports.valuation.index') }}" method="GET" id="modeForm">
                        @if($categoryId)<input type="hidden" name="category_id" value="{{ $categoryId }}">@endif
                        @if($warehouseId)<input type="hidden" name="warehouse_id" value="{{ $warehouseId }}">@endif
                        <div class="btn-group w-100 shadow-none border rounded" role="group">
                            <input type="radio" class="btn-check" name="mode" id="modeCost" value="cost" {{ $mode === 'cost' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="btn btn-sm btn-outline-light text-dark border-0 py-2 x-small fw-bold" for="modeCost">BELI</label>

                            <input type="radio" class="btn-check" name="mode" id="modeAvg" value="average" {{ $mode === 'average' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="btn btn-sm btn-outline-light text-dark border-0 py-2 x-small fw-bold" for="modeAvg">RERATA</label>

                            <input type="radio" class="btn-check" name="mode" id="modeSale" value="sale" {{ $mode === 'sale' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="btn btn-sm btn-outline-light text-dark border-0 py-2 x-small fw-bold" for="modeSale">JUAL</label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem;">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-chart-pie me-2 text-primary"></i>Komposisi Nilai Kategori</h6>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem;">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-heartbeat me-2 text-danger"></i>Kesehatan Inventaris</h6>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Table -->
    <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold text-dark">Daftar Detail Valuasi Barang</h6>
            <div class="d-flex gap-2">
                <input type="text" id="tableSearch" class="form-control form-control-sm border-0 bg-light px-3" placeholder="Cari nama barang..." style="width: 200px;">
                <a href="{{ route('reports.valuation.print', request()->all()) }}" target="_blank" class="btn btn-xs btn-outline-danger shadow-none"><i class="fas fa-file-pdf me-1"></i> PDF</a>
                <a href="{{ route('reports.valuation.export', request()->all()) }}" class="btn btn-xs btn-outline-success shadow-none"><i class="fas fa-file-excel me-1"></i> Excel</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="valuationTable">
                    <thead class="bg-light">
                        <tr class="x-small fw-bold text-muted">
                            <th class="ps-4">BARANG & SKU</th>
                            <th>KATEGORI</th>
                            <th class="text-center">STOK</th>
                            <th class="text-end">HARGA UNIT</th>
                            <th class="text-end">SUBTOTAL NILAI</th>
                            <th class="text-center">STATUS & TERAKHIR TERJUAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                        <tr class="{{ $item->is_dead ? 'bg-light bg-opacity-10' : '' }}">
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $item->name }}</div>
                                <div class="x-small text-muted">{{ $item->sku }}</div>
                            </td>
                            <td><span class="badge bg-soft-primary text-primary rounded-pill px-3">{{ $item->category->name ?? 'N/A' }}</span></td>
                            <td class="text-center fw-bold text-dark">
                                {{ number_format($item->current_stock, 0, ',', '.') }}
                                <div class="x-small text-muted fw-normal">{{ $item->unit->short_name ?? '' }}</div>
                            </td>
                            <td class="text-end">Rp {{ number_format($item->active_price, 0, ',', '.') }}</td>
                            <td class="text-end fw-bold text-primary">Rp {{ number_format($item->valuation, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="badge bg-{{ $item->status_color }} x-small px-3 rounded-pill mb-1 d-inline-block">{{ $item->status_label }}</span>
                                <div class="x-small text-muted">
                                    <i class="fas fa-shopping-cart me-1"></i> {{ $item->last_sold_date ? \Carbon\Carbon::parse($item->last_sold_date)->format('d M Y') : 'Belum pernah' }}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-5 text-muted small">Tidak ada data ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.select2').select2({ theme: 'bootstrap-5' });

    $("#tableSearch").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#valuationTable tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // 1. Category Chart
    const catData = @json($categoryData);
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(catData),
            datasets: [{
                data: Object.values(catData),
                backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#f43f5e', '#8b5cf6', '#06b6d4'],
                borderWidth: 0,
                hoverOffset: 12
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 6, font: { size: 10 } } },
                tooltip: { callbacks: { label: (c) => c.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(c.raw) } }
            }
        }
    });

    // 2. Status Health Chart
    const statData = @json($statusData);
    new Chart(document.getElementById('statusChart'), {
        type: 'polarArea',
        data: {
            labels: Object.keys(statData),
            datasets: [{
                data: Object.values(statData),
                backgroundColor: [
                    'rgba(16, 185, 129, 0.7)', // Healthy
                    'rgba(244, 63, 94, 0.7)',  // Dead
                    'rgba(245, 158, 11, 0.7)', // Low
                    'rgba(100, 116, 139, 0.7)' // Out
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 6, font: { size: 10 } } }
            },
            scales: { r: { ticks: { display: false }, grid: { color: '#f1f5f9' } } }
        }
    });
});
</script>
@endpush

@push('styles')
<style>
    .card-stat { transition: transform 0.3s ease; border-radius: 1rem; }
    .card-stat:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .stat-decoration { position: absolute; right: -50px; bottom: -50px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 100px; z-index: 0; }
    .x-small { font-size: 0.75rem; }
    .btn-xs { padding: 0.25rem 0.5rem; font-size: 0.7rem; border-radius: 0.4rem; }
    .bg-soft-primary { background-color: rgba(99, 102, 241, 0.1); }
    .select2-container--bootstrap-5 .select2-selection { border: none !important; background-color: #f8f9fa !important; font-size: 0.75rem !important; }
</style>
@endpush
