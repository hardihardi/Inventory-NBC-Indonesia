@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
  <div class="container-fluid py-2">
    {{-- Header Sambutan --}}
    <div class="mb-4">
      <h4 class="fw-bold mb-1">Selamat Datang Kembali, {{ Auth::user()->name }}! 👋</h4>
      <p class="text-muted small">Berikut adalah ringkasan aktivitas Anda hari ini,
        {{ \Carbon\Carbon::now()->isoFormat('dddd, DD MMMM YYYY') }}.
      </p>
    </div>


    {{-- Kartu Statistik Utama (KPI Cards) --}}
    <div class="row g-3 mb-4">
      {{-- Penjualan Bersih Hari Ini (Hanya Admin, Procurement, Finance) --}}
      @if(Auth::user()->hasPermission('finance.view'))
      <div class="col-xl-3 col-md-6 col-sm-6">
        <div class="card border-0 h-100 shadow-sm text-white stat-card hover-scale" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important;" 
             data-bs-toggle="tooltip" data-bs-placement="bottom" title="Total pendapatan dari penjualan dikurangi retur hari ini.">
          <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="text-white-50 fw-semibold mb-0 fsmall">NET SALES</h6>
              <div class="bg-white bg-opacity-25 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                <i class="fas fa-wallet fa-sm"></i>
              </div>
            </div>
            <h4 class="fw-bold mb-1">Rp {{ number_format($netTodaySales ?? 0, 0, ',', '.') }}</h4>
            <div class="text-white-50 small fw-medium" style="font-size: 0.75rem;">
              <i class="fas fa-arrow-up me-1 text-white"></i> {{ $todayTransactionsCount ?? '0' }} Transaksi
            </div>
          </div>
        </div>
      </div>
      @endif

      {{-- Total Retur Hari Ini (Hanya Admin, Procurement, Finance) --}}
      @if(Auth::user()->hasPermission('finance.view'))
      <div class="col-xl-3 col-md-6 col-sm-6">
        <div class="card border-0 h-100 shadow-sm text-white stat-card hover-scale" style="background: linear-gradient(135deg, #dc3545 0%, #bb2d3b 100%) !important;"
             data-bs-toggle="tooltip" data-bs-placement="bottom" title="Nilai total barang yang dikembalikan oleh pelanggan hari ini.">
          <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="text-white-50 fw-semibold mb-0 fsmall">TOTAL RETUR</h6>
              <div class="bg-white bg-opacity-25 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                <i class="fas fa-undo-alt fa-sm"></i>
              </div>
            </div>
            <h4 class="fw-bold mb-1">Rp {{ number_format($todayReturns ?? 0, 0, ',', '.') }}</h4>
            <div class="text-white-50 small fw-medium" style="font-size: 0.75rem;">
              <i class="fas fa-minus-circle me-1 text-white"></i> Hari Ini
            </div>
          </div>
        </div>
      </div>
      @endif
      {{-- Efisiensi Produksi --}}
      <div class="col-xl-3 col-md-6 col-sm-6">
        <div class="card border-0 h-100 shadow-sm text-white stat-card hover-scale" style="background: linear-gradient(135deg, #198754 0%, #146c43 100%) !important;"
             data-bs-toggle="tooltip" data-bs-placement="bottom" title="Rasio perbandingan produk jadi yang dihasilkan vs target rencana produksi.">
          <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="text-white-50 fw-semibold mb-0 fsmall">EFISIENSI</h6>
              <div class="bg-white bg-opacity-25 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                <i class="fas fa-microchip fa-sm"></i>
              </div>
            </div>
            <h4 class="fw-bold mb-1">{{ number_format($productionYield ?? 100, 1) }}%</h4>
            <div class="text-white-50 small fw-medium" style="font-size: 0.75rem;">
                @php $yieldColor = $productionYield >= 90 ? 'text-white' : ($productionYield >= 70 ? 'text-warning' : 'text-danger'); @endphp
              <i class="fas fa-chart-line me-1 {{ $yieldColor }}"></i> Last 30 Days
            </div>
          </div>
        </div>
      </div>
      {{-- Total Valuasi atau Produk --}}
      <div class="col-xl-3 col-md-6 col-sm-6">
        @if(Auth::user()->hasPermission('reports.valuation'))
        <div class="card border-0 h-100 shadow-sm text-white hover-scale" style="background: linear-gradient(135deg, #6610f2 0%, #4b0bb8 100%) !important;">
          <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="text-white-50 fw-semibold mb-0 fsmall">INVENTARIS</h6>
              <div class="bg-white bg-opacity-25 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                <i class="fas fa-coins fa-sm"></i>
              </div>
            </div>
            <h4 class="fw-bold mb-1">Rp {{ number_format($totalValuation ?? 0, 0, ',', '.') }}</h4>
            <div class="text-white-50 small fw-medium" style="font-size: 0.75rem;">
              <i class="fas fa-box-open me-1 text-white"></i> Seluruh Gudang
            </div>
          </div>
        </div>
        @else
        <div class="card border-0 h-100 shadow-sm text-white" style="background: linear-gradient(135deg, #212529 0%, #000000 100%) !important;">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h6 class="text-white-50 fw-semibold mb-1 fsmall">TOTAL PRODUK AKTIF</h6>
                <h4 class="fw-bold mb-0">{{ $totalItems ?? '0' }}</h4>
              </div>
              <div class="bg-white bg-opacity-25 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="fas fa-boxes"></i>
              </div>
            </div>
            <div class="mt-2 text-white-50 small fw-medium">
              <i class="fas fa-tags me-1 text-white"></i> {{ $totalCategories ?? '0' }} Kategori Master
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>

    {{-- Grafik dan Chart --}}
    <div class="row g-3 mb-4">
      @if(Auth::user()->hasPermission('finance.view'))
      <div class="col-lg-7">
        <div class="card glass-card border-0 h-100 shadow-sm">
          <div class="card-header bg-transparent border-bottom-0 pb-0">
            <h6 class="mb-0 fw-bold"><i class="fas fa-chart-line me-2 text-primary"></i>Tren Penjualan 7 Hari Terakhir</h6>
          </div>
          <div class="card-body" style="height: 320px;">
            <canvas id="salesChart"></canvas>
          </div>
        </div>
      </div>
      @endif
      <div class="{{ Auth::user()->hasPermission('finance.view') ? 'col-lg-5' : 'col-lg-12' }}">
        <div class="card glass-card border-0 h-100 shadow-sm">
          <div class="card-header bg-transparent border-bottom-0 pb-0">
            <h6 class="mb-0 fw-bold"><i class="fas fa-chart-pie me-2 text-primary"></i>Distribusi Stok</h6>
          </div>
          <div class="card-body d-flex align-items-center justify-content-center p-2 mobile-stack">
            <div class="w-50">
              <canvas id="inventoryChart"></canvas>
            </div>
            <div class="w-50 ps-3">
              @if (!empty($categoryDistribution) && collect($categoryDistribution)->sum() > 0)
                <div class="d-grid gap-2">
                  @foreach ($categoryDistribution as $category => $percentage)
                    @php
                      $colorIndex = $loop->index % count($categoryColors ?? [1]);
                      $bgColor = isset($categoryColors) ? $categoryColors[$colorIndex] : '#6c757d';
                    @endphp
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center">
                        <span class="legend-dot" style="background-color: {{ $bgColor }};"></span>
                        <small class="text-truncate fw-medium" style="max-width: 80px;">{{ $category }}</small>
                      </div>
                      <small class="text-muted">{{ round($percentage, 1) }}%</small>
                    </div>
                  @endforeach
                </div>
              @else
                <small class="text-muted text-center d-block">Data belum tersedia.</small>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Tabel Informasi --}}
    <div class="row g-3">
      {{-- Stok Hampir Habis --}}
      <div class="col-lg-3">
        <div class="card glass-card border-0 h-100 shadow-sm overflow-hidden">
          <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Stok Hampir Habis</h6>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0">
                <tbody class="border-top-0">
                  @forelse ($lowStockItems as $item)
                    <tr>
                      <td class="ps-3 border-0">
                        <div class="d-flex align-items-center">
                          <div class="avatar-sm bg-soft-danger text-danger me-2 d-flex align-items-center justify-content-center rounded" style="width:36px; height:36px; font-size:12px; flex-shrink: 0;">
                            {{ substr($item->name, 0, 1) }}
                          </div>
                          <div class="overflow-hidden">
                            <div class="fw-bold fsmall text-dark text-truncate">{{ $item->name }}</div>
                            <small class="text-muted" style="font-size: 10px;">{{ $item->sku }} • {{ $item->category->name ?? '-' }}</small>
                          </div>
                        </div>
                      </td>
                      <td class="text-end pe-3 border-0">
                        <span class="badge bg-soft-danger text-danger rounded-pill">{{ $item->stock }} {{ $item->unit->name ?? 'pcs' }}</span>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td class="text-center text-muted p-4">Stok aman.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
          @if($lowStockItems->count() > 0)
            <div class="card-footer bg-white text-center py-2">
                <a href="{{ route('inventory.items.index') }}?stock=low" class="small text-decoration-none">Cek Semua Inventori</a>
            </div>
          @endif
        </div>
      </div>

      {{-- Transaksi Terakhir --}}
      <div class="col-lg-4">
        <div class="card glass-card border-0 h-100 shadow-sm overflow-hidden">
          <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-history me-2"></i>Transaksi Terakhir</h6>
            <a href="{{ route('penjualan.transaksi.index') }}" class="btn btn-sm btn-link p-0 text-decoration-none small">Lihat Semua</a>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0">
                <tbody class="border-top-0">
                  @forelse ($recentTransactions as $transaction)
                    <tr>
                      <td class="ps-3 border-0">
                        <div class="d-flex align-items-center">
                          <div class="avatar-sm bg-soft-primary text-primary me-2 d-flex align-items-center justify-content-center rounded" style="width:40px; height:40px; flex-shrink: 0;">
                            <i class="fas fa-file-invoice small"></i>
                          </div>
                          <div class="overflow-hidden">
                            <div class="fw-bold fsmall text-dark">{{ $transaction->invoice_number }}</div>
                            <small class="text-muted" style="font-size: 10px;">{{ $transaction->customer_name }} • {{ $transaction->sale_date->diffForHumans() }}</small>
                          </div>
                        </div>
                      </td>
                      <td class="text-end pe-3 border-0">
                        <div class="fw-bold text-dark fsmall">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</div>
                        <span class="badge @if($transaction->payment_status == 'paid') bg-soft-success text-success @elseif($transaction->payment_status == 'partial') bg-soft-warning text-warning @else bg-soft-danger text-danger @endif rounded-pill" style="font-size: 10px;">
                            {{ ucfirst($transaction->payment_status) }}
                        </span>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td class="text-center text-muted p-4">Belum ada transaksi.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      {{-- Konsumsi Bahan Baku --}}
      <div class="col-lg-2">
        <div class="card glass-card border-0 h-100 shadow-sm overflow-hidden">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-success"><i class="fas fa-seedling me-2"></i>Top Use</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($topConsumption as $cons)
                        <div class="list-group-item border-0 px-3 py-1 d-flex align-items-center">
                            <div class="avatar-xs text-white bg-success rounded-circle me-1 d-flex align-items-center justify-content-center" style="width:18px; height:18px; font-size:9px; flex-shrink:0;">
                                {{ $loop->iteration }}
                            </div>
                            <div class="text-truncate">
                                <div class="fw-bold text-dark text-truncate" style="font-size: 11px;">{{ $cons->item->name }}</div>
                                <small class="text-muted" style="font-size: 9px;">{{ number_format($cons->total_used, 0, ',', '.') }} {{ $cons->item->unit->short_name ?? 'unit' }}</small>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted italic small">Data belum tersedia.</div>
                    @endforelse
                </div>
            </div>
        </div>
      </div>

      {{-- Slow Moving Items --}}
      <div class="col-lg-3">
        <div class="card glass-card border-0 h-100 shadow-sm overflow-hidden">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-warning"><i class="fas fa-hourglass-half me-2"></i>Slow Moving</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($slowMovingItems as $slow)
                        <div class="list-group-item border-0 px-3 py-1 d-flex align-items-center">
                            <div class="avatar-xs text-white bg-warning rounded-circle me-1 d-flex align-items-center justify-content-center" style="width:18px; height:18px; font-size:9px; flex-shrink:0;">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="text-truncate">
                                <div class="fw-bold text-dark text-truncate" style="font-size: 11px;">{{ $slow->name }}</div>
                                <small class="text-muted" style="font-size: 9px;">Stok: {{ number_format($slow->stock, 0, ',', '.') }} {{ $slow->unit->short_name ?? '' }}</small>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted italic small">Tidak ada item slow moving.</div>
                    @endforelse
                </div>
            </div>
        </div>
      </div>

    </div>

    {{-- Baris Keempat: Aktivitas Terbaru (Hanya Admin, Procurement, Finance) --}}
    @if(Auth::user()->hasPermission('settings.logs'))
    <div class="row g-3 mt-1 mb-4">
        <div class="col-12">
            <div class="card glass-card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-secondary"><i class="fas fa-user-clock me-2"></i>Aktivitas Terbaru Sistem</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 table-responsive-stack" style="font-size: 0.8rem;">
                            <thead class="bg-light thead-dark">
                                <tr>
                                    <th class="ps-3 border-0">WAKTU</th>
                                    <th class="border-0">USER</th>
                                    <th class="border-0">AKTIVITAS</th>
                                    <th class="border-0 text-end pe-3">KETERANGAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentActivity as $log)
                                    <tr>
                                        <td data-label="WAKTU" class="ps-3 border-0 text-muted">{{ $log->created_at->format('H:i:s') }}</td>
                                        <td data-label="USER" class="border-0 fw-bold text-primary">{{ $log->user->name ?? 'System' }}</td>
                                        <td data-label="AKTIVITAS" class="border-0"><span class="badge bg-soft-primary text-primary px-2">{{ $log->activity }}</span></td>
                                        <td data-label="KETERANGAN" class="border-0 text-muted text-end pe-3">{{ $log->description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
  </div>

@endsection

@push('styles')
  <style>
    .stat-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
    }

    .avatar-sm-table {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-right: 1rem;
    }

    .legend-dot {
    display: inline-block;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-right: 8px;
    flex-shrink: 0;
    }

    .text-gradient {
    background: linear-gradient(135deg, var(--bs-primary), var(--bs-secondary));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    }
  </style>
@endpush

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
    const salesData = {!! json_encode($salesData ?? []) !!};
    const salesLabels = {!! json_encode($salesLabels ?? []) !!};
    const categoryDistributionLabels = {!! json_encode(isset($categoryDistribution) ? array_keys($categoryDistribution->toArray()) : []) !!};
    const categoryDistributionData = {!! json_encode(isset($categoryDistribution) ? array_values($categoryDistribution->toArray()) : []) !!};
    const categoryColors = {!! json_encode($categoryColors ?? []) !!};

    Chart.defaults.font.family = "'Poppins', sans-serif";
    Chart.defaults.plugins.legend.display = false;

    const salesCtx = document.getElementById('salesChart');
    if (salesCtx) {
      new Chart(salesCtx, {
      type: 'bar',
      data: {
        labels: salesLabels,
        datasets: [{
        label: 'Penjualan Bersih',
        data: salesData,
        backgroundColor: 'rgba(52, 152, 219, 0.7)',
        borderColor: 'rgba(52, 152, 219, 1)',
        borderWidth: 2,
        borderRadius: 4,
        barThickness: 20,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { tooltip: { callbacks: { label: (context) => 'Rp ' + Number(context.raw).toLocaleString('id-ID') } } },
        scales: {
        y: {
          beginAtZero: true,
          ticks: {
          callback: (value) => {
            if (value >= 1000000) return 'Rp ' + (value / 1000000) + ' Jt';
            if (value >= 1000) return 'Rp ' + (value / 1000) + ' Rb';
            return 'Rp ' + value;
          }
          }
        },
        x: { grid: { display: false } }
        }
      }
      });
    }

    const inventoryCtx = document.getElementById('inventoryChart');
    if (inventoryCtx && categoryDistributionData.length > 0) {
      new Chart(inventoryCtx, {
      type: 'doughnut',
      data: {
        labels: categoryDistributionLabels,
        datasets: [{
        data: categoryDistributionData,
        backgroundColor: categoryColors,
        borderColor: '#fff',
        borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: { tooltip: { callbacks: { label: (context) => context.label + ': ' + Number(context.raw).toFixed(1) + '%' } } }
      }
    }); // Fix here
    }

    // Initialize Tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    });
  </script>
@endpush