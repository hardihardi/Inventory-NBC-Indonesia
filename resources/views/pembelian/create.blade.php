@extends('layouts.app')

@section('title', 'Pembelian Baru')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold text-gradient">
                <i class="fas fa-truck-loading me-2"></i> Buat Pembelian Baru
            </h4>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i> Terjadi Kesalahan</h5>
                <p>Mohon periksa kembali isian Anda. Ada beberapa data yang tidak valid.</p>
                <hr>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('pembelian.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                {{-- KOLOM KIRI: FORM UTAMA --}}
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white p-3">
                            <h5 class="mb-0 fw-semibold"><i class="fas fa-file-invoice me-2 text-primary"></i>Informasi
                                Utama</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-3"><i class="fas fa-info-circle me-1"></i>Pilih supplier dan tanggal pembelian. Klik ikon <i class="fas fa-magic text-primary"></i> untuk generate no. faktur otomatis.</p>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="supplier_id" class="form-label required">Supplier</label>
                                    <select class="form-select @error('supplier_id') is-invalid @enderror" id="supplier_id"
                                        name="supplier_id" required>
                                        <option value="">Pilih Supplier</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="purchase_date" class="form-label required">Tanggal Pembelian</label>
                                    <input type="date" class="form-control @error('purchase_date') is-invalid @enderror"
                                        id="purchase_date" name="purchase_date"
                                        value="{{ old('purchase_date', now()->toDateString()) }}" required>
                                    @error('purchase_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="invoice_number" class="form-label">No. Faktur Internal</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('invoice_number') is-invalid @enderror"
                                            id="invoice_number" name="invoice_number"
                                            value="{{ old('invoice_number') }}" placeholder="FAK-YYYYMMDD-XXXX">
                                        <button class="btn btn-outline-primary" type="button" id="btn-generate-invoice">
                                            <i class="fas fa-magic me-1"></i>
                                        </button>
                                    </div>
                                    @error('invoice_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="reference_number" class="form-label">No. Faktur Supplier</label>
                                    <input type="text" class="form-control @error('reference_number') is-invalid @enderror"
                                        id="reference_number" name="reference_number"
                                        value="{{ old('reference_number') }}" placeholder="Contoh: INV/2024/001">
                                    @error('reference_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label for="notes" class="form-label">Catatan (Opsional)</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes"
                                        name="notes" rows="2">{{ old('notes') }}</textarea>
                                    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-header bg-white p-3 border-top">
                            <h5 class="mb-0 fw-semibold"><i class="fas fa-boxes me-2 text-primary"></i>Item Pembelian</h5>
                        </div>
                        {{-- PERUBAHAN: MENGGUNAKAN LAYOUT TABEL --}}
                        <div class="card-body p-0">
                            <p class="text-muted small mb-0 px-3 pt-3"><i class="fas fa-lightbulb me-1 text-warning"></i>Pilih produk, tentukan kuantitas. Harga akan terisi otomatis dari Harga Beli produk.</p>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0 table-responsive-stack">
                                    <thead class="thead-dark bg-light">
                                        <tr>
                                            <th class="ps-3" style="min-width: 250px;">Produk</th>
                                            <th style="width: 120px;">Qty</th>
                                            <th style="min-width: 180px;">Harga Beli</th>
                                            <th class="text-end pe-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="purchase-items-container">
                                        @if(old('items'))
                                            @foreach(old('items') as $key => $oldItem)
                                                <tr class="purchase-item-row">
                                                    <td class="ps-3">
                                                        <select class="form-select form-select-sm item-select"
                                                            name="items[{{ $loop->index }}][item_id]" required>
                                                            <option value="">Cari atau Pilih Produk</option>
                                                            @foreach ($items as $item)
                                                                <option value="{{ $item->id }}" data-price="{{ $item->purchase_price }}"
                                                                    {{ $oldItem['item_id'] == $item->id ? 'selected' : '' }}>
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm quantity-input"
                                                            name="items[{{ $loop->index }}][quantity]"
                                                            value="{{ $oldItem['quantity'] }}" min="1" required>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">Rp</span>
                                                            <input type="number" class="form-control price-input"
                                                                name="items[{{ $loop->index }}][price]"
                                                                value="{{ $oldItem['price'] }}" min="0" required>
                                                        </div>
                                                    </td>
                                                    <td class="text-end pe-3">
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-item"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            {{-- Baris pertama saat halaman baru dimuat --}}
                                            <tr class="purchase-item-row">
                                                    <td data-label="Produk" class="ps-3">
                                                        <select class="form-select form-select-sm item-select"
                                                            name="items[0][item_id]" required>
                                                            <option value="">Cari atau Pilih Produk</option>
                                                            @foreach ($items as $item)
                                                                <option value="{{ $item->id }}"
                                                                    data-price="{{ $item->purchase_price }}">{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td data-label="Qty">
                                                        <input type="number" class="form-control form-control-sm quantity-input"
                                                            name="items[0][quantity]" value="1" min="1" required>
                                                    </td>
                                                    <td data-label="Harga Beli">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">Rp</span>
                                                            <input type="number" class="form-control price-input"
                                                                name="items[0][price]" value="0" min="0" required>
                                                        </div>
                                                    </td>
                                                    <td data-label="Aksi" class="text-end pe-3">
                                                        <button type="button" class="btn btn-sm btn-danger remove-item"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <button type="button" class="btn btn-sm btn-success" id="add-item"><i
                                    class="fas fa-plus me-1"></i> Tambah Item</button>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: RINGKASAN & SUBMIT --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                        <div class="card-header bg-white p-3">
                            <h5 class="mb-0 fw-semibold"><i class="fas fa-receipt me-2 text-primary"></i>Ringkasan Pembelian
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-2"><i class="fas fa-info-circle me-1"></i>Jika tidak dibayar penuh, kolom Jatuh Tempo akan muncul untuk mencatat hutang.</p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Total Kuantitas:</span>
                                <span class="fw-bold" id="summary-item-count">0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Total</h5>
                                <h5 class="mb-0 fw-bold text-primary" id="summary-grand-total">Rp 0</h5>
                                <input type="hidden" id="grand_total_raw" value="0">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Metode Pembayaran</label>
                                <select class="form-select form-select-sm" name="payment_method">
                                    <option value="cash">Cash</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Jumlah Dibayar</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="paid_amount" id="paid_amount" value="0" min="0">
                                    <button class="btn btn-outline-secondary" type="button" id="btn-pay-full">Lunas</button>
                                </div>
                            </div>

                            <div class="mb-3 d-none" id="due_date_group">
                                <label class="form-label small fw-bold text-danger">Jatuh Tempo Hutang</label>
                                <input type="date" class="form-control form-control-sm" name="due_date" id="due_date">
                            </div>
                        </div>
                        <div class="card-footer bg-white p-3">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan
                                    Pembelian</button>
                                <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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

        .form-label.required::after {
            content: " *";
            color: var(--bs-danger);
        }

        .table th {
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            vertical-align: middle;
        }

        /* Style untuk Select2 agar sesuai dengan tema Bootstrap 5 */
        .select2-container--bootstrap-5 .select2-selection {
            border-radius: .25rem;
            /* Menyesuaikan dengan form-control-sm */
            border: 1px solid #dee2e6;
            height: 31px !important;
            padding: 0.25rem 0.5rem;
        }

        .select2-container--bootstrap-5.select2-container--focus .select2-selection,
        .select2-container--bootstrap-5.select2-container--open .select2-selection {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgb(13 110 253 / 25%);
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            padding-left: 0;
            line-height: 1.5;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            top: 50%;
            transform: translateY(-50%);
            height: 30px !important;
        }
    </style>
@endpush

@push('scripts')

    <script>
        $(document).ready(function () {
            let itemCount = {{ count(old('items', [1])) }};

            function initializeSelect2(element) {
                $(element).select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: 'Cari atau Pilih Produk'
                });
            }

            function calculateTotal() {
                let grandTotal = 0;
                let totalQty = 0;
                $('.purchase-item-row').each(function () {
                    const quantity = parseFloat($(this).find('.quantity-input').val()) || 0;
                    const price = parseFloat($(this).find('.price-input').val()) || 0;
                    grandTotal += quantity * price;
                    totalQty += quantity;
                });

                $('#summary-item-count').text(totalQty);
                $('#summary-grand-total').text('Rp ' + grandTotal.toLocaleString('id-ID'));
                $('#grand_total_raw').val(grandTotal);
                
                toggleDueDate();
            }

            function toggleDueDate() {
                let grandTotal = parseFloat($('#grand_total_raw').val()) || 0;
                let paidAmount = parseFloat($('#paid_amount').val()) || 0;
                
                if (paidAmount < grandTotal) {
                    $('#due_date_group').removeClass('d-none');
                    $('#due_date').prop('required', true);
                } else {
                    $('#due_date_group').addClass('d-none');
                    $('#due_date').prop('required', false);
                }
            }

            $('#paid_amount').on('input', function() {
                toggleDueDate();
            });

            $('#btn-pay-full').click(function() {
                let grandTotal = parseFloat($('#grand_total_raw').val()) || 0;
                $('#paid_amount').val(grandTotal).trigger('input');
            });

            // Inisialisasi untuk item yang sudah ada
            $('.item-select').each(function () {
                initializeSelect2(this);
            });
            calculateTotal();

            // Event listener untuk menambah item baru
            $('#add-item').click(function () {
                itemCount++;
                // PERUBAHAN: Template baru menggunakan <tr>
                const newItemHtml = `
                                <tr class="purchase-item-row">
                                    <td data-label="Produk" class="ps-3">
                                        <select class="form-select form-select-sm item-select" name="items[${itemCount}][item_id]" required>
                                            <option value="">Cari atau Pilih Produk</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}" data-price="{{ $item->purchase_price }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td data-label="Qty">
                                        <input type="number" class="form-control form-control-sm quantity-input" name="items[${itemCount}][quantity]" value="1" min="1" required>
                                    </td>
                                    <td data-label="Harga Beli">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control price-input" name="items[${itemCount}][price]" value="0" min="0" required>
                                        </div>
                                    </td>
                                    <td data-label="Aksi" class="text-end pe-3">
                                        <button type="button" class="btn btn-sm btn-danger remove-item"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>`;

                $('#purchase-items-container').append(newItemHtml);
                initializeSelect2($('select[name="items[${itemCount}][item_id]"]'));
            });

            $('#btn-generate-invoice').click(function() {
            const btn = $(this);
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Generating...');

            $.ajax({
                url: "{{ route('pembelian.generate_invoice_number') }}",
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#invoice_number').val(response.number);
                    }
                },
                error: function() {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat mengenerate nomor faktur.', 'error');
                },
                complete: function() {
                    btn.prop('disabled', false).html('<i class="fas fa-magic me-1"></i> Generate');
                }
            });
        });

        // Event listener untuk menghapus item
            $(document).on('click', '.remove-item', function () {
                if ($('.purchase-item-row').length > 1) {
                    $(this).closest('tr').remove();
                    calculateTotal();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Aksi Ditolak',
                        text: 'Setidaknya harus ada satu item dalam kolom pembelian.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Dimengerti'
                    });
                }
            });

            // Validasi Form sebelum Submit
            $('form').on('submit', function (e) {
                let isValid = true;
                let hasItem = false;

                $('.purchase-item-row').each(function() {
                    if ($(this).find('.item-select').val() != "") {
                        hasItem = true;
                    }
                });

                if (!hasItem) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Data Tidak Lengkap',
                        text: 'Silakan pilih setidaknya satu produk yang valid untuk dibeli.',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Cari Produk'
                    });
                    return false;
                }

                return true;
            });

            // Event listener untuk input yang mempengaruhi total
            $(document).on('input', '.quantity-input, .price-input', function () {
                calculateTotal();
            });

            // Event listener untuk mengubah harga saat produk dipilih
            $(document).on('change', '.item-select', function () {
                const selectedOption = $(this).find('option:selected');
                const price = selectedOption.data('price') || 0;
                const priceInput = $(this).closest('tr').find('.price-input');
                priceInput.val(price);
                calculateTotal();
            });
        });
    </script>
@endpush