@extends('layouts.app')

@section('title', 'Jurnal Arus Kas')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold text-primary">
            <i class="fas fa-exchange-alt me-2"></i>Jurnal Arus Kas
        </h4>
        <form action="{{ route('finance.cash-flow') }}" method="GET" class="d-flex gap-2">
            <input type="date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}">
            <input type="date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}">
            <select name="type" class="form-select form-select-sm">
                <option value="">Semua Tipe</option>
                <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Masuk</option>
                <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Keluar</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
            <a href="{{ route('finance.cash-flow') }}" class="btn btn-sm btn-secondary">Reset</a>
        </form>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Tanggal</th>
                            <th>Kategori</th>
                            <th>Deskripsi / Referensi</th>
                            <th>Petugas</th>
                            <th>Tipe</th>
                            <th class="text-end pe-4">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cashFlows as $cf)
                        <tr>
                            <td class="ps-4 text-muted">{{ $cf->transaction_date->format('d/m/Y') }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $cf->category }}</span></td>
                            <td>
                                <div class="fw-bold">{{ $cf->notes }}</div>
                                <div class="small text-muted">{{ $cf->reference_type }} #{{ $cf->reference_id }}</div>
                            </td>
                            <td>{{ $cf->user->name ?? '-' }}</td>
                            <td>
                                @if($cf->type == 'in')
                                    <span class="badge bg-success">Uang Masuk</span>
                                @else
                                    <span class="badge bg-danger">Uang Keluar</span>
                                @endif
                            </td>
                            <td class="text-end pe-4 fw-bold {{ $cf->type == 'in' ? 'text-success' : 'text-danger' }}">
                                {{ $cf->type == 'in' ? '+' : '-' }} Rp {{ number_format($cf->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-search fa-3x text-muted mb-3 opacity-25"></i>
                                <p class="text-muted">Tidak ada data arus kas ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($cashFlows->hasPages())
        <div class="card-footer bg-white border-0">
            {{ $cashFlows->appends(request()->all())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
