@extends('layouts.app')

@section('title', 'Ringkasan Laporan Stok')

@section('content')
<div class="container-fluid py-2">
    <div class="row g-3 mb-4 align-items-center">
        <div class="col-md-6 text-center text-md-start">
            <h4 class="fw-bold mb-1"><i class="fas fa-file-invoice me-2 text-primary"></i>Ringkasan Stok</h4>
            <p class="text-muted small mb-0">Saldo awal, mutasi masuk/keluar, dan saldo akhir per periode.</p>
        </div>
        <div class="col-md-6 text-center text-md-end">
            <div class="btn-group shadow-sm w-100-mobile">
                <a href="{{ route('inventory.stock_ledger.index') }}" class="btn btn-outline-primary btn-sm px-3">
                    <i class="fas fa-history me-1"></i> Jurnal Detail
                </a>
                <button type="button" class="btn btn-danger btn-sm px-3 shadow-sm border-0 dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-download me-1"></i> Export
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li><a class="dropdown-item" href="{{ route('inventory.stock_ledger.export_summary', request()->query() + ['format' => 'pdf']) }}"><i class="far fa-file-pdf me-2 text-danger"></i>Cetak PDF</a></li>
                    <li><a class="dropdown-item" href="{{ route('inventory.stock_ledger.export_summary', request()->query() + ['format' => 'excel']) }}"><i class="far fa-file-excel me-2 text-success"></i>Export Excel</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('inventory.stock_ledger.summary') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-6 col-md-2">
                    <label class="form-label small fw-bold text-muted">Dari</label>
                    <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $startDate }}">
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label small fw-bold text-muted">Sampai</label>
                    <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $endDate }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Kategori</label>
                    <select name="category_id" class="form-select form-select-sm select2">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Gudang</label>
                    <select name="warehouse_id" class="form-select form-select-sm select2">
                        <option value="">Semua Gudang</option>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}" {{ $warehouseId == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100 rounded-2 py-2">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4" width="5%">No</th>
                            <th>Produk & SKU</th>
                            <th>Kategori</th>
                            <th class="text-center" width="12%">Saldo Awal</th>
                            <th class="text-center text-success" width="10%">Masuk (+)</th>
                            <th class="text-center text-danger" width="10%">Keluar (-)</th>
                            <th class="text-center pe-4" width="12%">Saldo Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $index => $item)
                        <tr>
                            <td class="ps-4 text-muted" data-label="No">{{ $index + 1 }}</td>
                            <td data-label="Produk & SKU">
                                <div class="fw-bold text-dark">{{ $item->name }}</div>
                                <code class="text-muted small">{{ $item->sku }}</code>
                            </td>
                            <td data-label="Kategori">
                                <span class="badge bg-soft-primary text-primary px-3 rounded-pill">{{ $item->category->name ?? 'N/A' }}</span>
                            </td>
                            <td class="text-center fw-semibold text-secondary" data-label="Saldo Awal">
                                {{ number_format($item->opening_qty, 0, ',', '.') }}
                                <small class="text-muted d-md-block" style="font-size: 0.7rem;">{{ $item->unit->short_name ?? '' }}</small>
                            </td>
                            <td class="text-center" data-label="Masuk (+)">
                                <span class="badge bg-soft-success text-success px-2">+{{ number_format($item->qty_in, 0, ',', '.') }}</span>
                            </td>
                            <td class="text-center" data-label="Keluar (-)">
                                <span class="badge bg-soft-danger text-danger px-2">-{{ number_format($item->qty_out, 0, ',', '.') }}</span>
                            </td>
                            <td class="text-center pe-4 fw-bold text-dark" data-label="Saldo Akhir">
                                {{ number_format($item->closing_qty, 0, ',', '.') }}
                                <small class="text-muted d-md-block" style="font-size: 0.7rem;">{{ $item->unit->short_name ?? '' }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-box-open fa-3x mb-3 opacity-25"></i>
                                <p class="text-muted">Tidak ada data pergerakan stok untuk kriteria ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .select2-container--bootstrap-5 .select2-selection {
        border-radius: 0.5rem;
    }

    /* Professional Responsive Table */
    @media (max-width: 768px) {
        .table-responsive {
            border: 0;
        }
        
        thead {
            display: none;
        }
        
        tr {
            display: block;
            margin-bottom: 1.5rem;
            background: #fff;
            border-radius: 1rem;
            padding: 1.25rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        td {
            display: flex;
            justify-content: b;
            align-items: center;
            padding: 0.5rem 0 !important;
            border: 0 !important;
            width: 100% !important;
            border-bottom: 1px dashed rgba(0,0,0,0.05) !important;
        }

        td:last-child {
            border-bottom: 0 !important;
        }

        td::before {
            content: attr(data-label);
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #6c757d;
            flex: 1;
        }

        td > div, td > span, td > code {
             flex: 1;
             text-align: right;
        }

        /* Adjusting specific elements */
        td[data-label="No"] { display: none; }
        
        td[data-label="Produk & SKU"] {
            display: block;
            text-align: left;
            border-bottom: 1px solid rgba(0,0,0,0.1) !important;
            margin-bottom: 0.5rem;
            padding-bottom: 0.75rem !important;
        }
        td[data-label="Produk & SKU"]::before {
            display: block;
            margin-bottom: 0.25rem;
        }
        td[data-label="Produk & SKU"] > div,
        td[data-label="Produk & SKU"] > code {
            text-align: left;
            display: block;
        }

        .dropdown-menu-end {
            right: 0;
            left: auto;
        }

        .w-100-mobile {
            width: 100% !important;
        }
    }

    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.08); color: #0d6efd; }
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.08); color: #198754; }
    .bg-soft-danger { background-color: rgba(220, 53, 69, 0.08); color: #dc3545; }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });
    });
</script>
@endpush
