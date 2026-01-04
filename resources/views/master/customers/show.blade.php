@extends('layouts.app')

@section('title', 'Detail Pelanggan')

@section('content')
<div class="container-fluid">
    {{-- HEADER HALAMAN --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h4 class="mb-3 mb-md-0 fw-bold text-gradient">
            <i class="fas fa-user-tag me-2"></i> Detail Pelanggan
        </h4>
        <div class="d-flex gap-2">
            @if(Auth::user()->hasPermission('inventory.edit'))
            <a href="{{ route('inventory.customers.edit', $customer->id) }}" class="btn btn-warning btn-sm text-white">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            @endif
            <a href="{{ route('inventory.customers.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    {{-- KONTEN UTAMA --}}
    <div class="row g-4">
        {{-- KOLOM KIRI: INFORMASI PELANGGAN --}}
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white p-3 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-user fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">{{ $customer->name }}</h5>
                        <span class="badge bg-info-subtle text-info-emphasis px-2 py-1 mt-1">{{ $customer->category }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold text-secondary border-bottom pb-2 mb-3">Informasi Kontak</h6>
                    <ul class="list-unstyled">
                        <li class="d-flex mb-3">
                            <i class="fas fa-envelope fa-fw me-3 mt-1 text-muted"></i>
                            <div>
                                <span class="text-muted small d-block">Email</span>
                                <span class="fw-semibold">{{ $customer->email ?? '-' }}</span>
                            </div>
                        </li>
                        <li class="d-flex mb-3">
                            <i class="fas fa-phone-alt fa-fw me-3 mt-1 text-muted"></i>
                            <div>
                                <span class="text-muted small d-block">Telepon</span>
                                <span class="fw-semibold">{{ $customer->phone ?? '-' }}</span>
                            </div>
                        </li>
                        <li class="d-flex">
                            <i class="fas fa-map-marker-alt fa-fw me-3 mt-1 text-muted"></i>
                            <div>
                                <span class="text-muted small d-block">Alamat</span>
                                <p class="mb-0 fw-semibold">{{ $customer->address ?? '-' }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="card-footer bg-light text-muted small py-2">
                    <i class="fas fa-clock me-1"></i> Terakhir diperbarui: {{ $customer->updated_at->diffForHumans() }}
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: RIWAYAT TRANSAKSI --}}
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white p-3">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-history me-2"></i>Riwayat Transaksi Terakhir</h5>
                </div>
                <div class="card-body p-0">
                    @if ($customer->sales->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3" width="30%">No. Invoice</th>
                                    <th>Tanggal</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end pe-3">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer->sales->sortByDesc('sale_date')->take(10) as $sale)
                                <tr>
                                    <td class="ps-3">
                                        <a href="{{ route('penjualan.transaksi.show', $sale->id) }}" class="fw-bold text-primary text-decoration-none">
                                            {{ $sale->invoice_number }}
                                        </a>
                                    </td>
                                    <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        @php
                                            $statusColor = match($sale->payment_status) {
                                                'paid' => 'success',
                                                'partial' => 'warning',
                                                default => 'danger'
                                            };
                                            $statusLabel = match($sale->payment_status) {
                                                'paid' => 'Lunas',
                                                'partial' => 'Sebagian',
                                                default => 'Hutang'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }}-emphasis border border-{{ $statusColor }}-subtle px-2 py-1">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-3 fw-bold">Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="p-5 text-center text-muted">
                        <i class="fas fa-shopping-cart fa-3x mb-3 opacity-25"></i>
                        <p class="mb-0">Belum ada riwayat transaksi untuk pelanggan ini.</p>
                    </div>
                    @endif
                </div>
                @if($customer->sales->count() > 10)
                <div class="card-footer bg-white text-center">
                    <a href="{{ route('penjualan.transaksi.index', ['customer_id' => $customer->id]) }}" class="btn btn-sm btn-link text-primary fw-bold text-decoration-none">
                        Lihat Semua Transaksi <i class="fas fa-arrow-right ms-1 small"></i>
                    </a>
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
    .table th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
    }
</style>
@endpush
