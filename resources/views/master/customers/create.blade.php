@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white p-3">
                    <h4 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-user-plus me-2"></i>Tambah Pelanggan Baru
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('inventory.customers.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama pelanggan">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="category" class="form-label fw-semibold">Kategori Pelanggan <span class="text-danger">*</span></label>
                                <select class="form-select select2-simple @error('category') is-invalid @enderror" id="category" name="category" required>
                                    <option value="" selected disabled>Pilih Kategori</option>
                                    @foreach($categories as $value => $label)
                                        <option value="{{ $value }}" {{ old('category') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6" id="other_category_group" style="display: none;">
                                <label for="other_category" class="form-label fw-semibold">Sebutkan Kategori Lainnya <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('other_category') is-invalid @enderror" id="other_category" name="other_category" value="{{ old('other_category') }}" placeholder="Masukkan nama kategori">
                                @error('other_category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Alamat Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Nomor Telepon/WA</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label fw-semibold">Alamat Lengkap</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" placeholder="Masukkan alamat lengkap pelanggan">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('inventory.customers.index') }}" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2-simple').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });

        function toggleOtherCategory() {
            if ($('#category').val() === 'Other') {
                $('#other_category_group').show();
                $('#other_category').attr('required', true);
            } else {
                $('#other_category_group').hide();
                $('#other_category').attr('required', false);
            }
        }

        $('#category').on('change', toggleOtherCategory);
        toggleOtherCategory(); // Run on load
    });
</script>
@endpush
@endsection
