@extends('layouts.app')

@section('title', 'Edit Warna')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-edit me-2"></i>Edit Warna</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('inventory.colors.update', $color->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Nama Warna <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $color->name) }}" placeholder="Contoh: Merah Cabai" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="hex_code" class="form-label fw-bold">Kode Warna (Hex)</label>
                                <div class="d-flex gap-2">
                                    <input type="color" class="form-control form-control-color" 
                                           id="color_picker" value="{{ old('hex_code', $color->hex_code ?: '#000000') }}" title="Pilih Warna" style="width: 50px;">
                                    <input type="text" class="form-control @error('hex_code') is-invalid @enderror" 
                                           id="hex_code" name="hex_code" value="{{ old('hex_code', $color->hex_code ?: '#000000') }}" placeholder="#000000">
                                </div>
                                <div class="form-text">Gunakan pemilih warna atau masukkan kode hex (misal: #FF0000).</div>
                                @error('hex_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label fw-bold">Keterangan</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Opsional...">{{ old('description', $color->description) }}</textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('inventory.colors.index') }}" class="btn btn-light border">Batal</a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-1"></i> Perbarui Warna
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Sync color picker with text input
            $('#color_picker').on('input', function() {
                $('#hex_code').val($(this).val().toUpperCase());
            });

            $('#hex_code').on('input', function() {
                let val = $(this).val();
                if(/^#[0-9A-F]{6}$/i.test(val)) {
                    $('#color_picker').val(val);
                }
            });
        });
    </script>
@endpush
