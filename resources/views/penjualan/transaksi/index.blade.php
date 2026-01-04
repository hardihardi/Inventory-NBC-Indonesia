@extends('layouts.app')

@section('title', 'Daftar Transaksi Penjualan')

@section('content')
    <div class="container-fluid">
        {{-- Notifikasi Session --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Card Utama --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="mb-0 fw-bold text-gradient">
                        <i class="fas fa-cash-register me-2"></i>Daftar Transaksi
                    </h4>
                    <div class="ms-auto d-flex gap-2 flex-wrap justify-content-end">
                        <a href="{{ route('penjualan.transaksi.export') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-file-export me-1"></i> Export CSV
                        </a>
                        <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#importCsvModal">
                            <i class="fas fa-file-import me-1"></i> Import CSV
                        </button>
                        @if(Auth::user()->hasPermission('sales.create'))
                        <a href="{{ route('penjualan.transaksi.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus-circle me-1"></i> Transaksi Baru
                        </a>
                        @endif
                    </div>
                </div>
                <hr class="my-3">
                <div class="row align-items-center g-3">
                    <div class="col-md-12">
                        <div class="input-group input-group-sm" style="max-width: 350px; margin-left: auto;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" id="custom-search-input" class="form-control border-start-0"
                                placeholder="Cari di semua kolom...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-responsive-stack" id="sales-table">
                        <thead class="thead-dark bg-light text-nowrap">
                            <tr>
                                <th class="text-center" width="5%">No.</th>
                                <th>No. Faktur</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th class="text-end">Total</th>
                                <th class="text-center">Pembayaran</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Kasir</th>
                                <th class="text-center" width="120px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $sale)
                                <tr>
                                    {{-- Nomor akan diisi oleh DataTables --}}
                                    <td data-label="No." class="text-center fw-semibold"></td>
                                    <td data-label="Faktur">
                                        <a href="{{ route('penjualan.transaksi.show', $sale) }}"
                                            class="fw-bold text-primary text-decoration-none">
                                            {{ $sale->invoice_number }}
                                        </a>
                                    </td>
                                    <td data-label="Tanggal" data-order="{{ $sale->sale_date->timestamp }}">
                                        <span class="text-nowrap">{{ $sale->sale_date->isoFormat('DD MMM YY') }}</span>
                                        <small class="d-block text-muted">{{ $sale->sale_date->format('H:i') }}</small>
                                    </td>
                                    <td data-label="Pelanggan">{{ $sale->customer->name ?? ($sale->customer_name ?? 'Umum') }}</td>
                                    <td data-label="Total" class="text-end fw-bold" data-order="{{ $sale->grand_total }}">
                                        Rp {{ number_format($sale->grand_total, 0, ',', '.') }}
                                    </td>
                                    <td data-label="Pembayaran" class="text-center text-nowrap">
                                        @php $badgeClass = ($sale->payment_method == 'cash') ? 'success' : 'info'; @endphp
                                        <span
                                            class="badge bg-{{$badgeClass}}-subtle text-{{$badgeClass}}-emphasis border border-{{$badgeClass}}-subtle rounded-pill">
                                            {{ ucfirst($sale->payment_method) }}
                                        </span>
                                    </td>
                                    <td data-label="Status" class="text-center">
                                        @if($sale->payment_status == 'paid')
                                            <span class="badge bg-success rounded-pill">Lunas</span>
                                        @elseif($sale->payment_status == 'partial')
                                            <span class="badge bg-warning text-dark rounded-pill">Partial</span>
                                        @else
                                            <span class="badge bg-danger rounded-pill">Piutang</span>
                                        @endif
                                    </td>
                                    <td data-label="Kasir">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2" data-bs-toggle="tooltip"
                                                title="{{ $sale->user->name }}">
                                                {{ substr($sale->user->name, 0, 1) }}
                                            </div>
                                            <span class="d-none d-lg-inline">{{ $sale->user->name }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Aksi" class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            @if ($sale->payment_status !== 'paid')
                                                @if(Auth::user()->hasPermission('payment.process'))
                                                <button class="btn btn-action btn-success text-white btn-pay" 
                                                    data-id="{{ $sale->id }}"
                                                    data-invoice="{{ $sale->invoice_number }}"
                                                    data-total="{{ $sale->grand_total }}"
                                                    data-paid="{{ $sale->paid_amount }}"
                                                    data-remaining="{{ $sale->grand_total - $sale->paid_amount }}"
                                                    data-type="Sale"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#paymentModal"
                                                    title="Bayar Piutang">
                                                    <i class="fas fa-money-bill-wave"></i>
                                                </button>
                                                @endif
                                            @endif
                                            
                                            <a href="{{ route('penjualan.transaksi.show', $sale) }}"
                                                class="btn btn-action btn-soft-info" data-bs-toggle="tooltip"
                                                title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if(Auth::user()->hasPermission('sales.edit'))
                                            <a href="{{ route('penjualan.transaksi.edit', $sale) }}"
                                                class="btn btn-action btn-soft-warning" data-bs-toggle="tooltip"
                                                title="Edit Transaksi">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endif

                                            @if(Auth::user()->hasPermission('reports.print'))
                                            <button class="btn btn-action btn-soft-primary"
                                                onclick="printInvoice('{{ $sale->id }}')" data-bs-toggle="tooltip"
                                                title="Cetak Struk">
                                                <i class="fas fa-print"></i>
                                            </button>
                                            @endif

                                            @if(Auth::user()->hasPermission('sales.delete'))
                                            <button type="button" class="btn btn-action btn-soft-danger delete-btn" 
                                                    data-url="{{ route('penjualan.transaksi.destroy', $sale) }}"
                                                    data-bs-toggle="tooltip" title="Hapus Transaksi">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5 border-0">
                                        <div class="empty-state py-4 p-md-5 text-center">
                                            <div class="bg-success bg-opacity-10 text-success rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                                <i class="fas fa-cash-register fa-3x"></i>
                                            </div>
                                            <h4 class="fw-bold text-dark">Daftar Transaksi Masih Kosong</h4>
                                            <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">Belum ada pesanan yang tercatat. Segera buat transaksi penjualan pertama Anda atau import data dari file CSV.</p>
                                            <div class="d-flex justify-content-center gap-3">
                                                <a href="{{ route('penjualan.transaksi.create') }}" class="btn btn-success rounded-pill px-4"><i class="fas fa-plus me-2"></i>Transaksi Baru</a>
                                                <a href="{{ route('help.index') }}#finance" class="btn btn-outline-secondary rounded-pill px-4">Buka Tutorial</a>
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
                        <div class="icon-shape bg-soft-success rounded-circle me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(20, 184, 166, 0.1));">
                            <i class="fas fa-money-bill-wave text-success fs-4"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold mb-0" id="paymentModalLabel">Pelunasan Piutang</h5>
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
                                            <span class="text-xs text-muted text-uppercase fw-semibold d-block mb-1">Total Piutang</span>
                                            <span class="fw-bold text-dark" id="display-total">Rp 0</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="px-2 text-center">
                                            <span class="text-xs text-muted text-uppercase fw-semibold d-block mb-1">Sisa Piutang</span>
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
                                <input type="number" name="amount" id="pay_amount" class="form-control border-0 px-2 fw-bold text-success" placeholder="0" required min="1" step="0.01">
                                <button type="button" class="btn btn-soft-success border-0 fw-bold px-3" id="btn-pay-all">
                                    SEMUA
                                </button>
                            </div>
                            <div id="amount-validation-msg" class="text-danger x-small mt-1 d-none">
                                <i class="fas fa-exclamation-circle me-1"></i> Jumlah bayar melebihi sisa piutang!
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
                        <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow-success" id="btn-submit-payment" style="border-radius: 2rem; background: linear-gradient(to right, #22c55e, #14b8a6);">
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
                <form action="{{ route('penjualan.transaksi.import_csv') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-info text-white border-0 py-3">
                        <h5 class="modal-title fw-bold"><i class="fas fa-file-import me-2"></i>Import Penjualan dari CSV</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="alert alert-info small border-0 mb-4">
                            <i class="fas fa-info-circle me-2"></i> Pastikan file sesuai dengan format Export.
                            <strong>Penting:</strong> Gunakan Invoice Number yang sama untuk item-item dalam satu transaksi yang sama.
                        </div>
                        <div class="mb-3">
                            <label for="csv_file" class="form-label fw-semibold">Pilih File CSV</label>
                            <input type="file" name="file" id="csv_file" class="form-control" accept=".csv" required>
                            <div class="form-text mt-2">Format kolom minimum: invoice_number, sale_date, customer_name, item_sku, quantity, unit_price.</div>
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
            background: linear-gradient(135deg, var(--bs-primary), var(--bs-secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .table th {
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            vertical-align: middle;
            font-size: 0.875rem;
        }

        .avatar-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bs-primary-bg-subtle);
            color: var(--bs-primary-text-emphasis);
            font-weight: 600;
        }

        /* Tampilan Kartu Responsif untuk Tabel */
        @media (max-width: 991.98px) {
            .table thead {
                display: none;
            }

            .table tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #dee2e6;
                border-radius: .5rem;
                box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
            }

            .table td {
                display: flex;
                align-items: center;
                justify-content: space-between;
                text-align: right;
                border-bottom: 1px solid #f0f0f0;
                padding: 0.75rem 1rem;
            }

            .table td:last-child {
                border-bottom: 0;
            }

            .table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #6c757d;
                margin-right: 1rem;
                text-align: left;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        function printInvoice(saleId) {
            const printUrl = "{{ url('/penjualan/transaksi') }}/" + saleId + "/print";
            window.open(printUrl, '_blank', 'width=800,height=600');
        }

        $(document).ready(function () {
            var tableElement = $('#sales-table:not(.is-empty)');
            if (tableElement.length) {
                var table = tableElement.DataTable({
                    dom: 'rt<"d-flex justify-content-between align-items-center p-3"ip>',
                    paging: true,
                    searching: true,
                    lengthChange: false,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    responsive: false,
                    order: [[2, 'desc']],
                    language: {
                        search: "",
                        zeroRecords: "Tidak ada transaksi yang cocok.",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ transaksi",
                        infoEmpty: "Menampilkan 0 transaksi",
                        paginate: { next: "›", previous: "‹" }
                    },
                    columnDefs: [
                        {
                            searchable: false, orderable: false, targets: 0,
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        { orderable: false, targets: 8 }
                    ],
                    drawCallback: function (settings) {
                        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                        [...tooltipTriggerList].map(tooltip => new bootstrap.Tooltip(tooltip));
                    }
                });

                $('#custom-search-input').on('keyup', function () {
                    table.search(this.value).draw();
                });

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

                $(document).on('click', '.delete-btn', function (e) {
                    e.preventDefault();
                    const btn = $(this);
                    const url = btn.data('url');

                    Swal.fire({
                        title: 'Hapus Transaksi?',
                        text: "Data yang dihapus akan mengembalikan stok barang!",
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
            } else {
                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                [...tooltipTriggerList].map(tooltip => new bootstrap.Tooltip(tooltip));
            }
        });
    </script>
@endpush