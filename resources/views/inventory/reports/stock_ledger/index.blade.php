@extends('layouts.app')

@section('title', 'Laporan Stok (Stock Ledger)')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-primary mb-0"><i class="fas fa-history me-2"></i>Laporan Stok</h4>
            <p class="text-muted mb-0">Laporan kronologis seluruh pergerakan stok unit di sistem.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('inventory.stock_ledger.summary') }}" class="btn btn-outline-primary btn-sm shadow-sm px-3">
                <i class="fas fa-file-invoice me-1"></i> Ringkasan Stok
            </a>
            <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="btn btn-danger btn-sm shadow-sm px-3">
                <i class="fas fa-file-pdf me-1"></i> Cetak PDF
            </a>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-white" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important; box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3) !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="small text-white-50 mb-1 fw-bold text-uppercase">Total Masuk ({{ request('start_date') || request('end_date') ? 'Periode Filter' : 'Bulan Ini' }})</p>
                            <h3 class="mb-0 fw-bold">{{ number_format($stats['total_in'], 0, ',', '.') }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-2">
                            <i class="fas fa-arrow-down fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-white" style="background: linear-gradient(135deg, #dc3545 0%, #bb2d3b 100%) !important; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3) !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="small text-white-50 mb-1 fw-bold text-uppercase">Total Keluar ({{ request('start_date') || request('end_date') ? 'Periode Filter' : 'Bulan Ini' }})</p>
                            <h3 class="mb-0 fw-bold">{{ number_format($stats['total_out'], 0, ',', '.') }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-2">
                            <i class="fas fa-arrow-up fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-white" style="background: linear-gradient(135deg, #212529 0%, #000000 100%) !important; box-shadow: 0 4px 15px rgba(33, 37, 41, 0.3) !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="small text-white-50 mb-1 fw-bold text-uppercase">Net Pergerakan</p>
                            <h3 class="mb-0 fw-bold">{{ number_format($stats['net'], 0, ',', '.') }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-2">
                            <i class="fas fa-exchange-alt fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('inventory.stock_ledger.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Pencarian Produk</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama / SKU..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Gudang</label>
                    <select name="warehouse_id" class="form-select">
                        <option value="">Semua Gudang</option>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}" {{ request('warehouse_id') == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Kategori</label>
                    <select name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Tipe</label>
                    <select name="type" class="form-select">
                        <option value="">Semua Tipe</option>
                        <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Stok Masuk (IN)</option>
                        <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Stok Keluar (OUT)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i></button>
                </div>
            </form>
        </div>
    </div>

    {{-- Ledger Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-responsive-stack">
                    <thead class="thead-dark bg-light">
                        <tr>
                            <th width="12%">Waktu</th>
                            <th>Produk</th>
                            <th>Gudang</th>
                            <th class="text-center">Perubahan</th>
                            <th class="text-center">Stok Akhir</th>
                            <th>Ref / Catatan</th>
                            <th>Admin</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ledgers as $ledger)
                        <tr>
                            <td data-label="Waktu">
                                <span class="fw-semibold">{{ $ledger->created_at->format('d/m/Y') }}</span><br>
                                <small class="text-muted">{{ $ledger->created_at->format('H:i') }} WIB</small>
                            </td>
                            <td data-label="Produk">
                                <div class="d-flex align-items-center">
                                    @if($ledger->item)
                                        @if($ledger->item->color)
                                            <div class="rounded-circle me-2 border shadow-sm" style="width: 12px; height: 12px; background-color: {{ $ledger->item->color->hex_code }};" title="{{ $ledger->item->color->name }}"></div>
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $ledger->item->name }}</div>
                                            <div class="text-muted small">
                                                <span>{{ $ledger->item->sku }}</span>
                                                @if($ledger->item->composition)
                                                    <span class="mx-1">|</span><span>{{ $ledger->item->composition }}</span>
                                                @endif
                                                @if($ledger->item->gsm)
                                                    <span class="mx-1">|</span><span>{{ $ledger->item->gsm }} GSM</span>
                                                @endif
                                                @if($ledger->item->width)
                                                    <span class="mx-1">|</span><span>L:{{ $ledger->item->width }}"</span>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted italic">Produk telah dihapus</span>
                                    @endif
                                </div>
                            </td>
                            <td data-label="Gudang">
                                <span class="badge bg-light text-dark border">{{ $ledger->warehouse->name }}</span>
                            </td>
                            <td data-label="Perubahan" class="text-center">
                                <span class="fw-bold {{ $ledger->type == 'in' ? 'text-success' : 'text-danger' }}">
                                    {{ $ledger->type == 'in' ? '+' : '-' }}{{ number_format($ledger->qty_change, 0, ',', '.') }}
                                </span>
                            </td>
                            <td data-label="Stok Akhir" class="text-center fw-bold">
                                {{ number_format($ledger->qty_after, 0, ',', '.') }}
                            </td>
                            <td data-label="Ref / Catatan">
                                <div class="text-truncate" style="max-width: 200px;" title="{{ $ledger->notes }}">
                                    <span class="badge bg-secondary mb-1">
                                        @php
                                            $labels = [
                                                'App\Models\StockAdjustment' => 'Penyesuaian',
                                                'App\Models\StockTransfer' => 'Transfer',
                                                'App\Models\Production' => 'Produksi',
                                                'App\Models\Sale' => 'Penjualan',
                                                'App\Models\Purchase' => 'Pembelian',
                                            ];
                                            echo $labels[$ledger->reference_type] ?? $ledger->reference_type;
                                        @endphp
                                    </span><br>
                                    <small>{{ $ledger->notes ?: '-' }}</small>
                                </div>
                            </td>
                            <td data-label="Admin">
                                <small>{{ $ledger->user->name }}</small>
                            </td>
                            <td data-label="Aksi" class="text-center">
                                <a href="{{ route('inventory.stock_ledger.item_card', $ledger->item_id) }}" class="btn btn-sm btn-outline-info" title="Lihat Kartu Stok Produk">
                                    <i class="fas fa-id-card"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-3x mb-3"></i>
                                <p>Tidak ada data pergerakan stok ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($ledgers->hasPages())
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-end">
                {{ $ledgers->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .stats-card-in {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important;
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3) !important;
    }
    .stats-card-out {
        background: linear-gradient(135deg, #dc3545 0%, #bb2d3b 100%) !important;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3) !important;
    }
    .stats-card-net {
        background: linear-gradient(135deg, #212529 0%, #000000 100%) !important;
        box-shadow: 0 4px 15px rgba(33, 37, 41, 0.3) !important;
    }

    @media screen and (max-width: 768px) {
        .table-responsive-stack thead {
            display: none;
        }

        .table-responsive-stack tr {
            display: block;
            border: 1px solid #eee;
            margin-bottom: 1rem;
            background: #fff;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .table-responsive-stack td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: right;
            border-bottom: 1px solid #f8f9fa;
            padding: 8px 5px !important;
        }

        .table-responsive-stack td:last-child {
            border-bottom: none;
        }

        .table-responsive-stack td:before {
            content: attr(data-label);
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.7rem;
            color: #6c757d;
            text-align: left;
            flex: 1;
        }
        
        .table-responsive-stack td > div, 
        .table-responsive-stack td > span, 
        .table-responsive-stack td > small {
            flex: 2;
        }
    }
</style>
@endpush
