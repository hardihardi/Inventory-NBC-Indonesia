@extends('layouts.app')

@section('title', 'Daftar Hutang')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold text-danger"><i class="fas fa-file-invoice-dollar me-2"></i>Daftar Hutang (Payables)</h4>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No. Pembelian</th>
                            <th>Supplier</th>
                            <th>Tanggal Pembelian</th>
                            <th>Jatuh Tempo</th>
                            <th class="text-end">Total</th>
                            <th class="text-end">Sudah Dibayar</th>
                            <th class="text-end">Sisa Hutang</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payables as $pembelian)
                        <tr>
                            <td class="fw-bold text-danger">{{ $pembelian->purchase_number }}</td>
                            <td>{{ $pembelian->supplier->name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($pembelian->purchase_date)->format('d/m/Y') }}</td>
                            <td>
                                @if($pembelian->due_date)
                                    <span class="{{ \Carbon\Carbon::parse($pembelian->due_date)->isPast() ? 'text-danger fw-bold' : '' }}">
                                        {{ \Carbon\Carbon::parse($pembelian->due_date)->format('d/m/Y') }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-end">Rp {{ number_format($pembelian->total_amount, 0, ',', '.') }}</td>
                            <td class="text-end text-success">Rp {{ number_format($pembelian->paid_amount, 0, ',', '.') }}</td>
                            <td class="text-end text-danger fw-bold">Rp {{ number_format($pembelian->total_amount - $pembelian->paid_amount, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-danger payment-btn" 
                                    data-id="{{ $pembelian->id }}" 
                                    data-type="Pembelian" 
                                    data-ref="{{ $pembelian->purchase_number }}"
                                    data-remaining="{{ $pembelian->total_amount - $pembelian->paid_amount }}">
                                    <i class="fas fa-money-bill-wave me-1"></i>Bayar
                                </button>
                                <a href="{{ route('pembelian.show', $pembelian->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted fst-italic">Tidak ada hutang yang tercatat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $payables->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Pembayaran -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('payments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="reference_type" id="ref_type">
            <input type="hidden" name="reference_id" id="ref_id">
            <div class="modal-content border-0">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Catat Pelunasan Hutang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Referensi</label>
                        <input type="text" id="ref_display" class="form-control bg-light" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sisa Hutang</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="remaining_display" class="form-control bg-light" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-danger">Jumlah Pembayaran</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="amount" id="pay_amount" class="form-control form-control-lg border-danger" required min="1">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Bayar</label>
                        <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="Cash">Tunai (Cash)</option>
                            <option value="Transfer">Transfer Bank</option>
                            <option value="Check">Cek/Giro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger px-4">Simpan Pembayaran</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.payment-btn').on('click', function() {
        const id = $(this).data('id');
        const type = $(this).data('type');
        const ref = $(this).data('ref');
        const remaining = $(this).data('remaining');

        $('#ref_id').val(id);
        $('#ref_type').val(type);
        $('#ref_display').val(ref);
        $('#remaining_display').val(new Intl.NumberFormat('id-ID').format(remaining));
        $('#pay_amount').val(remaining);
        $('#pay_amount').attr('max', remaining);

        $('#paymentModal').modal('show');
    });
});
</script>
@endpush
