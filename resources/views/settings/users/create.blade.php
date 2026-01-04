@extends('layouts.app')

@section('title', 'Tambah User Baru')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold text-gradient"><i class="fas fa-user-plus me-2"></i>Tambah User Baru</h4>
        <a href="{{ route('settings.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('settings.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label required">Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label required">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Konfirmasi Password</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label required">Role / Hak Akses</label>
                            <select class="form-select" name="role" required>
                                <option value="" selected disabled>Pilih Role...</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator (Super Admin)</option>
                                <option value="procurement" {{ old('role') == 'procurement' ? 'selected' : '' }}>Staff Pengadaan (Procurement)</option>
                                <option value="finance" {{ old('role') == 'finance' ? 'selected' : '' }}>Finance</option>
                                <option value="kepala_gudang" {{ old('role') == 'kepala_gudang' ? 'selected' : '' }}>Kepala Gudang (Supervisor)</option>
                                <option value="staff_gudang" {{ old('role') == 'staff_gudang' ? 'selected' : '' }}>Staff Gudang / Operator Gudang</option>
                                <option value="produksi" {{ old('role') == 'produksi' ? 'selected' : '' }}>Bagian Produksi / PPIC</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Foto Profil</label>
                            <div class="d-flex flex-column align-items-center p-3 border rounded bg-light shadow-sm">
                                <div class="position-relative mb-3">
                                    <img id="preview-img" src="{{ asset('assets/img/user-placeholder.png') }}" 
                                         class="rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #fff;">
                                    <label for="image-upload" class="btn btn-sm btn-primary rounded-circle position-absolute bottom-0 end-0 shadow-sm" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                </div>
                                <input type="file" id="image-upload" class="d-none" name="image" accept="image/*" onchange="previewImage(this)">
                                <small class="text-muted text-center">Format: JPG, PNG. Maksimal 2MB.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3 border-top pt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
