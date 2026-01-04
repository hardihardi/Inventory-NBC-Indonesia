@extends('layouts.app')

@section('title', 'Edit Profil Perusahaan')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4 fw-bold text-gradient"><i class="fas fa-edit me-2"></i>Edit Profil Perusahaan</h4>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('settings.company.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-12">
                        <label for="name" class="form-label required">Nama Perusahaan</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $company->name) }}" required>
                    </div>
                    <div class="col-12">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $company->address) }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Telepon</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', $company->phone) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $company->email) }}">
                    </div>
                    <hr class="my-4">
                    <h5 class="fw-bold text-primary mb-3"><i class="fas fa-file-invoice me-2"></i>Konfigurasi Penomoran (Format Dokumen)</h5>
                    <div class="col-md-3">
                        <label for="invoice_prefix" class="form-label">Prefix Invoice</label>
                        <input type="text" class="form-control" id="invoice_prefix" name="invoice_prefix" value="{{ old('invoice_prefix', $company->invoice_prefix) }}" placeholder="Contoh: INV">
                    </div>
                    <div class="col-md-9">
                        <label for="invoice_format" class="form-label">Format Nomor Invoice</label>
                        <input type="text" class="form-control" id="invoice_format" name="invoice_format" value="{{ old('invoice_format', $company->invoice_format) }}" placeholder="{PREFIX}/{YEAR}/{MONTH}/{ID}">
                        <div class="form-text small text-muted">Placeholder yang tersedia: <code>{PREFIX}, {YEAR}, {MONTH}, {DAY}, {ID}</code></div>
                    </div>

                    <div class="col-md-3">
                        <label for="sj_prefix" class="form-label">Prefix Surat Jalan</label>
                        <input type="text" class="form-control" id="sj_prefix" name="sj_prefix" value="{{ old('sj_prefix', $company->sj_prefix) }}" placeholder="Contoh: SJ">
                    </div>
                    <div class="col-md-9">
                        <label for="sj_format" class="form-label">Format Nomor Surat Jalan</label>
                        <input type="text" class="form-control" id="sj_format" name="sj_format" value="{{ old('sj_format', $company->sj_format) }}" placeholder="{PREFIX}/{YEAR}/{MONTH}/{ID}">
                        <div class="form-text small text-muted">Akan digunakan pada cetakan Surat Jalan dan Dokumen Pengiriman.</div>
                    </div>

                    <hr class="my-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Logo Perusahaan</label>
                        <div class="d-flex flex-column align-items-center p-3 border rounded bg-light h-100">
                            <img id="preview-logo" 
                                 src="{{ $company->logo ? Storage::url($company->logo) : asset('assets/img/logo-placeholder.png') }}" 
                                 class="mb-3" 
                                 style="max-height: 100px; max-width: 100%; object-fit: contain;">
                            <input type="file" class="form-control form-control-sm mt-auto" name="logo" accept="image/*" onchange="previewImage(this, 'preview-logo')">
                            <div class="form-text text-center small mt-1">Format: PNG, JPG. Max: 2MB</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Favicon (Ikon Browser)</label>
                        <div class="d-flex flex-column align-items-center p-3 border rounded bg-light h-100">
                            <img id="preview-favicon" 
                                 src="{{ $company->favicon ? Storage::url($company->favicon) : asset('assets/img/logo-placeholder.png') }}" 
                                 class="mb-3 border rounded shadow-sm" 
                                 style="width: 32px; height: 32px; object-fit: contain;">
                            <input type="file" class="form-control form-control-sm mt-auto" name="favicon" accept="image/x-icon,image/png" onchange="previewImage(this, 'preview-favicon')">
                            <div class="form-text text-center small mt-1">Disarankan: 32x32 px. ICO/PNG.</div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('settings.company.index') }}" class="btn btn-outline-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input, targetId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(targetId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
