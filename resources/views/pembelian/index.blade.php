@extends('layouts.app')

@section('title', 'Daftar Pembelian')

@section('content')
    <div class="container-fluid">
        {{-- Notifikasi Session --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Card Utama --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="mb-0 fw-bold text-gradient">
                        <i class="fas fa-truck-loading me-2"></i>Daftar Pembelian
                    </h4>
                    <div class="ms-auto d-flex gap-2 flex-wrap justify-content-end">
                        <a href="{{ route('pembelian.export') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-file-export me-1"></i> Export CSV
                        </a>
                        <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#importCsvModal">
                            <i class="fas fa-file-import me-1"></i> Import CSV
                        </button>
                        @if(Auth::user()->hasPermission('purchase.create'))
                        <a href="{{ route('pembelian.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Pembelian
                        </a>
                        @endif
                    </div>
                </div>
                <hr class="my-3">
                {{-- KONTROL KUSTOM UNTUK DATATABLES --}}
                <div class="row align-items-center g-3">
                    {{-- PERUBAHAN: Menghapus kolom untuk 'Tampilkan entri' --}}
                    <div class="col-md-12">
                        <div class="input-group input-group-sm" style="max-width: 350px; margin-left: auto;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" id="custom-search-input" class="form-control border-start-0"
                                placeholder="Cari nomor, barang, supplier...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-responsive-stack" id="pembelian-table">
                        <thead class="thead-dark bg-light">
                            <tr>
                                <th width="5%" class="text-center">No.</th>
                                <th width="15%">No. Pembelian</th>
                                <th width="15%">No. Faktur</th>
                                <th>Barang</th>
                                <th>Tanggal</th>
                                <th>Supplier</th>
                                <th class="text-end">Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pembelians as $pembelian)
                                <tr>
                                    <td class="text-center"></td>
                                    <td data-label="No. Pembelian" class="fw-bold text-primary">
                                        <span>{{ $pembelian->purchase_number }}</span>
                                    </td>
                                    <td data-label="No. Faktur" class="text-muted small">
                                        @if($pembelian->invoice_number)
                                            {{ $pembelian->invoice_number }}
                                        @else
                                            <button class="btn btn-xs btn-soft-primary btn-generate-row" 
                                                    data-id="{{ $pembelian->id }}"
                                                    data-url="{{ route('pembelian.save_generated_invoice', $pembelian) }}">
                                                <i class="fas fa-magic me-1"></i> Generate
                                            </button>
                                        @endif
                                        @if($pembelian->reference_number)
                                        <br><span class="text-xs fst-italic">Ref: {{ $pembelian->reference_number }}</span>
                                        @endif
                                    </td>
                                    <td data-label="Barang" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ $pembelian->items->pluck('item_name')->join(', ') }}">
                                        @if($pembelian->items->isNotEmpty())
                                            <span>{{ $pembelian->items->first()->item_name }}</span>
                                            @if($pembelian->items->count() > 1)
                                                <span
                                                    class="badge bg-secondary-subtle text-secondary-emphasis ms-1">+{{ $pembelian->items->count() - 1 }}</span>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td data-label="Tanggal">{{ $pembelian->purchase_date->isoFormat('DD MMM YY') }}</td>
                                    <td data-label="Supplier">
                                        <div class="d-flex align-items-center">
                                            <span>{{ $pembelian->supplier->name }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Total" class="text-end fw-bold text-nowrap">Rp
                                        {{ number_format($pembelian->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td data-label="Status" class="text-center">
                                        @if($pembelian->payment_status == 'paid')
                                            <span class="badge bg-success rounded-pill">Lunas</span>
                                        @elseif($pembelian->payment_status == 'partial')
                                            <span class="badge bg-warning text-dark rounded-pill">Partial</span>
                                        @else
                                            <span class="badge bg-danger rounded-pill">Hutang</span>
                                        @endif
                                    </td>
                                    <td data-label="Aksi" class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            @if ($pembelian->payment_status !== 'paid')
                                                @if(Auth::user()->hasPermission('payment.process'))
                                                <button class="btn btn-action btn-success text-white btn-pay" 
                                                    data-id="{{ $pembelian->id }}"
                                                    data-invoice="{{ $pembelian->purchase_number }}"
                                                    data-total="{{ $pembelian->total_amount }}"
                                                    data-paid="{{ $pembelian->paid_amount }}"
                                                    data-remaining="{{ $pembelian->total_amount - $pembelian->paid_amount }}"
                                                    data-type="Pembelian"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#paymentModal"
                                                    title="Bayar Hutang">
                                                    <i class="fas fa-money-bill-wave"></i>
                                                </button>
                                                @endif
                                            @endif
                                            
                                            <a href="{{ route('pembelian.show', $pembelian) }}" class="btn btn-action btn-soft-info"
                                                data-bs-toggle="tooltip" title="Lihat Detail"><i class="fas fa-eye"></i></a>

                                            @if(Auth::user()->hasPermission('purchase.edit'))
                                            <a href="{{ route('pembelian.edit', $pembelian) }}" class="btn btn-action btn-soft-warning"
                                                data-bs-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                                            @endif

                                            @if(Auth::user()->hasPermission('purchase.delete'))
                                            <button type="button" class="btn btn-action btn-soft-danger delete-btn"
                                                data-url="{{ route('pembelian.destroy', $pembelian) }}"
                                                data-bs-toggle="tooltip"
                                                title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5 border-0">
                                        <div class="empty-state py-4 p-md-5 text-center">
                                            <div class="bg-info bg-opacity-10 text-info rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                                <i class="fas fa-truck-loading fa-3x"></i>
                                            </div>
                                            <h4 class="fw-bold text-dark">Belum Ada Riwayat Pembelian</h4>
                                            <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">Gunakan modul ini untuk mencatat pengadaan stok dari Supplier agar ketersediaan barang di gudang tetap terjaga.</p>
                                            <div class="d-flex justify-content-center gap-3">
                                                <a href="{{ route('pembelian.create') }}" class="btn btn-info text-white rounded-pill px-4"><i class="fas fa-plus me-2"></i>Catat Pembelian</a>
                                                <a href="{{ route('help.index') }}#inventory" class="btn btn-outline-secondary rounded-pill px-4">Cara Input Stok</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg overflow-hidden" style="border-radius: 1.5rem; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
                <div class="modal-header border-0 p-4 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-soft-primary rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(168, 85, 247, 0.1));">
                            <i class="fas fa-money-bill-wave text-primary fs-4"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold mb-0" id="paymentModalLabel">Pelunasan Hutang</h5>
                            <p class="text-xs text-muted mb-0" id="modal-invoice-display"></p>
                        </div>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('payments.store') }}" method="POST" id="payment-form">
                    @csrf
                    <input type="hidden" name="reference_type" id="pay_reference_type">
                    <input type="hidden" name="reference_id" id="pay_reference_id">
                    
                    <div class="modal-body p-4">
                        <div class="card bg-soft-light border-0 mb-4" style="border-radius: 1rem; background: linear-gradient(135deg, rgba(243, 244, 246, 0.5), rgba(229, 231, 235, 0.5));">
                            <div class="card-body p-3">
                                <div class="row g-0 align-items-center">
                                    <div class="col-6 border-end">
                                        <div class="px-2 text-center">
                                            <span class="text-xs text-muted text-uppercase fw-semibold d-block mb-1">Total Tagihan</span>
                                            <span class="fw-bold text-dark" id="display-total">Rp 0</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="px-2 text-center">
                                            <span class="text-xs text-muted text-uppercase fw-semibold d-block mb-1">Sisa Tagihan</span>
                                            <span class="fw-bold text-danger" id="display-remaining">Rp 0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase mb-2">Jumlah Pembayaran</label>
                            <div class="input-group input-group-lg shadow-sm border overflow-hidden" style="border-radius: 0.75rem;">
                                <span class="input-group-text bg-white border-0 ps-3 pe-2 text-muted fw-bold">Rp</span>
                                <input type="number" name="amount" id="pay_amount" class="form-control border-0 px-2 fw-bold text-primary" placeholder="0" required min="1" step="0.01">
                                <button type="button" class="btn btn-soft-primary border-0 fw-bold px-3" id="btn-pay-all">
                                    SEMUA
                                </button>
                            </div>
                            <div id="amount-validation-msg" class="text-danger x-small mt-1 d-none">
                                <i class="fas fa-exclamation-circle me-1"></i> Jumlah bayar melebihi sisa tagihan!
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted text-uppercase mb-2">Tanggal</label>
                                <input type="date" name="payment_date" class="form-control border-0 bg-light px-3 py-2 shadow-none" value="{{ date('Y-m-d') }}" required style="border-radius: 0.75rem;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted text-uppercase mb-2">Metode</label>
                                <select name="payment_method" class="form-select border-0 bg-light px-3 py-2 shadow-none" required style="border-radius: 0.75rem;">
                                    <option value="cash">💵 Tunai (Cash)</option>
                                    <option value="transfer">🏦 Transfer Bank</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="form-label fw-bold small text-muted text-uppercase mb-2">Catatan (Opsional)</label>
                            <textarea name="notes" class="form-control border-0 bg-light px-3 py-2 shadow-none" rows="2" placeholder="Contoh: Pembayaran cicilan ke-2" style="border-radius: 0.75rem;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none shadow-none me-auto px-0" data-bs-dismiss="modal">BATAL</button>
                        <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-primary" id="btn-submit-payment" style="border-radius: 2rem; background: linear-gradient(to right, #6366f1, #a855f7);">
                            SIMPAN PEMBAYARAN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    {{-- Modal Import CSV --}}
    <div class="modal fade" id="importCsvModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <form action="{{ route('pembelian.import_csv') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-info text-white border-0 py-3">
                        <h5 class="modal-title fw-bold"><i class="fas fa-file-import me-2"></i>Import Pembelian dari CSV</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="alert alert-info small border-0 mb-4">
                            <i class="fas fa-info-circle me-2"></i> Pastikan file sesuai dengan format Export.
                            <strong>Penting:</strong> Gunakan identifier yang sama (purchase_number/invoice_number) untuk item-item dalam satu transaksi.
                        </div>
                        <div class="mb-3">
                            <label for="csv_file" class="form-label fw-semibold">Pilih File CSV</label>
                            <input type="file" name="file" id="csv_file" class="form-control" accept=".csv" required>
                            <div class="form-text mt-2">Format kolom minimum: purchase_number/invoice_number, purchase_date, supplier, item_sku, quantity, unit_price.</div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0 py-3 px-4">
                        <button type="button" class="btn btn-secondary btn-sm px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info btn-sm px-4 rounded-pill text-white">
                            <i class="fas fa-upload me-1"></i> Proses Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .text-gradient {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip:
                text;
            color: transparent
        }

        .card-header {
            border-bottom: 1px solid #dee2e6
        }

        .table th {
            font-weight: 600;
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .5px;
            white-space: nowrap
        }

        .table td {
            padding: .9rem 1rem;
            vertical-align: middle;
            font-size: 1rem;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%
        }

        #datatable-search-container {
            margin-left: auto
        }

        @media (max-width:991.98px) {
            #datatable-search-container {
                max-width: none;
                margin-left: 0
            }

            .table thead {
                display: none
            }

            .table tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #dee2e6;
                border-radius: .5rem;
                box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075)
            }

            .table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 1px solid #f0f0f0;
                padding: .75rem 1rem;
            }

            .table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #6c757d;
                margin-right: 1rem;
                flex-shrink: 0;
            }

            .table td:last-child {
                border-bottom: 0;
            }
        }

        .table.is-empty tbody tr:hover {
            background-color: transparent;
            cursor: default;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function () {
            var tableElement = $('#pembelian-table:not(.is-empty)');

            if (tableElement.length) {
                var table = tableElement.DataTable({
                    dom: 'rt<"d-flex justify-content-between align-items-center p-3"ip>',
                    paging: true,
                    searching: true,
                    // PERUBAHAN: Matikan fitur lengthChange
                    lengthChange: false,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    responsive: false,
                    order: [[4, 'desc']],
                    language: {
                        zeroRecords: "Tidak ada data pembelian yang cocok.",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ pembelian",
                        infoEmpty: "Menampilkan 0 pembelian",
                        paginate: { next: "›", previous: "‹" }
                    },
                    columnDefs: [
                        { searchable: false, orderable: false, targets: 0, render: function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } },
                        { orderable: false, targets: [3, 8] }
                    ],
                    drawCallback: function (settings) {
                        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                        [...tooltipTriggerList].map(tooltip => new bootstrap.Tooltip(tooltip));
                    }
                });

                $('#custom-search-input').on('keyup', function () {
                    table.search(this.value).draw();
                });
            }

            // Logika Pembayaran (Updated)
            $(document).on('click', '.btn-pay', function () {
                const id = $(this).data('id');
                const invoice = $(this).data('invoice');
                const total = $(this).data('total');
                const paid = $(this).data('paid');
                const remaining = $(this).data('remaining');
                const type = $(this).data('type');

                $('#pay_reference_id').val(id);
                $('#pay_reference_type').val(type);
                $('#modal-invoice-display').text(invoice);
                
                // Formatting for display
                const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });
                $('#display-total').text(formatter.format(total));
                $('#display-remaining').text(formatter.format(remaining));
                
                // Set logic for "Pay All"
                $('#btn-pay-all').data('amount', remaining);
                
                // Clear and focus input
                $('#pay_amount').val('').attr('max', remaining).trigger('focus');
                $('#amount-validation-msg').addClass('d-none');
                $('#btn-submit-payment').prop('disabled', false);
            });

            // "Bayar Semua" logic
            $('#btn-pay-all').on('click', function() {
                const amount = $(this).data('amount');
                $('#pay_amount').val(amount).trigger('input');
            });

            // Validation logic
            $('#pay_amount').on('input', function() {
                const val = parseFloat($(this).val());
                const max = parseFloat($('#btn-pay-all').data('amount'));
                
                if (val > max) {
                    $('#amount-validation-msg').removeClass('d-none');
                    $('#btn-submit-payment').prop('disabled', true);
                    $(this).addClass('text-danger');
                } else {
                    $('#amount-validation-msg').addClass('d-none');
                    $('#btn-submit-payment').prop('disabled', false);
                    $(this).removeClass('text-danger');
                }
            });

            // Logika SweetAlert
            // Logika SweetAlert
            $(document).on('click', '.delete-btn', function (e) {
                e.preventDefault();
                const btn = $(this);
                const url = btn.data('url');

                Swal.fire({
                    title: 'Anda Yakin?',
                    text: "Data pembelian yang dihapus tidak dapat dikembalikan dan stok akan dikembalikan.",
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
                                btn.closest('tr').fadeOut(300, function() { 
                                    $(this).remove(); 
                                    // Optional: Reload if table is empty
                                });
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

            // Generate row operation
            $(document).on('click', '.btn-generate-row', function() {
                const btn = $(this);
                const url = btn.data('url');
                
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', xhr.responseJSON.message || 'Terjadi kesalahan.', 'error');
                        btn.prop('disabled', false).html('<i class="fas fa-magic me-1"></i> Generate');
                    }
                });
            });
        });
    </script>
@endpush