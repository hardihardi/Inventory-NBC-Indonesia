@extends('layouts.app')

@section('title', 'Daftar Gudang')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-warehouse me-2"></i>Daftar Gudang</h5>
                    @if(Auth::user()->hasPermission('warehouse.manage'))
                    <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addWarehouseModal">
                        <i class="fas fa-plus me-2"></i><span>Tambah Gudang</span>
                    </button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Gudang</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($warehouses as $warehouse)
                                <tr>
                                    <td><span class="badge bg-light text-dark border">{{ $warehouse->code }}</span></td>
                                    <td>
                                        <div class="fw-bold">{{ $warehouse->name }}</div>
                                        @if($warehouse->is_default)
                                            <span class="badge bg-info text-dark" style="font-size: 0.7rem">UTAMA</span>
                                        @endif
                                    </td>
                                    <td>{{ $warehouse->address ?: '-' }}</td>
                                    <td>
                                        <span class="badge bg-success">Aktif</span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @if(Auth::user()->hasPermission('warehouse.manage'))
                                            <button class="btn btn-action btn-soft-warning edit-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editWarehouseModal"
                                                data-id="{{ $warehouse->id }}"
                                                data-name="{{ $warehouse->name }}"
                                                data-code="{{ $warehouse->code }}"
                                                data-address="{{ $warehouse->address }}"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            @endif

                                            @if(!$warehouse->is_default && Auth::user()->hasPermission('warehouse.manage'))
                                            <form action="{{ route('inventory.warehouses.destroy', $warehouse) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-action btn-soft-danger delete-btn" data-name="{{ $warehouse->name }}" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $warehouses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addWarehouseModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('inventory.warehouses.store') }}" method="POST">
            @csrf
            <div class="modal-content glass-modal">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Gudang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Kode Gudang</label>
                        <input type="text" name="code" class="form-control" placeholder="Contoh: WH-JJK" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Gudang</label>
                        <input type="text" name="name" class="form-control" placeholder="Nama gudang" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alamat</label>
                        <textarea name="address" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editWarehouseModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content glass-modal">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Gudang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Kode Gudang</label>
                        <input type="text" name="code" id="edit_code" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Gudang</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alamat</label>
                        <textarea name="address" id="edit_address" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $('.edit-btn').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const code = $(this).data('code');
        const address = $(this).data('address');
        
        $('#editForm').attr('action', `/inventory/warehouses/${id}`);
        $('#edit_name').val(name);
        $('#edit_code').val(code);
        $('#edit_address').val(address);
    });

    $('.delete-btn').on('click', function(e) {
        const btn = $(this);
        const form = btn.closest('form');
        const name = btn.data('name');
        
        Swal.fire({
            title: 'Hapus Gudang?',
            html: `Yakin ingin menghapus gudang <b>${name}</b>? Data tidak bisa dikembalikan!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        btn.closest('tr').fadeOut(300, function() { $(this).remove(); });
                        Swal.fire('Terhapus!', response.success || 'Gudang berhasil dihapus.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', xhr.responseJSON.error || 'Terjadi kesalahan.', 'error');
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection
