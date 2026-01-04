@extends('layouts.app')

@section('title', 'Catat Pengeluaran Baru')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-gradient"><i class="fas fa-plus-circle me-2"></i>Catat Pengeluaran Baru</h4>
                <a href="{{ route('finance.expenses.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('finance.expenses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required">Tanggal Pengeluaran</label>
                                <input type="date" name="expense_date" class="form-control" value="{{ old('expense_date', date('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">Kategori</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label required">Jumlah Biaya (Rp)</label>
                                <input type="number" name="amount" class="form-control" placeholder="Contoh: 500000" min="0" value="{{ old('amount') }}" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label required">Keterangan</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan detail pengeluaran..." required>{{ old('description') }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Bukti Foto / Struk (Opsional)</label>
                                <input type="file" name="proof_image" class="form-control" accept="image/*">
                                <div class="form-text">Format: JPG, PNG. Maks: 2MB.</div>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Simpan Pengeluaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles')
<style>
.text-gradient {
    background: linear-gradient(135deg, var(--bs-primary), var(--bs-danger));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
</style>
@endpush
