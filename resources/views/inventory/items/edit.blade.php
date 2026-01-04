@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold text-gradient">
                <i class="fas fa-edit me-2"></i> Edit Produk [{{ $item->name }}]
            </h4>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i> Terjadi Kesalahan</h5>
                <p>Mohon periksa kembali isian Anda. Ada beberapa data yang tidak valid.</p>
                <hr>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('inventory.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-4">
                {{-- KOLOM KIRI: FORM UTAMA --}}
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white p-3">
                            <h5 class="mb-0 fw-semibold"><i class="fas fa-file-alt me-2 text-primary"></i>Detail Produk</h5>
                        </div>
                        <div class="card-body">
                        {{-- Foto Produk Section --}}
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Foto Produk</h6>
                            <div class="row align-items-center">
                                <div class="col-md-3 text-center mb-3 mb-md-0">
                                    <div class="image-preview-wrapper border rounded d-flex align-items-center justify-content-center bg-light" style="height: 150px; overflow: hidden;">
                                        <img id="image-preview" src="{{ $item->image ? asset('storage/' . $item->image) : asset('assets/img/noproduct.png') }}" class="img-fluid" alt="Preview Foto">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <label for="image" class="form-label">Ubah Foto Produk</label>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                                    <div class="form-text text-muted small">Format: JPG, PNG, WEBP. Maks: 2MB. Kosongkan jika tidak ingin mengubah.</div>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                            {{-- Identifikasi Section --}}
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Identifikasi Produk</h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="product_code" class="form-label">ID Produk</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="product_code" name="product_code" placeholder="PRD-XXXXXX" value="{{ old('product_code', $item->product_code) }}">
                                            <button class="btn btn-outline-primary btn-generate" type="button" data-type="product_code" title="Generate ID">
                                                <i class="fas fa-magic"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="barcode" class="form-label">Barcode</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="barcode" name="barcode" placeholder="899..." value="{{ old('barcode', $item->barcode) }}">
                                            <button class="btn btn-outline-primary btn-generate" type="button" data-type="barcode" title="Generate Barcode">
                                                <i class="fas fa-barcode"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="sku" class="form-label">SKU</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="sku" name="sku" placeholder="SKU-CAT-XXX" value="{{ old('sku', $item->sku) }}">
                                            <button class="btn btn-outline-primary btn-generate" type="button" data-type="sku" title="Generate SKU">
                                                <i class="fas fa-sync"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Kategori (Kontrol Utama) --}}
                            <div class="mb-4">
                                <label for="category_id" class="form-label required">Kategori</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                                    name="category_id" required>
                                    <option value="">Pilih Kategori...</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" data-type="{{ strtolower($category->type) }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- WADAH UNTUK FORM DINAMIS --}}
                            <div id="dynamic-fields-container">

                                {{-- Formulir Barang Umum / Lainnya --}}
                                <div id="form-general" class="dynamic-form" style="display: none;">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="form-floating"><input type="text" class="form-control"
                                                    id="general_name" name="name" value="{{ old('name', $item->name) }}"
                                                    placeholder="Nama Produk"><label for="general_name"
                                                    class="required">Nama Produk</label></div>
                                        </div>
                                        {{-- PERBAIKAN: Menambahkan Harga Modal dan Jual --}}
                                        <div class="col-md-6">
                                            <div class="form-floating"><input type="number" class="form-control"
                                                    id="general_purchase_price" name="purchase_price"
                                                    value="{{ old('purchase_price', $item->purchase_price) }}" min="0"
                                                    placeholder="Harga Modal"><label for="general_purchase_price"
                                                    class="required">Harga Modal</label></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating"><input type="number" class="form-control"
                                                    id="general_price" name="price" value="{{ old('price', $item->price) }}"
                                                    min="0" placeholder="Harga Jual"><label for="general_price"
                                                    class="required">Harga Jual</label></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select class="form-select @error('unit_id') is-invalid @enderror" id="general_unit" name="unit_id">
                                                    <option value="" disabled>Pilih Satuan</option>
                                                    @foreach($units as $u)
                                                        <option value="{{ $u->id }}" {{ old('unit_id', $item->unit_id) == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="general_unit" class="required">Satuan</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select class="form-select @error('warehouse_id') is-invalid @enderror" id="warehouse_id" name="warehouse_id" required>
                                                    <option value="" disabled>Pilih Gudang</option>
                                                    @foreach($warehouses as $w)
                                                        <option value="{{ $w->id }}" {{ old('warehouse_id', $item->warehouse_id) == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="warehouse_id" class="required">Gudang Penyimpanan</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" id="general_stock" name="stock" value="{{ old('stock', $item->stock) }}" min="0" placeholder="Stok">
                                                <label for="general_stock" class="required">Stok</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating"><textarea class="form-control"
                                                    id="general_description" name="description" style="height: 100px"
                                                    placeholder="Deskripsi">{{ old('description', $item->description) }}</textarea><label
                                                    for="general_description">Deskripsi</label></div>
                                        </div>

                                        {{-- Spesifikasi Teknis (Hanya untuk Benang/Kain) --}}
                                        <div class="col-12 tech-spec-section" style="display: none;">
                                            <h6 class="fw-bold mb-3 mt-2 text-secondary border-bottom pb-2">Spesifikasi Teknis & Warna (Benang/Kain)</h6>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="color_name_textile" name="color_name" value="{{ old('color_name', $item->color_name) }}" placeholder="Cth: Merah Marun">
                                                        <label for="color_name_textile">Nama Warna</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="color_code_textile" name="color_code" value="{{ old('color_code', $item->color_code) }}" placeholder="Cth: #800000">
                                                        <label for="color_code_textile">Kode Warna / Hex</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="composition" name="composition" value="{{ old('composition', $item->composition) }}" placeholder="Cth: 100% Cotton">
                                                        <label for="composition">Komposisi</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="technical_spec" name="technical_spec" value="{{ old('technical_spec', $item->technical_spec) }}" placeholder="Cth: Ne 30/1">
                                                        <label for="technical_spec">Spek Teknis (Konstruksi)</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="gsm" name="gsm" value="{{ old('gsm', $item->gsm) }}" placeholder="Cth: 140-150">
                                                        <label for="gsm">GSM</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="width" name="width" value="{{ old('width', $item->width) }}" placeholder="Cth: 36 inch">
                                                        <label for="width">Lebar</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand', $item->brand) }}" placeholder="Cth: Sritex">
                                                        <label for="brand">Brand/Merk</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            </div>
                        </div>
                </div>

                {{-- KOLOM KANAN: AKSI --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                        <div class="card-header bg-white p-3">
                            <h5 class="mb-0 fw-semibold"><i class="fas fa-cog me-2 text-primary"></i>Aksi</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Pastikan semua data yang ditandai dengan bintang (*) telah terisi sebelum
                                menyimpan perubahan.</p>
                        </div>
                        <div class="card-footer bg-white p-3">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success"><i class="fas fa-save me-2"></i>Simpan
                                    Perubahan</button>
                                <a href="{{ route('inventory.items.index') }}" class="btn btn-secondary">Batal</a>
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

        .dynamic-form {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Script JS tidak perlu diubah, karena sudah dinamis.
        // Script dari file create.blade.php bisa digunakan di sini juga.
        document.addEventListener('DOMContentLoaded', function () {
            const categorySelect = document.getElementById('category_id');
            const dynamicForms = document.querySelectorAll('.dynamic-form');

            function updateFormVisibility() {
                const selectedOption = categorySelect.options[categorySelect.selectedIndex];
                const selectedType = selectedOption ? selectedOption.dataset.type : null;

                let formToShowId = null;
                if (selectedType) { 
                    formToShowId = 'form-general';
                }

                // Tampilkan Spesifikasi Teknis jika Yarn atau Fabric
                const techSpecSection = document.querySelector('.tech-spec-section');
                const techInputs = techSpecSection.querySelectorAll('input, select');
                if (selectedType === 'yarn' || selectedType === 'fabric') {
                    techSpecSection.style.display = 'block';
                    techInputs.forEach(input => input.disabled = false);
                } else {
                    techSpecSection.style.display = 'none';
                    techInputs.forEach(input => input.disabled = true);
                }

                dynamicForms.forEach(form => {
                    const formId = form.getAttribute('id');
                    const inputs = form.querySelectorAll('input, textarea, select');
                    const isTarget = (formId === formToShowId);

                    form.style.display = isTarget ? 'block' : 'none';

                    inputs.forEach(input => {
                        if (input.name) {
                            input.disabled = !isTarget;
                        }
                    });
                });
            }

            // Panggil fungsi saat halaman dimuat untuk mengatur state awal
            updateFormVisibility();

            // Tambahkan event listener ke dropdown kategori
            categorySelect.addEventListener('change', updateFormVisibility);

            // --- LOGIKA GENERASI KODE OTOMATIS ---
            $('.btn-generate').on('click', function() {
                const button = $(this);
                const type = button.data('type');
                const originalHtml = button.html();
                
                // Ambil data pendukung
                const categoryId = $('#category_id').val();
                let itemName = '';
                
                // Ambil nama barang dari form yang aktif
                const activeFormId = $('.dynamic-form:visible').attr('id');
                if (activeFormId) {
                    itemName = $('#' + activeFormId).find('input[name="name"]').val();
                }

                if (type === 'sku' && !categoryId) {
                    Swal.fire('Perhatian', 'Pilih kategori terlebih dahulu untuk generate SKU', 'warning');
                    return;
                }

                button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: "{{ route('inventory.items.generate_codes') }}",
                    type: 'GET',
                    data: {
                        type: type,
                        category_id: categoryId,
                        item_name: itemName
                    },
                    success: function(response) {
                        if (response.code) {
                            $('#' + type).val(response.code);
                            
                            // Beri feedback visual sukses
                            const input = $('#' + type);
                            input.addClass('is-valid');
                            setTimeout(() => input.removeClass('is-valid'), 2000);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        Swal.fire('Error', 'Gagal generate kode. Silakan coba lagi.', 'error');
                    },
                    complete: function() {
                        button.prop('disabled', false).html(originalHtml);
                    }
                });
            });
        });

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush