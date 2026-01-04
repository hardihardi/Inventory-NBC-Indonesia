@extends('layouts.app')

@section('title', 'Transfer Stok')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-exchange-alt me-2"></i>Transfer Stok Antar Gudang</h5>
                    @if(Auth::user()->hasPermission('transfer.create'))
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransferModal">
                        <i class="fas fa-plus me-2"></i>Buat Transfer
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
                                    <th>Dari Gudang</th>
                                    <th>Ke Gudang</th>
                                    <th>Qty</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transfers as $trf)
                                <tr class="animate-fade">
                                    <td data-label="No. Ref"><span class="text-muted small">{{ $trf->transfer_no }}</span></td>
                                    <td data-label="Produk">
                                        <div class="fw-bold">{{ $trf->item->name }}</div>
                                        <div class="small text-muted">{{ $trf->item->product_code }}</div>
                                    </td>
                                    <td data-label="Dari"><span class="badge bg-light text-dark">{{ $trf->fromWarehouse->name }}</span></td>
                                    <td data-label="Ke"><span class="badge bg-light text-dark">{{ $trf->toWarehouse->name }}</span></td>
                                    <td data-label="Qty"><span class="fw-bold">{{ $trf->qty }}</span></td>
                                    <td data-label="Status">
                                        @if($trf->status == 'pending')
                                            <span class="badge bg-warning">Menunggu Persetujuan</span>
                                        @elseif($trf->status == 'approved')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td data-label="Aksi" class="text-nowrap">
                                        <div class="d-flex gap-2">
                                            @if($trf->status == 'pending')
                                                @if(Auth::user()->hasPermission('inventory.edit'))
                                                <button class="btn btn-action btn-soft-warning edit-btn" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editTransferModal"
                                                    data-id="{{ $trf->id }}"
                                                    data-item-id="{{ $trf->item_id }}"
                                                    data-from-id="{{ $trf->from_warehouse_id }}"
                                                    data-to-id="{{ $trf->to_warehouse_id }}"
                                                    data-qty="{{ $trf->qty }}"
                                                    data-notes="{{ $trf->notes }}"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                @endif

                                                @if(Auth::user()->hasPermission('transfer.approve'))
                                                <button type="button" class="btn btn-action btn-soft-success approve-btn" 
                                                    data-url="{{ route('inventory.transfers.approve', $trf) }}" 
                                                    title="Setujui & Pindahkan">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                @endif

                                                @if(Auth::user()->hasPermission('inventory.delete'))
                                                <button type="button" class="btn btn-action btn-soft-danger delete-btn" 
                                                    data-url="{{ route('inventory.transfers.destroy', $trf) }}" 
                                                    title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @endif
                                            @elseif($trf->status == 'rejected' || $trf->status == 'approved')
                                                @if(Auth::user()->hasPermission('inventory.delete'))
                                                <button type="button" class="btn btn-action btn-soft-danger delete-btn" 
                                                    data-url="{{ route('inventory.transfers.destroy', $trf) }}" 
                                                    title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Belum ada data transfer.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $transfers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addTransferModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('inventory.transfers.store') }}" method="POST">
            @csrf
            <div class="modal-content glass-modal">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Buat Transfer Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pilih Produk</label>
                        <select name="item_id" class="form-select select2-ajax-trf" required>
                            <option value="">--- Pilih Produk ---</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->product_code }} - {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Gudang Asal</label>
                            <select name="from_warehouse_id" class="form-select" required>
                                @foreach($warehouses as $wh)
                                    <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Gudang Tujuan</label>
                            <select name="to_warehouse_id" class="form-select" required>
                                <option value="">--- Pilih Tujuan ---</option>
                                @foreach($warehouses as $wh)
                                    <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Jumlah Transfer</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="qty" class="form-control" placeholder="Qty" required>
                            <span class="input-group-text">Unit</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Catatan (Opsional)</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ajukan Transfer</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editTransferModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content glass-modal">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Transfer Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pilih Produk</label>
                        <select name="item_id" id="edit_item_id" class="form-select select2-edit-trf" required>
                            <option value="">--- Pilih Produk ---</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->product_code }} - {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Gudang Asal</label>
                            <select name="from_warehouse_id" id="edit_from_warehouse_id" class="form-select" required>
                                @foreach($warehouses as $wh)
                                    <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Gudang Tujuan</label>
                            <select name="to_warehouse_id" id="edit_to_warehouse_id" class="form-select" required>
                                @foreach($warehouses as $wh)
                                    <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Jumlah Transfer</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="qty" id="edit_qty" class="form-control" required>
                            <span class="input-group-text">Unit</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Catatan (Opsional)</label>
                        <textarea name="notes" id="edit_notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Transfer</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2-ajax-trf').select2({
            dropdownParent: $('#addTransferModal')
        });

        $('.select2-edit-trf').select2({
            dropdownParent: $('#editTransferModal')
        });

        $('.edit-btn').on('click', function() {
            const id = $(this).data('id');
            const itemId = $(this).data('item-id');
            const fromId = $(this).data('from-id');
            const toId = $(this).data('to-id');
            const qty = $(this).data('qty');
            const notes = $(this).data('notes');
            
            $('#editForm').attr('action', `/inventory/transfers/${id}`);
            $('#edit_item_id').val(itemId).trigger('change');
            $('#edit_from_warehouse_id').val(fromId);
            $('#edit_to_warehouse_id').val(toId);
            $('#edit_qty').val(qty);
            $('#edit_notes').val(notes);
        });

        // Toggle AJAX for Approve/Reject/Delete
        function handleAction(btn, title, icon, confirmText) {
            const url = btn.data('url');
            Swal.fire({
                title: title,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: icon === 'danger' ? '#d33' : '#3085d6',
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
            handleAction($(this), 'Setujui Transfer?', 'question', 'Ya, Setujui!');
        });

        $(document).on('click', '.delete-btn', function() {
            handleAction($(this), 'Hapus Transfer?', 'danger', 'Ya, Hapus!');
        });

        // Prevent selecting same warehouse
        function syncWarehouses(sourceSelect, targetSelect) {
            const selectedVal = sourceSelect.val();
            targetSelect.find('option').prop('disabled', false);
            if (selectedVal) {
                targetSelect.find(`option[value="${selectedVal}"]`).prop('disabled', true);
            }
        }

        $('select[name="from_warehouse_id"]').on('change', function() {
            syncWarehouses($(this), $(this).closest('.modal-content').find('select[name="to_warehouse_id"]'));
        });

        $('select[name="to_warehouse_id"]').on('change', function() {
            syncWarehouses($(this), $(this).closest('.modal-content').find('select[name="from_warehouse_id"]'));
        });
    });
</script>
@endpush
@endsection
