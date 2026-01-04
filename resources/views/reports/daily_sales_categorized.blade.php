@extends('layouts.app')

@section('title', 'Laporan Penjualan Harian')

@section('content')
  <div class="container-fluid">
    {{-- Header Halaman dengan Filter --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <h4 class="mb-0 fw-bold text-gradient">
      <i class="fas fa-chart-line me-2"></i>Laporan Penjualan Harian
    </h4>
    <form action="{{ route('reports.daily_sales') }}" method="GET" class="d-flex align-items-center gap-2">
      <input type="date" class="form-control form-control-sm w-auto" id="date" name="date"
      value="{{ $filterDate ?? today()->toDateString() }}">
      <button type="submit" class="btn btn-sm btn-primary">
      <i class="fas fa-search me-1"></i> Tampilkan
      </button>
      @if(Auth::user()->hasPermission('reports.print'))
      <a href="{{ route('reports.print_daily_sales', ['date' => $filterDate ?? today()->toDateString()]) }}"
      target="_blank" class="btn btn-sm btn-success">
      <i class="fas fa-print me-1"></i> Cetak
      </a>
      @endif
    </form>
    </div>
    <div class="row g-3 mb-4">
    {{-- Penjualan Bersih Textile --}}
    <div class="col-xl-3 col-md-6">
      <div class="card stat-card h-100 border-start border-primary border-4">
      <div class="card-body d-flex flex-column">
        <div>
        <h6 class="text-muted mb-0">Penjualan Bersih</h6>
        <p class="mb-2 fw-semibold">Benang & Kain</p>
        </div>
        <div class="mt-auto d-flex align-items-end justify-content-between">
        <h6 class="fw-bolder mb-0">Rp {{ number_format($netSalesTextile ?? 0, 0, ',', '.') }}</h6>
        </div>
      </div>
      </div>
    </div>
    {{-- Penjualan Bersih Penunjang --}}
    <div class="col-xl-3 col-md-6">
      <div class="card stat-card h-100 border-start border-warning border-4">
      <div class="card-body d-flex flex-column">
        <div>
        <h6 class="text-muted mb-0">Penjualan Bersih</h6>
        <p class="mb-2 fw-semibold">Kimia & Penunjang</p>
        </div>
        <div class="mt-auto d-flex align-items-end justify-content-between">
        <h6 class="fw-bolder mb-0">Rp {{ number_format($netSalesPenunjang ?? 0, 0, ',', '.') }}</h6>
        </div>
      </div>
      </div>
    </div>
    {{-- KARTU BARU: Total Retur --}}
    <div class="col-xl-3 col-md-6">
      <div class="card stat-card h-100 border-start border-danger border-4">
      <div class="card-body d-flex flex-column">
        <div>
        <h6 class="text-muted mb-0">Total Retur</h6>
        <p class="mb-2 fw-semibold">Hari Ini</p>
        </div>
        <div class="mt-auto d-flex align-items-end justify-content-between">
        <h6 class="fw-bolder mb-0">Rp {{ number_format($totalDailyReturns ?? 0, 0, ',', '.') }}</h6>
        </div>
      </div>
      </div>
    </div>
    {{-- Total Penjualan Bersih Keseluruhan --}}
    <div class="col-xl-3 col-md-6">
      <div class="card stat-card h-100 border-start border-success border-4">
      <div class="card-body d-flex flex-column">
        <div>
        <h6 class="text-muted mb-0">Total Penjualan</h6>
        <p class="mb-2 fw-semibold">Bersih</p>
        </div>
        <div class="mt-auto d-flex align-items-end justify-content-between">
        <h6 class="fw-bolder mb-0">Rp {{ number_format($totalNetDailySales ?? 0, 0, ',', '.') }}</h6>
        </div>
      </div>
      </div>
    </div>
    </div>

    {{-- Detail Transaksi --}}
    <div class="card shadow-sm border-0">
    <div class="card-header bg-white p-3">
      <div class="d-flex justify-content-between align-items-center">
      <h6 class="mb-0 fw-bold">
        <i class="fas fa-list-ul me-2"></i>Detail Transaksi Penjualan untuk
        {{ \Carbon\Carbon::parse($filterDate ?? today())->isoFormat('DD MMMM YYYY') }}
      </h6>
      <div class="input-group input-group-sm" style="max-width: 250px;">
        <span class="input-group-text bg-light border-end-0">
        <i class="fas fa-search text-muted"></i>
        </span>
        <input type="text" id="custom-search-input" class="form-control border-start-0" placeholder="Cari invoice...">
      </div>
      </div>
    </div>
    <div class="card-body p-0">
    {{-- Card Grid for Daily Sales --}}
    <div id="daily-sales-grid">
      @if ($salesToday && $salesToday->count() > 0)
        <div class="row g-4 mb-4">
          @foreach ($salesToday as $sale)
            <div class="col-xl-6 col-xxl-4 sale-card-container">
              <div class="card h-100 shadow-sm border-0 sale-card overflow-hidden">
                {{-- Card Header: Metadata --}}
                <div class="card-header bg-white py-3 px-4 border-bottom-0">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                      <h5 class="fw-bold mb-0 text-primary">#{{ $sale->invoice_number }}</h5>
                      <span class="text-muted small">
                        <i class="far fa-clock me-1"></i> {{ $sale->sale_date->format('H:i') }} | 
                        <i class="far fa-user me-1"></i> {{ $sale->user->name }}
                      </span>
                    </div>
                    <span class="badge {{ $sale->payment_status === 'paid' ? 'bg-success' : ($sale->payment_status === 'partial' ? 'bg-warning' : 'bg-danger') }} rounded-pill">
                      {{ strtoupper($sale->payment_status) }}
                    </span>
                  </div>
                  <div class="d-flex align-items-center">
                    <div class="avatar-xs me-2">
                      {{ substr($sale->customer_name ?? 'U', 0, 1) }}
                    </div>
                    <span class="fw-semibold text-secondary">{{ $sale->customer_name ?? 'Pelanggan Umum' }}</span>
                  </div>
                </div>

                {{-- Card Body: Item List --}}
                <div class="card-body px-4 py-0">
                  <div class="text-xs text-uppercase fw-bold text-muted mb-2 tracking-wider mt-3">Rincian Produk</div>
                  <div class="sales-items-list">
                    @foreach ($sale->items as $item)
                      <div class="sale-item-row mb-3 pb-3 border-bottom last-border-0">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                          <h6 class="fw-bold mb-0 text-dark">{{ $item->item->name }}</h6>
                          <span class="fw-bold text-primary">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        {{-- Technical Specs Badges --}}
                        <div class="d-flex flex-wrap gap-1 mb-2">
                          @if($item->item->brand)
                            <span class="badge bg-light text-dark border"><i class="fas fa-tag me-1 text-muted"></i>{{ $item->item->brand }}</span>
                          @endif
                          @if($item->item->composition)
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle small-badge">{{ $item->item->composition }}</span>
                          @endif
                          @if($item->item->technical_spec)
                            <span class="badge bg-info-subtle text-info border border-info-subtle small-badge">{{ $item->item->technical_spec }}</span>
                          @endif
                          @if($item->item->gsm)
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle small-badge">GSM: {{ $item->item->gsm }}</span>
                          @endif
                          @if($item->item->width)
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle small-badge">Lebar: {{ $item->item->width }}</span>
                          @endif
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center small text-muted">
                          <span>{{ number_format($item->quantity, 0, ',', '.') }} {{ $item->item->unit->short_name ?? 'Unit' }} x Rp {{ number_format($item->unit_price, 0, ',', '.') }}</span>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>

                {{-- Card Footer: Totals & Action --}}
                <div class="card-footer bg-light px-4 py-3 border-top-0 mt-auto">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="text-muted small">Total Transaksi</span>
                    <h5 class="fw-bolder mb-0 text-dark">Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</h5>
                  </div>
                  @if($sale->discount_amount > 0)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="text-muted small">Diskon</span>
                      <span class="text-danger small fw-bold">- Rp {{ number_format($sale->discount_amount, 0, ',', '.') }}</span>
                    </div>
                  @endif
                  <div class="d-grid mt-3">
                    <a href="{{ route('penjualan.transaksi.show', $sale) }}" class="btn btn-outline-primary btn-sm rounded-pill fw-bold">
                      <i class="fas fa-eye me-2"></i> LIHAT DETAIL TRANSAKSI
                    </a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="card shadow-sm border-0 text-center py-5">
          <div class="card-body">
            <i class="fas fa-folder-open fa-3x mb-3 text-muted opacity-25"></i>
            <h5 class="text-muted">Tidak ada transaksi pada tanggal ini.</h5>
            <p class="text-muted small">Silakan pilih tanggal lain melalui filter di atas.</p>
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
    .text-gradient {
    background: linear-gradient(135deg, var(--bs-primary), var(--bs-secondary));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    }

    .stat-card {
      transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
      border: none;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
    }

    .sale-card {
      transition: all 0.3s cubic-bezier(.25,.8,.25,1);
      border-radius: 12px;
    }

    .sale-card:hover {
      box-shadow: 0 14px 28px rgba(0,0,0,0.1), 0 10px 10px rgba(0,0,0,0.08) !important;
      transform: translateY(-2px);
    }

    .avatar-xs {
      width: 24px;
      height: 24px;
      border-radius: 50%;
      background: var(--bs-primary-bg-subtle);
      color: var(--bs-primary-text-emphasis);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 10px;
      font-weight: 700;
    }

    .small-badge {
      font-size: 0.65rem;
      padding: 0.25em 0.5em;
      font-weight: 500;
    }

    .tracking-wider {
      letter-spacing: 0.1em;
    }

    .last-border-0:last-child {
      border-bottom: 0 !important;
    }

    .text-xs {
      font-size: 0.7rem;
    }

    @media (max-width: 576px) {
      .sale-card-container {
        padding-left: 10px;
        padding-right: 10px;
      }
    }
  </style>
@endpush

@push('scripts')
  <script>
    $(document).ready(function () {
      $('#custom-search-input').on('keyup', function () {
        var value = $(this).val().toLowerCase();
        $('.sale-card-container').filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });

      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });
  </script>
@endpush