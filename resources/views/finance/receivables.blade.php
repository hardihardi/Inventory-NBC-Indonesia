@extends('layouts.app')

@section('title', 'Daftar Piutang')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold text-primary"><i class="fas fa-hand-holding-usd me-2"></i>Daftar Piutang (Receivables)</h4>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No. Invoice</th>
                            <th>Customer</th>
                            <th>Tanggal Penjualan</th>
                            <th>Jatuh Tempo</th>
                            <th class="text-end">Total</th>
                            <th class="text-end">Sudah Dibayar</th>
                            <th class="text-end">Sisa Piutang</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($receivables as $sale)
                        <tr>
                            <td class="fw-bold text-primary">{{ $sale->invoice_number }}</td>
                            <td>{{ $sale->customer->name ?? $sale->customer_name }}</td>
                            <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                            <td>
                                @if($sale->due_date)
                                    <span class="{{ \Carbon\Carbon::parse($sale->due_date)->isPast() ? 'text-danger fw-bold' : '' }}">
                                        {{ \Carbon\Carbon::parse($sale->due_date)->format('d/m/Y') }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-end">Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</td>
                            <td class="text-end text-success">Rp {{ number_format($sale->paid_amount, 0, ',', '.') }}</td>
                            <td class="text-end text-danger fw-bold">Rp {{ number_format($sale->grand_total - $sale->paid_amount, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-success payment-btn" 
                                    data-id="{{ $sale->id }}" 
                                    data-type="Sale" 
                                    data-ref="{{ $sale->invoice_number }}"
                                    data-remaining="{{ $sale->grand_total - $sale->paid_amount }}">
                                    <i class="fas fa-money-bill-wave me-1"></i>Bayar
                                </button>
                                <a href="{{ route('penjualan.transaksi.show', $sale->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted fst-italic">Tidak ada piutang yang tercatat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $receivables->links() }}
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
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Catat Penagihan Piutang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Referensi</label>
                        <input type="text" id="ref_display" class="form-control bg-light" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sisa Tagihan</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="remaining_display" class="form-control bg-light" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah Bayar</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="amount" id="pay_amount" class="form-control form-control-lg border-primary" required min="1">
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
                    <button type="submit" class="btn btn-primary px-4">Simpan Pembayaran</button>
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
