@extends('layouts.app')

@section('title', 'Customer Portal')

@section('content')
<div class="container-fluid">
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #198754 0%, #146c43 100%) !important; color: white;">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-1 text-white">Selamat Datang, {{ $customer->name }}! 🤝</h3>
                    <p class="mb-0 text-white-50">Portal eksklusif pelanggan PT NBC Indonesia. Cek status pesanan dan rincian transaksi Anda.</p>
                </div>
            </div>
        </div>

        {{-- KPI Cards --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-soft-success text-success rounded-circle p-3 me-3">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small fw-bold">TOTAL BELANJA</h6>
                        <h4 class="fw-bold mb-0">Rp {{ number_format($totalSpent ?? 0, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-soft-danger text-danger rounded-circle p-3 me-3">
                        <i class="fas fa-exclamation-circle fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small fw-bold">BELUM TERBAYAR</h6>
                        <h4 class="fw-bold mb-0">{{ $unpaidSales }} Faktur</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Sales --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-file-invoice me-2 text-success"></i>Riwayat Pesanan Anda</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="small text-uppercase fw-bold text-muted">
                                    <th class="ps-3">No. Faktur</th>
                                    <th>Tanggal</th>
                                    <th>Total Bayar</th>
                                    <th>Status Pembayaran</th>
                                    <th class="text-end pe-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sales as $sale)
                                    <tr>
                                        <td class="ps-3 fw-bold text-primary">{{ $sale->invoice_number }}</td>
                                        <td class="text-muted">{{ $sale->sale_date->format('d M Y') }}</td>
                                        <td class="fw-bold text-dark">Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge @if($sale->payment_status == 'paid') bg-soft-success text-success @elseif($sale->payment_status == 'partial') bg-soft-warning text-warning @else bg-soft-danger text-danger @endif rounded-pill">
                                                {{ ucfirst($sale->payment_status) }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-3">
                                            <button class="btn btn-sm btn-outline-success"><i class="fas fa-download me-1"></i> PDF</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat belanja.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
