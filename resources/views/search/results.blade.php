@extends('layouts.app')

@section('title', 'Hasil Pencarian')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="fw-bold">Hasil Pencarian untuk: <span class="text-primary">"{{ $query }}"</span></h4>
        <p class="text-muted small">Ditemukan {{ $items->count() + $customers->count() + $suppliers->count() }} hasil yang cocok.</p>
    </div>

    <div class="row g-4">
        {{-- Items Results --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-boxes me-2"></i>Produk ({{ $items->count() }})</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="small text-uppercase fw-bold text-muted">
                                    <th class="ps-3">Nama Produk</th>
                                    <th>Kode / SKU</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Stok</th>
                                    <th class="text-end pe-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                    <tr>
                                        <td class="ps-3 fw-bold">{{ $item->name }}</td>
                                        <td><span class="badge bg-light text-dark border">{{ $item->sku }}</span></td>
                                        <td>{{ $item->category->name ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge @if($item->stock <= 10) bg-danger @else bg-success @endif rounded-pill">
                                                {{ $item->stock }} {{ $item->unit->name ?? 'pcs' }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-3">
                                            <a href="{{ route('inventory.items.show', $item->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center py-4 text-muted fst-italic">Tidak ada produk yang cocok.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Customers Results --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-success"><i class="fas fa-users me-2"></i>Pelanggan ({{ $customers->count() }})</h6>
                </div>
                <div class="card-body p-0 text-center">
                    @forelse($customers as $customer)
                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                            <div class="text-start">
                                <div class="fw-bold">{{ $customer->name }}</div>
                                <small class="text-muted">{{ $customer->email ?? 'no email' }} • {{ $customer->phone ?? '-' }}</small>
                            </div>
                            <a href="{{ route('inventory.customers.edit', $customer->id) }}" class="btn btn-sm btn-soft-success"><i class="fas fa-edit"></i></a>
                        </div>
                    @empty
                        <div class="p-4 text-muted fst-italic">Tidak ada pelanggan yang cocok.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Suppliers Results --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-warning"><i class="fas fa-truck me-2"></i>Supplier ({{ $suppliers->count() }})</h6>
                </div>
                <div class="card-body p-0">
                    @forelse($suppliers as $supplier)
                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                            <div class="text-start">
                                <div class="fw-bold">{{ $supplier->name }}</div>
                                <small class="text-muted">{{ $supplier->contact_person }} • {{ $supplier->phone }}</small>
                            </div>
                            <a href="{{ route('inventory.suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-soft-warning"><i class="fas fa-edit"></i></a>
                        </div>
                    @empty
                        <div class="p-4 text-muted fst-italic">Tidak ada supplier yang cocok.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-soft-success { background: rgba(25, 135, 84, 0.1); color: #198754; }
    .btn-soft-warning { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
</style>
@endsection
