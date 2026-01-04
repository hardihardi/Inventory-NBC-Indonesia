@extends('layouts.app')

@section('title', 'Edit Retur Pembelian')

@section('content')
<div class="container-fluid py-0">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-0 text-gray-800">Edit Retur: {{ $returPembelian->return_number }}</h4>
            <p class="mb-0 text-muted" style="font-size: 0.8rem">Perbarui detail retur pembelian</p>
        </div>
        <div>
            <a href="{{ route('retur-pembelian.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
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

    <form action="{{ route('retur-pembelian.update', $returPembelian) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4 h-100">
                    <div class="card-header bg-primary text-white py-3">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-info-circle me-2"></i> Informasi Retur</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="pembelian_id" class="form-label">Nomor Pembelian</label>
                            <input type="text" class="form-control bg-light" value="{{ $returPembelian->pembelian->purchase_number }}" readonly>
                            <input type="hidden" name="pembelian_id" value="{{ $returPembelian->pembelian_id }}">
                        </div>

                        <div class="mb-3">
                            <label for="retur_date" class="form-label">Tanggal Retur</label>
                            <input type="date" class="form-control" name="retur_date" id="retur_date" 
                                value="{{ old('retur_date', $returPembelian->retur_date->format('Y-m-d')) }}" required>
                        </div>

                        <div class="mb-0">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea class="form-control" name="notes" id="notes" rows="4">{{ old('notes', $returPembelian->notes) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white py-3">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-boxes me-2"></i> Produk yang Diretur</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                    <tr>
                                        <th class="ps-3">Nama Produk</th>
                                        <th class="text-center">Qty Beli</th>
                                        <th class="text-center" width="150px">Qty Retur</th>
                                        <th class="text-end pe-3">Harga Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($returPembelian->pembelian->items as $index => $pItem)
                                        @php
                                            $existingItem = $returPembelian->items->where('pembelian_item_id', $pItem->id)->first();
                                            $currentQty = $existingItem ? $existingItem->quantity : 0;
                                        @endphp
                                        <tr>
                                            <td class="ps-3">
                                                <span class="fw-bold">{{ $pItem->item_name }}</span>
                                                <input type="hidden" name="items[{{ $index }}][pembelian_item_id]" value="{{ $pItem->id }}">
                                                <input type="hidden" name="items[{{ $index }}][item_id]" value="{{ $pItem->item_id }}">
                                                <input type="hidden" name="items[{{ $index }}][unit_price]" value="{{ $pItem->unit_price }}">
                                            </td>
                                            <td class="text-center">{{ $pItem->quantity }}</td>
                                            <td class="text-center">
                                                <div class="input-group input-group-sm">
                                                    <input type="number" class="form-control text-center" 
                                                        name="items[{{ $index }}][quantity]" 
                                                        value="{{ old("items.$index.quantity", $currentQty) }}" 
                                                        min="0" max="{{ $pItem->quantity }}">
                                                    <span class="input-group-text">{{ $pItem->item->unit->short_name ?? 'Unit' }}</span>
                                                </div>
                                            </td>
                                            <td class="text-end pe-3">Rp {{ number_format($pItem->unit_price, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-3 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary btn-sm px-5 py-2 text-white shadow-sm">
                        <i class="fas fa-save me-2"></i> Update Data Retur
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .card { border-radius: 10px; border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); }
</style>
@endpush
