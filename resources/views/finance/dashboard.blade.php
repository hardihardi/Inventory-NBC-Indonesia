@extends('layouts.app')

@section('title', 'Finance Dashboard')

@section('content')
<div class="container-fluid py-2">
    <!-- Header with Filters -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 1rem; background: linear-gradient(135deg, #f8f9fa, #ffffff);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-3 mb-lg-0">
                    <h4 class="fw-bold text-primary mb-1"><i class="fas fa-chart-pie me-2"></i>Analisis Keuangan</h4>
                    <p class="text-muted small mb-0">Pemantauan arus kas, piutang, dan hutang secara real-time.</p>
                </div>
                <div class="col-lg-6">
                    <form action="{{ route('finance.dashboard') }}" method="GET" class="row g-2 justify-content-lg-end">
                        <div class="col-sm-4 col-md-4 col-lg-3">
                            <label class="x-small fw-bold text-muted text-uppercase mb-1 d-block">Dari</label>
                            <input type="date" name="start_date" class="form-control form-control-sm border-0 bg-light shadow-none" value="{{ $startDate }}">
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-3">
                            <label class="x-small fw-bold text-muted text-uppercase mb-1 d-block">Sampai</label>
                            <input type="date" name="end_date" class="form-control form-control-sm border-0 bg-light shadow-none" value="{{ $endDate }}">
                        </div>
                        <div class="col-sm-3 col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-sm w-100 shadow-sm px-3"><i class="fas fa-filter me-1"></i> Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Cards Section -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm bg-primary text-white overflow-hidden card-stat">
                <div class="card-body p-4 position-relative z-1">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-white bg-opacity-25 rounded-circle p-2"><i class="fas fa-wallet fa-lg"></i></div>
                        <span class="x-small fw-bold text-uppercase opacity-75">Saldo Kas Saat Ini</span>
                    </div>
                    <h3 class="fw-bold mb-1">Rp {{ number_format($currentBalance, 0, ',', '.') }}</h3>
                    <div class="d-flex align-items-center x-small opacity-75">
                        <i class="fas fa-info-circle me-1"></i> Total saldo seluruh waktu
                    </div>
                </div>
                <div class="stat-decoration"></div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm bg-dark text-white card-stat">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-white bg-opacity-10 rounded-circle p-2 text-warning"><i class="fas fa-chart-line fa-lg"></i></div>
                        <span class="x-small fw-bold text-uppercase opacity-75">Net Movement</span>
                    </div>
                    <h3 class="fw-bold mb-1 {{ $netProfit >= 0 ? 'text-white' : 'text-danger' }}">
                        {{ $netProfit >= 0 ? '+' : '' }}Rp {{ number_format($netProfit, 0, ',', '.') }}
                    </h3>
                    <div class="d-flex align-items-center x-small opacity-75">
                        <i class="fas fa-calendar-alt me-1"></i> Periode terpilih
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm bg-white card-stat">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 text-primary"><i class="fas fa-hand-holding-usd fa-lg"></i></div>
                        <span class="x-small fw-bold text-uppercase text-muted">Total Piutang</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</h3>
                    <div class="d-flex align-items-center x-small text-danger fw-bold">
                        <i class="fas fa-exclamation-circle me-1"></i> Overdue: Rp {{ number_format($overduePiutang, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm bg-white card-stat">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-danger bg-opacity-10 rounded-circle p-2 text-danger"><i class="fas fa-file-invoice-dollar fa-lg"></i></div>
                        <span class="x-small fw-bold text-uppercase text-muted">Total Hutang</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">Rp {{ number_format($totalHutang, 0, ',', '.') }}</h3>
                    <div class="d-flex align-items-center x-small text-danger fw-bold">
                        <i class="fas fa-clock me-1"></i> Overdue: Rp {{ number_format($overdueHutang, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem;">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-dark">Arus Kas 6 Bulan Terakhir</h6>
                </div>
                <div class="card-body">
                    <div style="height: 350px;">
                        <canvas id="cashInVsOutChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem;">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="mb-0 fw-bold text-dark">Distribusi Pengeluaran</h6>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    @if($expenseBreakdown->count() > 0)
                        <div style="width: 100%; height: 250px;">
                            <canvas id="expenseChart"></canvas>
                        </div>
                        <div class="mt-4 w-100">
                            @foreach($expenseBreakdown->take(4) as $ex)
                                <div class="d-flex justify-content-between align-items-center mb-2 x-small fw-medium">
                                    <span class="text-muted"><i class="fas fa-square me-1" style="color: {{ ['#6366f1', '#f43f5e', '#10b981', '#f59e0b', '#8b5cf6'][$loop->index] ?? '#ccc' }}"></i> {{ $ex->category }}</span>
                                    <span class="text-dark">Rp {{ number_format($ex->total, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 opacity-50">
                            <i class="fas fa-chart-pie fa-4x mb-3"></i>
                            <p class="small">Belum ada pengeluaran di periode ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-dark">Piutang Jatuh Tempo</h6>
                    <a href="{{ route('finance.receivables') }}" class="btn btn-xs btn-outline-primary shadow-none">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="x-small fw-bold text-muted">
                                    <th class="ps-4">CUSTOMER</th>
                                    <th>JATUH TEMPO</th>
                                    <th class="text-end pe-4">SISA TAGIHAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topReceivables as $row)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold">{{ $row->customer->name }}</div>
                                        <small class="text-muted">{{ $row->invoice_number }}</small>
                                    </td>
                                    <td>
                                        <span class="badge {{ $row->due_date && $row->due_date < now() ? 'bg-soft-danger text-danger' : 'bg-soft-warning text-warning' }} x-small px-2">
                                            {{ $row->due_date ? $row->due_date->format('d M Y') : '-' }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4 fw-bold text-dark">
                                        Rp {{ number_format($row->grand_total - $row->paid_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center py-4 text-muted small">Tidak ada piutang jatuh tempo.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-dark">Hutang Jatuh Tempo</h6>
                    <a href="{{ route('finance.payables') }}" class="btn btn-xs btn-outline-danger shadow-none">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="x-small fw-bold text-muted">
                                    <th class="ps-4">SUPPLIER</th>
                                    <th>JATUH TEMPO</th>
                                    <th class="text-end pe-4">SISA BAYAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topPayables as $row)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold">{{ $row->supplier->name }}</div>
                                        <small class="text-muted">{{ $row->invoice_number }}</small>
                                    </td>
                                    <td>
                                        <span class="badge {{ $row->due_date && $row->due_date < now() ? 'bg-soft-danger text-danger' : 'bg-soft-warning text-warning' }} x-small px-2">
                                            {{ $row->due_date ? $row->due_date->format('d M Y') : '-' }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4 fw-bold text-dark">
                                        Rp {{ number_format($row->total_amount - $row->paid_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center py-4 text-muted small">Tidak ada hutang jatuh tempo.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // 1. Performance Chart (In vs Out)
    const monthlyData = @json($monthlyCashFlow);
    const labels = monthlyData.map(d => d.label);
    const cashInData = monthlyData.map(d => d.in);
    const cashOutData = monthlyData.map(d => d.out);

    const perfCtx = document.getElementById('cashInVsOutChart').getContext('2d');

    new Chart(perfCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Uang Masuk',
                    data: cashInData,
                    backgroundColor: 'rgba(99, 102, 241, 0.8)',
                    borderColor: '#6366f1',
                    borderWidth: 1,
                    borderRadius: 5,
                },
                {
                    label: 'Uang Keluar',
                    data: cashOutData,
                    backgroundColor: 'rgba(244, 63, 94, 0.8)',
                    borderColor: '#f43f5e',
                    borderWidth: 1,
                    borderRadius: 5,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { usePointStyle: true, boxWidth: 6, font: { size: 11, weight: 'bold' } } },
                tooltip: { backgroundColor: '#1e293b', titleColor: '#fff', bodyColor: '#fff', bodyFont: { size: 12 }, callbacks: { label: (context) => context.dataset.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.raw) } }
            },
            scales: {
                y: { grid: { borderDash: [5, 5], color: '#e2e8f0' }, ticks: { font: { size: 10 }, callback: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v) } },
                x: { grid: { display: false }, ticks: { font: { size: 10 } } }
            }
        }
    });

    // 2. Expense Distribution Chart
    const breakdownData = @json($expenseBreakdown);
    if (breakdownData.length > 0) {
        const expCtx = document.getElementById('expenseChart').getContext('2d');
        new Chart(expCtx, {
            type: 'doughnut',
            data: {
                labels: breakdownData.map(d => d.category),
                datasets: [{
                    data: breakdownData.map(d => d.total),
                    backgroundColor: ['#6366f1', '#f43f5e', '#10b981', '#f59e0b', '#8b5cf6', '#06b6d4'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: (context) => context.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.raw) } }
                }
            }
        });
    }
});
</script>
@endpush

@push('styles')
<style>
    .card-stat { transition: transform 0.3s ease, box-shadow 0.3s ease; border-radius: 1rem; }
    .card-stat:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .stat-decoration { position: absolute; right: -50px; bottom: -50px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 100px; z-index: 0; }
    .x-small { font-size: 0.75rem; }
    .btn-xs { padding: 0.25rem 0.5rem; font-size: 0.7rem; border-radius: 0.4rem; }
    .bg-soft-danger { background-color: rgba(244, 63, 94, 0.1); }
    .bg-soft-warning { background-color: rgba(245, 158, 11, 0.1); }
    .bg-soft-primary { background-color: rgba(99, 102, 241, 0.1); }
</style>
@endpush
@endsection
