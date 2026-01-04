@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
    <div class="container-fluid">
        {{-- HEADER HALAMAN --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <h4 class="mb-3 mb-md-0 fw-bold text-gradient">
                <i class="fas fa-box-open me-2"></i> Detail Produk
            </h4>
            <div>
                <a href="{{ route('inventory.items.edit', $item->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                <a href="{{ route('inventory.items.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        {{-- KONTEN UTAMA --}}
        <div class="row g-4">
            {{-- KOLOM KIRI: FOTO & DETAIL --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white p-3">
                        <div class="row align-items-center g-3">
                            <div class="col-md-8 col-sm-12">
                                <div class="d-flex align-items-center">
                                    @php
                                        $categoryType = strtolower($item->category->type ?? 'general');
                                        $icon = 'fa-cube';
                                        if ($categoryType === 'cat') $icon = 'fa-paint-roller';
                                        if ($categoryType === 'keramik') $icon = 'fa-border-style';
                                        if ($categoryType === 'luar') $icon = 'fa-shipping-fast';
                                    @endphp
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3 d-none d-sm-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas {{ $icon }} fs-4"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-bold mb-0 text-dark">{{ $item->name }}</h3>
                                        <div class="d-flex align-items-center flex-wrap gap-2 mt-1">
                                            <span class="badge bg-primary-subtle text-primary-emphasis px-2 py-1">{{ $item->sku }}</span>
                                            <span class="text-muted small">•</span>
                                            <span class="text-muted small fw-medium">{{ $item->category->name ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 text-md-end text-start">
                                <div class="bg-white p-2 d-inline-block shadow-sm rounded border">
                                    {!! DNS2D::getBarcodeHTML(route('inventory.items.show', $item->id), 'QRCODE', 2.5, 2.5) !!}
                                    <div class="small fw-bold mt-1 text-center" style="font-size: 7px; color: #888;">SCAN TO VIEW</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            {{-- Foto Produk --}}
                            <div class="col-md-5">
                                <div class="border rounded-3 p-2 bg-light d-flex align-items-center justify-content-center" style="min-height: 250px;">
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid rounded shadow-sm" alt="{{ $item->name }}" style="max-height: 350px;">
                                    @else
                                        <img src="{{ asset('assets/img/noproduct.png') }}" class="img-fluid rounded opacity-75" alt="No Product Image" style="max-height: 250px;">
                                    @endif
                                </div>
                            </div>
                            {{-- Detail Deskripsi --}}
                            <div class="col-md-7">
                                <h6 class="fw-bold text-secondary border-bottom pb-2 mb-3">Deskripsi & Informasi</h6>
                                <p class="text-muted mb-4 text-justify" style="font-size: 0.95rem; line-height: 1.6;">{{ $item->description ?? 'Tidak ada deskripsi untuk produk ini.' }}</p>
                                
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="p-3 border rounded-3 bg-light bg-opacity-50">
                                            <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">SKU</small>
                                            <span class="fw-bold text-primary">{{ $item->sku ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 border rounded-3 bg-light bg-opacity-50">
                                            <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">Satuan</small>
                                            <span class="fw-bold text-dark">{{ $item->unit->name ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Detail Spesifik Berdasarkan Kategori --}}
                        <h6 class="fw-bold text-secondary mb-3">Spesifikasi Detail</h6>
                        <div class="row g-3">
                            @if ($categoryType === 'cat')
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between border-bottom pb-2">
                                        <span class="text-muted">Jenis Cat</span>
                                        <span class="fw-semibold">{{ $item->paint_type ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between border-bottom pb-2">
                                        <span class="text-muted">Nama Warna</span>
                                        <span class="fw-semibold">{{ $item->color_name ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between border-bottom pb-2">
                                        <span class="text-muted">Kode Warna</span>
                                        <span class="fw-semibold">{{ $item->color_code ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between border-bottom pb-2">
                                        <span class="text-muted">Volume</span>
                                        <span class="fw-semibold">{{ $item->volume ?? '-' }}</span>
                                    </div>
                                </div>
                            @elseif ($categoryType === 'keramik')
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between border-bottom pb-2">
                                        <span class="text-muted">Ukuran</span>
                                        <span class="fw-semibold">{{ $item->size ?? '-' }} cm</span>
                                    </div>
                                </div>
                                {{-- Tambahkan field lain jika ada --}}
                            @elseif ($categoryType === 'yarn' || $categoryType === 'fabric')
                                <div class="col-md-6">
                                    <div class="d-flex flex-column flex-sm-row justify-content-between border-bottom pb-2 h-100">
                                        <span class="text-muted mb-1 mb-sm-0"><i class="fas fa-layer-group me-2"></i>Komposisi</span>
                                        <span class="fw-semibold text-end text-sm-end text-break">{{ $item->composition ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-column flex-sm-row justify-content-between border-bottom pb-2 h-100">
                                        <span class="text-muted mb-1 mb-sm-0"><i class="fas fa-cogs me-2"></i>Spek Teknis</span>
                                        <span class="fw-semibold text-end text-sm-end text-break">{{ $item->technical_spec ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-column flex-sm-row justify-content-between border-bottom pb-2 h-100">
                                        <span class="text-muted mb-1 mb-sm-0"><i class="fas fa-weight me-2"></i>GSM</span>
                                        <span class="fw-semibold text-end text-sm-end">{{ $item->gsm ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-column flex-sm-row justify-content-between border-bottom pb-2 h-100">
                                        <span class="text-muted mb-1 mb-sm-0"><i class="fas fa-arrows-alt-h me-2"></i>Lebar</span>
                                        <span class="fw-semibold text-end text-sm-end">{{ $item->width ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex flex-column flex-sm-row justify-content-between border-bottom pb-2 h-100">
                                        <span class="text-muted mb-1 mb-sm-0"><i class="fas fa-copyright me-2"></i>Brand / Merk</span>
                                        <span class="fw-semibold text-end text-sm-end">{{ $item->brand ?? '-' }}</span>
                                    </div>
                                </div>
                            @elseif ($item->brand)
                                <div class="col-md-12">
                                    <div class="d-flex flex-column flex-sm-row justify-content-between border-bottom pb-2 h-100">
                                        <span class="text-muted mb-1 mb-sm-0"><i class="fas fa-copyright me-2"></i>Brand / Merk</span>
                                        <span class="fw-semibold text-end text-sm-end">{{ $item->brand ?? '-' }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: STOK, HARGA & BARCODE --}}
            <div class="col-lg-4">
                {{-- Kartu Barcode --}}
                <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                    <div class="card-header bg-white p-3">
                        <h5 class="mb-0 fw-semibold"><i class="fas fa-barcode me-2 text-dark"></i>Label Barcode</h5>
                    </div>
                    <div class="card-body text-center bg-light-subtle">
                        @if($item->barcode)
                            <div class="bg-white p-3 border rounded shadow-sm d-inline-block">
                                {!! DNS1D::getBarcodeHTML($item->barcode, 'C128', 2, 45) !!}
                                <div class="mt-2 fw-bold letter-spacing-2">{{ $item->barcode }}</div>
                            </div>
                        @else
                            <div class="text-muted py-3">
                                <i class="fas fa-exclamation-triangle mb-2"></i>
                                <p class="small mb-0">Barcode belum di-generate</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Kartu Stok --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="mb-0 fw-bold text-muted uppercase">Persediaan Stok</h6>
                            <i class="fas fa-warehouse text-info fs-4"></i>
                        </div>
                        <div class="d-flex align-items-end">
                            <h1 class="display-5 fw-bolder mb-0 me-2">{{ $item->stock }}</h1>
                            <span class="text-muted mb-2 fs-5">{{ $item->unit->short_name ?? $item->unit->name ?? 'Unit' }}</span>
                        </div>
                        <div class="mt-3">
                            <div class="progress" style="height: 8px;">
                                @php
                                    $percent = min(($item->stock / 100) * 100, 100);
                                    $color = $item->stock > 20 ? 'success' : ($item->stock > 0 ? 'warning' : 'danger');
                                @endphp
                                <div class="progress-bar bg-{{ $color }}" role="progressbar" style="width: {{ $percent }}%"></div>
                            </div>
                            <small class="text-muted mt-2 d-block">
                                <i class="fas fa-info-circle me-1"></i> 
                                {{ $item->stock > 10 ? 'Stok masih mencukupi' : 'Segera lakukan restok!' }}
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Distribusi Stok per Gudang --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white p-3">
                        <h5 class="mb-0 fw-semibold text-dark"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Lokasi Gudang</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($item->warehouseStocks as $ws)
                                <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
                                    <div>
                                        <div class="fw-bold">{{ $ws->warehouse->name }}</div>
                                        <small class="text-muted">{{ $ws->warehouse->address ?? 'No address' }}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge rounded-pill bg-light text-dark border p-2 px-3 fs-6">
                                            {{ $ws->stock }} {{ $item->unit->short_name ?? $item->unit->name ?? '' }}
                                        </span>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-center py-4 text-muted">
                                    <i class="fas fa-exclamation-circle mb-2 d-block fs-4 opacity-25"></i>
                                    Belum ada data stok di gudang.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                {{-- Kartu Harga --}}
                <div class="card shadow-sm border-0 bg-primary text-white overflow-hidden" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important;">
                    <div class="card-body p-4 position-relative">
                        <i class="fas fa-tag position-absolute top-0 end-0 opacity-10 mt-n2 me-n2" style="font-size: 6rem;"></i>
                        <div class="d-flex align-items-center justify-content-between mb-4 position-relative">
                            <h6 class="mb-0 fw-bold text-white-50 text-uppercase letter-spacing-1">Ringkasan Harga</h6>
                        </div>
                        
                        <div class="mb-3 position-relative">
                            <small class="text-white-50 d-block mb-1">Harga Modal</small>
                            <h5 class="fw-semibold mb-0">Rp {{ number_format($item->purchase_price ?? 0, 0, ',', '.') }}</h5>
                        </div>
                        
                        <div class="border-top border-white-25 pt-4 mt-3 position-relative">
                            <small class="text-white-50 d-block mb-1">Harga Jual (Retail)</small>
                            <h3 class="fw-bold mb-0" style="font-size: 1.75rem;">Rp {{ number_format($item->price, 0, ',', '.') }}</h3>
                        </div>
                    </div>
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
    </style>
@endpush