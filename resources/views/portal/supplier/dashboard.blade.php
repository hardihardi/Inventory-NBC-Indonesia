@extends('layouts.app')

@section('title', 'Supplier Portal')

@section('content')
<div class="container-fluid">
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important; color: white;">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-1 text-white">Halo, {{ $supplier->name }}! 👋</h3>
                    <p class="mb-0 text-white-50">Selamat datang di portal mitra PT NBC Indonesia. Pantau pesanan dan pembayaran Anda di sini.</p>
                </div>
            </div>
        </div>

        {{-- KPI Cards --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-soft-primary text-primary rounded-circle p-3 me-3">
                        <i class="fas fa-file-invoice-dollar fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small fw-bold">TOTAL TRANSAKSI</h6>
                        <h4 class="fw-bold mb-0">Rp {{ number_format($totalPurchases ?? 0, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-soft-warning text-warning rounded-circle p-3 me-3">
                        <i class="fas fa-hourglass-half fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small fw-bold">PESANAN PENDING</h6>
                        <h4 class="fw-bold mb-0">{{ $pendingPurchases }} Pesanan</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Purchases --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-history me-2 text-primary"></i>10 Pesanan Terakhir</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="small text-uppercase fw-bold text-muted">
                                    <th class="ps-3">No. Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Total Tagihan</th>
                                    <th>Status Pembayaran</th>
                                    <th class="text-end pe-3">Status Pesanan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purchases as $purchase)
                                    <tr>
                                        <td class="ps-3 fw-bold">{{ $purchase->purchase_number }}</td>
                                        <td class="text-muted">{{ $purchase->purchase_date->format('d M Y') }}</td>
                                        <td class="fw-bold text-dark">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge @if($purchase->payment_status == 'paid') bg-soft-success text-success @elseif($purchase->payment_status == 'partial') bg-soft-warning text-warning @else bg-soft-danger text-danger @endif rounded-pill">
                                                {{ ucfirst($purchase->payment_status) }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-3">
                                            <span class="badge bg-soft-primary text-primary">{{ ucfirst($purchase->status) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data pesanan.</td></tr>
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
