@extends('layouts.app')

@section('title', 'Cek Stok Material - PPIC')

@section('content')
<div class="container-fluid">
    {{-- Header Section --}}
    <div class="row align-items-center mb-4">
        <div class="col-md-7">
            <h4 class="mb-0 fw-bold text-dark">
                <i class="fas fa-boxes me-2 text-primary"></i>Ketersediaan Stok Material
            </h4>
            <p class="text-muted small mb-0">Informasi stok real-time untuk perencanaan produksi yang akurat</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0 d-flex gap-2 justify-content-md-end">
            <a href="{{ route('inventory.production.index') }}" class="btn btn-light border shadow-sm px-3">
                <i class="fas fa-list-ul me-2 text-secondary"></i>Daftar Request
            </a>
            @if(Auth::user()->hasPermission('production.create'))
            <a href="{{ route('inventory.production.create') }}" class="btn btn-primary shadow-sm px-4">
                <i class="fas fa-plus-circle me-2"></i>Buat Request Baru
            </a>
            @endif
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="card shadow-sm border-0 mb-4 rounded-3 overflow-hidden">
        <div class="card-header bg-white py-3 border-0">
            <h6 class="mb-0 fw-bold small text-uppercase text-muted"><i class="fas fa-filter me-2 text-primary"></i>Filter Pencarian</h6>
        </div>
        <div class="card-body p-4 pt-0">
            <form action="{{ route('inventory.production.stock_check') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label small fw-bold">Pencarian Cepat</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted opacity-50"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" 
                            placeholder="Nama material, komposisi, atau SKU..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Kategori Material</label>
                    <select name="category_id" class="form-select border-0 bg-light">
                        <option value="">Semua Material</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('inventory.production.stock_check') }}" class="btn btn-light border px-3" title="Reset">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Stock Table --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3" width="5%">No</th>
                            <th class="py-3">Informasi Material</th>
                            <th class="py-3">Kategori</th>
                            <th class="text-center py-3">Stok Global</th>
                            <th class="py-3">Sebaran Gudang</th>
                            <th class="text-center py-3 pe-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($items as $item)
                        <tr>
                            <td class="ps-4 text-muted small">{{ ($items->currentPage()-1) * $items->perPage() + $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="p-1 bg-white border rounded-3 me-3 text-center shadow-xs overflow-hidden" style="width: 45px; height: 45px;">
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid rounded-2 h-100 w-100 object-fit-cover" alt="Thumb">
                                        @else
                                            <div class="h-100 w-100 d-flex align-items-center justify-content-center bg-light text-muted">
                                                <i class="fas fa-image opacity-50"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $item->name }}</div>
                                        <div class="small text-muted" style="font-size: 0.75rem;">
                                            <span class="me-2 text-uppercase fw-medium">{{ $item->sku }}</span>
                                            @if($item->composition)
                                                <span class="text-secondary">| {{ $item->composition }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 0.7rem;">
                                    {{ $item->category->name ?? '-' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="fw-bold fs-5 {{ $item->stock <= ($item->min_stock ?? 0) ? 'text-danger' : 'text-primary' }}">
                                    {{ number_format($item->stock, 2, ',', '.') }}
                                </div>
                                <div class="small text-muted fw-medium fs-xs uppercase">{{ $item->unit->short_name ?? ($item->unit->name ?? '-') }}</div>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @forelse($item->warehouseStocks as $ws)
                                        <div class="px-2 py-1 bg-white border rounded-pill small d-flex align-items-center mb-1" style="font-size: 0.75rem;">
                                            <span class="fw-bold text-primary me-1">{{ $ws->warehouse->code }}:</span>
                                            <span class="text-dark">{{ number_format($ws->stock, 0, ',', '.') }}</span>
                                        </div>
                                    @empty
                                        <span class="text-muted italic small opacity-50">Belum ada alokasi</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="text-center pe-4">
                                @if($item->stock <= 0)
                                    <span class="badge bg-danger-soft text-danger border-0 px-3 py-2 rounded-3 w-100">
                                        <i class="fas fa-times-circle me-1"></i> HABIS
                                    </span>
                                @elseif($item->stock <= ($item->min_stock ?? 10))
                                    <span class="badge bg-warning-soft text-warning border-0 px-3 py-2 rounded-3 w-100">
                                        <i class="fas fa-exclamation-triangle me-1"></i> KRITIS
                                    </span>
                                @else
                                    <span class="badge bg-success-soft text-success border-0 px-3 py-2 rounded-3 w-100">
                                        <i class="fas fa-check-circle me-1"></i> AMAN
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="mb-3 opacity-25"><i class="fas fa-box-open fa-4x text-muted"></i></div>
                                <h6 class="text-muted fw-bold">Material tidak ditemukan</h6>
                                <p class="small text-muted">Silahkan sesuaikan kriteria filter Anda.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($items->hasPages())
                <div class="px-4 py-3 border-top bg-light">
                    {{ $items->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Info Alert --}}
    <div class="row">
        <div class="col-lg-8">
            <div class="bg-white p-3 rounded-3 shadow-sm d-flex align-items-center border-start border-primary border-4">
                <div class="flex-shrink-0 bg-primary-subtle p-3 rounded-circle me-3">
                    <i class="fas fa-info-circle text-primary"></i>
                </div>
                <div>
                    <h6 class="mb-1 fw-bold text-dark small">Catatan Navigasi Stok</h6>
                    <p class="small text-muted mb-0" style="line-height: 1.4;">Data stok diperbarui secara otomatis ketika transaksi masuk/keluar divalidasi. Gunakan informasi ini sebagai referensi utama saat menyusun Rencana Produksi tahunan maupun bulanan.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-success-soft { background-color: rgba(46, 204, 113, 0.1); color: #2ecc71; }
    .bg-danger-soft { background-color: rgba(231, 76, 60, 0.1); color: #e74c3c; }
    .bg-warning-soft { background-color: rgba(241, 196, 15, 0.1); color: #f39c12; }
    .bg-primary-soft { background-color: rgba(52, 152, 219, 0.1); color: #3498db; }
    
    .fs-xs { font-size: 0.7rem; }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush
