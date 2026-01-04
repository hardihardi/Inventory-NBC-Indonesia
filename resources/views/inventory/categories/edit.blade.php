@extends('layouts.app')
@section('title', 'Edit Jenis Produk')

@section('content')
  <div class="container-fluid">
    <h4 class="mb-4"><i class="fas fa-edit me-2"></i> Edit Jenis Produk ({{ $category->name }})</h4>

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Terjadi kesalahan!</strong>
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm">
    <div class="card-body">
      <form action="{{ route('inventory.categories.update', $category) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="mb-3">
        <label for="name" class="form-label">Nama Jenis Barang</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}"
        required>
      </div>
      <div class="mb-3">
        <label for="type" class="form-label">Tipe Barang</label>
        <select class="form-select" id="type" name="type" required>
          <option value="yarn" {{ old('type', $category->type) == 'yarn' ? 'selected' : '' }}>Benang (Yarn)</option>
          <option value="fabric" {{ old('type', $category->type) == 'fabric' ? 'selected' : '' }}>Kain (Fabric)</option>
          <option value="chemical" {{ old('type', $category->type) == 'chemical' ? 'selected' : '' }}>Kimia (Chemical)</option>
          <option value="dyestuff" {{ old('type', $category->type) == 'dyestuff' ? 'selected' : '' }}>Zat Warna (Dyestuff)</option>
          <option value="sparepart" {{ old('type', $category->type) == 'sparepart' ? 'selected' : '' }}>Sparepart</option>
          <option value="general" {{ old('type', $category->type) == 'general' ? 'selected' : '' }}>Umum/Lainnya</option>
        </select>
        <div class="form-text">
        Pilih tipe barang untuk pengelompokan teknis yang sesuai.
        </div>
      </div>
      <button type="submit" class="btn btn-success btn-sm">Update</button>
      <a href="{{ route('inventory.categories.index') }}" class="btn btn-secondary btn-sm">Batal</a>
      </form>
    </div>
    </div>
  </div>
@endsection