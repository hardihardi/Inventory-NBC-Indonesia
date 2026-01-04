@extends('layouts.app')

@section('title', 'Kartu Stok: ' . $item->name)

@section('content')
<div class="container-fluid">
    <div class="row align-items-center mb-4">
        <div class="col-md-auto">
            <a href="{{ route('inventory.stock_ledger.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="col mt-2 mt-md-0">
            <h4 class="fw-bold text-primary mb-0"><i class="fas fa-id-card me-2"></i>Kartu Stok</h4>
            <span class="text-muted">{{ $item->name }} ({{ $item->sku }})</span>
        </div>
        <div class="col-md-auto text-md-end mt-2 mt-md-0">
            <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}" class="btn btn-danger btn-sm shadow-sm">
                <i class="fas fa-file-pdf me-1"></i> Unduh PDF
            </a>
            <button onclick="window.print()" class="btn btn-dark btn-sm shadow-sm ms-1">
                <i class="fas fa-print me-1"></i> Cetak Halaman
            </button>
        </div>
    </div>

    {{-- Info Card --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 border-start border-primary border-4 h-100">
                <div class="card-body">
                    <h6 class="text-muted small text-uppercase fw-bold mb-3">Informasi Produk</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Kategori:</span>
                        <span class="fw-bold">{{ $item->category->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Warna:</span>
                        @if($item->color)
                            <span class="fw-bold"><div class="rounded-circle d-inline-block border shadow-sm me-1" style="width: 10px; height: 10px; background-color: {{ $item->color->hex_code }};"></div>{{ $item->color->name }}</span>
                        @else
                            <span class="text-muted small">N/A</span>
                        @endif
                    </div>
                    @if($item->composition || $item->gsm || $item->width)
                    <div class="mt-3 p-2 bg-light rounded border border-dashed">
                         <h6 class="text-muted x-small text-uppercase fw-bold mb-2" style="font-size: 0.65rem;">Spesifikasi Teknis</h6>
                         @if($item->composition)<div class="small mb-1"><strong>Comp:</strong> {{ $item->composition }}</div>@endif
                         @if($item->gsm)<div class="small mb-1"><strong>GSM:</strong> {{ $item->gsm }}</div>@endif
                         @if($item->width)<div class="small mb-0"><strong>Width:</strong> {{ $item->width }}"</div>@endif
                    </div>
                    @endif
                    <div class="d-flex justify-content-between mt-3">
                        <span>Stok Saat Ini:</span>
                        <span class="badge bg-primary fs-6">{{ number_format($item->stock, 0, ',', '.') }} {{ $item->unit->name }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 mt-3 mt-md-0">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="text-muted small text-uppercase fw-bold mb-3">Filter Periode & Gudang</h6>
                    <form action="{{ route('inventory.stock_ledger.item_card', $item->id) }}" method="GET" class="row g-2">
                        <div class="col-md-4">
                            <label class="small text-muted mb-1">Pilih Gudang</label>
                            <select name="warehouse_id" class="form-select select2">
                                <option value="">Semua Gudang</option>
                                @foreach($warehouses as $w)
                                    <option value="{{ $w->id }}" {{ request('warehouse_id') == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="small text-muted mb-1">Dari Tanggal</label>
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="small text-muted mb-1">Sampai Tanggal</label>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Movement Table --}}
    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-responsive-stack">
                    <thead class="thead-dark bg-light">
                        <tr>
                            <th width="15%">Tanggal & Waktu</th>
                            <th>Ref / Tipe</th>
                            <th>Gudang</th>
                            <th class="text-center" width="10%">Masuk</th>
                            <th class="text-center" width="10%">Keluar</th>
                            <th class="text-center bg-light" width="15%">Saldo Akhir</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(request('start_date'))
                        <tr class="table-warning border-start border-warning border-4">
                            <td colspan="3" class="text-end fw-bold py-3"><i class="fas fa-history me-1"></i> SALDO AWAL ({{ date('d/m/Y', strtotime(request('start_date'))) }}):</td>
                            <td colspan="2" class="text-center">---</td>
                            <td class="text-center fw-bold bg-warning bg-opacity-10">{{ number_format($openingBalance, 0, ',', '.') }}</td>
                            <td><small class="text-muted italic">Stok level sebelum periode terpilih</small></td>
                        </tr>
                        @endif
                        @forelse($ledgers as $ledger)
                        <tr>
                            <td data-label="Tanggal & Waktu">
                                <span class="fw-semibold">{{ $ledger->created_at->format('d/m/Y H:i') }}</span>
                            </td>
                             <td data-label="Ref / Tipe">
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
                                <small class="text-muted">#{{ $ledger->reference_id ?: '-' }}</small>
                            </td>
                            <td data-label="Gudang" class="text-muted small">
                                {{ $ledger->warehouse->name }}
                            </td>
                            <td data-label="Masuk" class="text-center text-success fw-bold">
                                {{ $ledger->type == 'in' ? number_format($ledger->qty_change, 0, ',', '.') : '-' }}
                            </td>
                            <td data-label="Keluar" class="text-center text-danger fw-bold">
                                {{ $ledger->type == 'out' ? number_format($ledger->qty_change, 0, ',', '.') : '-' }}
                            </td>
                            <td data-label="Saldo Akhir" class="text-center fw-bold bg-light">
                                {{ number_format($ledger->qty_after, 0, ',', '.') }}
                            </td>
                            <td data-label="Keterangan">
                                <small>{{ $ledger->notes ?: 'Tanpa catatan' }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted text-uppercase small ls-1">
                                Belum ada riwayat pergerakan stok untuk produk ini.
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
    @media print {
        .btn, .sidebar, .navbar, form { display: none !important; }
        .card { border: none !important; box-shadow: none !important; }
        .container-fluid { width: 100% !important; padding: 0 !important; }
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
    }
</style>
@endpush
