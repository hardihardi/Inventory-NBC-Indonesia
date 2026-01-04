@extends('layouts.app')

@section('title', 'Daftar Pengeluaran')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-gradient"><i class="fas fa-money-bill-wave me-2"></i>Daftar Pengeluaran</h4>
        @if(Auth::user()->hasPermission('expense.manage'))
        <a href="{{ route('finance.expenses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Catat Pengeluaran
        </a>
        @endif
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Filter Section --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('finance.expenses.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-secondary w-100"><i class="fas fa-filter me-2"></i>Filter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-uppercase small text-muted">
                        <tr>
                            <th class="ps-4">Tanggal</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th class="text-end">Jumlah</th>
                            <th class="text-center">Bukti</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">
                                {{ $expense->expense_date->format('d M Y') }}
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info-emphasis rounded-pill px-3">
                                    {{ $expense->category->name }}
                                </span>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 250px;">
                                    {{ $expense->description }}
                                </div>
                                <small class="text-muted">By: {{ $expense->user->name ?? 'Unknown' }}</small>
                            </td>
                            <td class="text-end fw-bold text-danger">
                                {{ $expense->formatted_amount }}
                            </td>
                            <td class="text-center">
                                @if($expense->proof_image)
                                <a href="{{ asset('storage/' . $expense->proof_image) }}" target="_blank" class="text-decoration-none">
                                    <i class="fas fa-image text-primary"></i> Lihat
                                </a>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    @if(Auth::user()->hasPermission('expense.manage'))
                                    <button type="button" class="btn btn-action btn-soft-danger delete-btn" 
                                            data-url="{{ route('finance.expenses.destroy', $expense) }}"
                                            data-description="{{ $expense->description }}" 
                                            data-amount="{{ $expense->formatted_amount }}"
                                            title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-wallet fa-3x mb-3 text-secondary opacity-50"></i>
                                <p class="mb-0">Belum ada data pengeluaran.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($expenses->hasPages())
        <div class="card-footer bg-white d-flex justify-content-end">
            {{ $expenses->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
@push('styles')
<style>
.text-gradient {
    background: linear-gradient(135deg, var(--bs-primary), var(--bs-danger));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('.delete-btn').on('click', function() {
        const btn = $(this);
        const description = btn.data('description');
        const amount = btn.data('amount');
        const url = btn.data('url');
        
        Swal.fire({
            title: 'Hapus Pengeluaran?',
            html: `Yakin ingin menghapus pengeluaran:<br><b>${description}</b><br><span class="text-danger fw-bold">${amount}</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        btn.closest('tr').fadeOut(300, function() { $(this).remove(); });
                        Swal.fire('Berhasil!', response.success, 'success');
                    },
                    error: function(xhr) {
                        let msg = 'Terjadi kesalahan.';
                        if (xhr.responseJSON && xhr.responseJSON.error) msg = xhr.responseJSON.error;
                        Swal.fire('Gagal!', msg, 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
