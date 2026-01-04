@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white p-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="mb-0 fw-bold text-primary">
                    <i class="fas fa-users me-2"></i>Data Pelanggan
                </h4>
                @if(Auth::user()->hasPermission('inventory.create'))
                <a href="{{ route('inventory.customers.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Pelanggan
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

            <div class="table-responsive">
                <table class="table table-hover align-middle table-responsive-stack" id="customers-table">
                    <thead class="thead-dark bg-light">
                        <tr>
                            <th width="5%">No.</th>
                            <th>Nama Pelanggan</th>
                            <th>Kategori</th>
                            <th>Kontak</th>
                            <th>Alamat</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer)
                            <tr>
                                <td data-label="No.">{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}</td>
                                <td data-label="Nama Pelanggan">
                                    <div class="fw-bold">{{ $customer->name }}</div>
                                    <small class="text-muted">{{ $customer->email ?? '-' }}</small>
                                </td>
                                <td data-label="Kategori">
                                    @php
                                        $badgeClass = 'secondary';
                                        if ($customer->category === 'Grosir') $badgeClass = 'warning';
                                        if ($customer->category === 'Individu') $badgeClass = 'info';
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}-subtle text-{{ $badgeClass }}-emphasis border border-{{ $badgeClass }}-subtle">
                                        {{ $customer->category }}
                                    </span>
                                </td>
                                <td data-label="Kontak">
                                    <div><i class="fas fa-phone-alt small me-1 text-muted"></i> {{ $customer->phone ?? '-' }}</div>
                                </td>
                                <td data-label="Alamat">
                                    <small class="text-truncate d-inline-block" style="max-width: 200px;">
                                        {{ $customer->address ?? '-' }}
                                    </small>
                                </td>
                                <td data-label="Aksi" class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('inventory.customers.show', $customer->id) }}" class="btn btn-action btn-soft-info" data-bs-toggle="tooltip" title="Detail"><i class="fas fa-eye"></i></a>
                                        
                                        @if(Auth::user()->hasPermission('inventory.edit'))
                                        <a href="{{ route('inventory.customers.edit', $customer->id) }}" class="btn btn-action btn-soft-warning" data-bs-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                                        @endif

                                        @if(Auth::user()->hasPermission('inventory.delete'))
                                        <button type="button" class="btn btn-action btn-soft-danger delete-btn" 
                                                data-url="{{ route('inventory.customers.destroy', $customer) }}" 
                                                data-name="{{ $customer->name }}"
                                                data-bs-toggle="tooltip"
                                                title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        @endif
                                    </div>
                                    <form id="delete-form-{{ $customer->id }}" action="{{ route('inventory.customers.destroy', $customer) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-users-slash fa-3x mb-3 opacity-25"></i>
                                    <p class="mb-0">Belum ada data pelanggan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-4">
                {{ $customers->links() }}
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
                title: 'Hapus Pelanggan?',
                html: `Yakin ingin menghapus data pelanggan <b>${name}</b>?`,
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
                            Swal.fire('Berhasil!', response.success || 'Data pelanggan telah dihapus.', 'success');
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
