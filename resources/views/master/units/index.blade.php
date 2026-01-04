@extends('layouts.app')

@section('title', 'Master Satuan')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white p-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="mb-0 fw-bold text-primary">
                    <i class="fas fa-balance-scale me-2"></i>Master Satuan
                </h4>
                @if(Auth::user()->hasPermission('inventory.create'))
                <a href="{{ route('inventory.units.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Satuan
                </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle table-responsive-stack">
                    <thead class="thead-dark bg-light">
                        <tr>
                            <th width="5%">No.</th>
                            <th>Nama Satuan</th>
                            <th>Singkatan</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($units as $unit)
                            <tr>
                                <td data-label="No.">{{ ($units->currentPage() - 1) * $units->perPage() + $loop->iteration }}</td>
                                <td data-label="Nama Satuan" class="fw-bold">{{ $unit->name }}</td>
                                <td data-label="Singkatan">{{ $unit->short_name ?? '-' }}</td>
                                <td data-label="Aksi" class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        @if(Auth::user()->hasPermission('inventory.edit'))
                                        <a href="{{ route('inventory.units.edit', $unit) }}" class="btn btn-action btn-soft-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endif

                                        @if(Auth::user()->hasPermission('inventory.delete'))
                                        <button type="button" class="btn btn-action btn-soft-danger delete-btn" 
                                                data-url="{{ route('inventory.units.destroy', $unit) }}" 
                                                data-name="{{ $unit->name }}"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif
                                    </div>
                                    <form id="delete-form-{{ $unit->id }}" action="{{ route('inventory.units.destroy', $unit) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-balance-scale fa-3x mb-3 opacity-25"></i>
                                    <p class="mb-0">Belum ada data satuan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-4">
                {{ $units->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.delete-btn').on('click', function() {
            const btn = $(this);
            const url = btn.data('url');
            const name = btn.data('name');
            
            Swal.fire({
                title: 'Hapus Satuan?',
                html: `Yakin ingin menghapus satuan <b>${name}</b>?`,
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
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            btn.closest('tr').fadeOut(300, function() { $(this).remove(); });
                            Swal.fire('Berhasil!', response.success || 'Satuan telah dihapus.', 'success');
                        },
                        error: function(xhr) {
                            Swal.fire('Gagal!', xhr.responseJSON.error || 'Terjadi kesalahan.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
