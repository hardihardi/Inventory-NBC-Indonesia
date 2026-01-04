@extends('layouts.app')

@section('title', 'Penyesuaian Stok')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-adjust me-2"></i>Penyesuaian Stok</h5>
                    @if(Auth::user()->hasPermission('adjustment.create'))
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdjustmentModal">
                        <i class="fas fa-plus me-2"></i>Buat Penyesuaian
                    </button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-responsive-stack">
                            <thead class="thead-dark bg-light">
                                <tr>
                                    <th>No. Ref</th>
                                    <th>Produk</th>
                                    <th>Gudang</th>
                                    <th>Qty Penyesuaian</th>
                                    <th>Alasan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($adjustments as $adj)
                                <tr class="animate-fade">
                                    <td data-label="No. Ref"><span class="text-muted small">{{ $adj->adjustment_no }}</span></td>
                                    <td data-label="Produk">
                                        <div class="fw-bold">{{ $adj->item->name }}</div>
                                        <div class="small text-muted">{{ $adj->item->product_code }}</div>
                                    </td>
                                    <td data-label="Gudang">{{ $adj->warehouse->name }}</td>
                                    <td data-label="Qty Penyesuaian">
                                        <span class="fw-bold {{ $adj->qty_adjustment > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $adj->qty_adjustment > 0 ? '+' : '' }}{{ $adj->qty_adjustment }}
                                        </span>
                                        <div class="small text-muted">{{ $adj->qty_before }} &rarr; {{ $adj->qty_after }}</div>
                                    </td>
                                    <td data-label="Alasan">{{ $adj->reason }}</td>
                                    <td data-label="Status">
                                        @if($adj->status == 'pending')
                                            <span class="badge bg-warning">Menunggu Supervisor</span>
                                        @elseif($adj->status == 'level_1_approved')
                                            <span class="badge bg-info">Menunggu Validasi Manajer</span>
                                        @elseif($adj->status == 'approved')
                                            <span class="badge bg-success">Selesai (Distujui)</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td data-label="Aksi" class="text-nowrap">
                                        <div class="d-flex gap-2">
                                            @if($adj->status == 'pending')
                                                @if(Auth::user()->hasPermission('inventory.edit'))
                                                <button class="btn btn-action btn-soft-warning edit-btn" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editAdjustmentModal"
                                                    data-id="{{ $adj->id }}"
                                                    data-item-id="{{ $adj->item_id }}"
                                                    data-warehouse-id="{{ $adj->warehouse_id }}"
                                                    data-qty="{{ $adj->qty_adjustment }}"
                                                    data-reason="{{ $adj->reason }}"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                @endif
                                                
                                                @if(Auth::user()->hasPermission('adjustment.approve'))
                                                <button type="button" class="btn btn-action btn-soft-info approve-btn" 
                                                    data-url="{{ route('inventory.adjustments.approve_l1', $adj) }}" 
                                                    title="Approve Supervisor">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-action btn-soft-danger reject-btn" 
                                                    data-url="{{ route('inventory.adjustments.reject', $adj) }}" 
                                                    title="Tolak">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                @endif
                                                
                                                @if(Auth::user()->hasPermission('inventory.delete'))
                                                <button type="button" class="btn btn-action btn-soft-danger delete-btn" 
                                                    data-url="{{ route('inventory.adjustments.destroy', $adj) }}" 
                                                    title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @endif
                                            @elseif($adj->status == 'level_1_approved')
                                                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'procurement')
                                                <button type="button" class="btn btn-action btn-soft-success approve-btn" 
                                                    data-url="{{ route('inventory.adjustments.approve_final', $adj) }}" 
                                                    title="Validasi Manajer">
                                                    <i class="fas fa-check-double"></i>
                                                </button>
                                                <button type="button" class="btn btn-action btn-soft-danger reject-btn" 
                                                    data-url="{{ route('inventory.adjustments.reject', $adj) }}" 
                                                    title="Tolak">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Belum ada data penyesuaian.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $adjustments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addAdjustmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('inventory.adjustments.store') }}" method="POST">
            @csrf
            <div class="modal-content glass-modal">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Buat Penyesuaian Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Pilih Produk</label>
                            <select name="item_id" class="form-select select2-ajax" required>
                                <option value="">--- Pilih Produk ---</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->product_code }} - {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Pilih Gudang</label>
                            <select name="warehouse_id" class="form-select" required>
                                @foreach($warehouses as $wh)
                                    <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Jumlah Penyesuaian</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="qty_adjustment" class="form-control" placeholder="Gunakan tanda minus ( - ) untuk mengurangi stok" required>
                            <span class="input-group-text">Unit</span>
                        </div>
                        <small class="text-muted">Gunakan tanda minus ( - ) untuk mengurangi stok, Contoh: -10</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alasan Perubahan</label>
                        <textarea name="reason" class="form-control" rows="3" placeholder="Contoh: Stok rusak, salah input, dll" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ajukan Penyesuaian</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editAdjustmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content glass-modal">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Penyesuaian Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Pilih Produk</label>
                            <select name="item_id" id="edit_item_id" class="form-select select2-edit" required>
                                <option value="">--- Pilih Produk ---</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->product_code }} - {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Pilih Gudang</label>
                            <select name="warehouse_id" id="edit_warehouse_id" class="form-select" required>
                                @foreach($warehouses as $wh)
                                    <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Jumlah Penyesuaian</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="qty_adjustment" id="edit_qty" class="form-control" required>
                            <span class="input-group-text">Unit</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alasan Perubahan</label>
                        <textarea name="reason" id="edit_reason" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Penyesuaian</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2-ajax').select2({
            dropdownParent: $('#addAdjustmentModal')
        });

        $('.select2-edit').select2({
            dropdownParent: $('#editAdjustmentModal')
        });

        $('.edit-btn').on('click', function() {
            const id = $(this).data('id');
            const itemId = $(this).data('item-id');
            const warehouseId = $(this).data('warehouse-id');
            const qty = $(this).data('qty');
            const reason = $(this).data('reason');
            
            $('#editForm').attr('action', `/inventory/adjustments/${id}`);
            $('#edit_item_id').val(itemId).trigger('change');
            $('#edit_warehouse_id').val(warehouseId);
            $('#edit_qty').val(qty);
            $('#edit_reason').val(reason);
        });

        // Toggle AJAX for Approve/Reject/Delete
        function handleAction(btn, title, icon, confirmText) {
            const url = btn.data('url');
            Swal.fire({
                title: title,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: icon === 'warning' || icon === 'danger' ? '#d33' : '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: confirmText,
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: btn.hasClass('delete-btn') ? 'DELETE' : 'POST'
                        },
                        success: function(response) {
                            Swal.fire('Berhasil!', response.success, 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            let msg = 'Terjadi kesalahan.';
                            if (xhr.responseJSON && xhr.responseJSON.error) msg = xhr.responseJSON.error;
                            Swal.fire('Gagal!', msg, 'error');
                        }
                    });
                }
            });
        }

        $(document).on('click', '.approve-btn', function() {
            handleAction($(this), 'Setujui Penyesuaian?', 'question', 'Ya, Setujui!');
        });

        $(document).on('click', '.reject-btn', function() {
            handleAction($(this), 'Tolak Penyesuaian?', 'warning', 'Ya, Tolak!');
        });

        $(document).on('click', '.delete-btn', function() {
            handleAction($(this), 'Hapus Penyesuaian?', 'danger', 'Ya, Hapus!');
        });
    });
</script>
@endpush
@endsection
