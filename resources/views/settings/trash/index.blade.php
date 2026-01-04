@extends('layouts.app')

@section('title', 'Pusat Pemulihan Data (Trash)')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold text-gradient">
            <i class="fas fa-trash-restore me-2"></i>Pusat Pemulihan Data
        </h4>
        <div class="alert alert-info py-2 px-3 mb-0 border-0 shadow-sm small">
            <i class="fas fa-info-circle me-1"></i> Data yang dihapus (Soft Delete) dapat dipulihkan di sini.
        </div>
    </div>

    {{-- Tab Navigation --}}
    <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="nav nav-pills nav-fill bg-light p-2" id="trash-tabs">
                @php
                    $tabs = [
                        'item' => ['icon' => 'box', 'label' => 'Produk'],
                        'category' => ['icon' => 'tags', 'label' => 'Kategori'],
                        'customer' => ['icon' => 'users', 'label' => 'Customer'],
                        'supplier' => ['icon' => 'truck', 'label' => 'Supplier'],
                        'sale' => ['icon' => 'receipt', 'label' => 'Penjualan'],
                        'pembelian' => ['icon' => 'file-invoice', 'label' => 'Pembelian'],
                        'production' => ['icon' => 'industry', 'label' => 'Produksi'],
                        'warehouse' => ['icon' => 'building', 'label' => 'Gudang'],
                        'sale_return' => ['icon' => 'undo-alt', 'label' => 'Retur Jual'],
                        'retur_pembelian' => ['icon' => 'undo', 'label' => 'Retur Beli'],
                        'expense' => ['icon' => 'money-bill-wave', 'label' => 'Biaya'],
                    ];
                @endphp
                @foreach($tabs as $key => $tab)
                <a href="{{ route('settings.trash.index', ['type' => $key]) }}" 
                   class="nav-link py-3 border-0 rounded-3 {{ $type == $key ? 'active shadow-sm' : 'text-muted' }}">
                    <i class="fas fa-{{ $tab['icon'] }} me-2"></i> {{ $tab['label'] }}
                </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-uppercase small text-muted">
                            <th class="ps-4">Data / Identitas</th>
                            <th>Dihapus Pada</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $row)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">
                                    {{ $row->name ?? $row->code ?? $row->invoice_number ?? $row->purchase_number ?? $row->return_number ?? $row->expense_number ?? 'ID: ' . $row->id }}
                                </div>
                                <small class="text-muted">
                                    @if($type == 'item') SKU: {{ $row->sku }} | Kategori: {{ $row->category->name ?? '-' }}
                                    @elseif($type == 'sale') Customer: {{ $row->customer->name ?? 'Umum' }}
                                    @elseif($type == 'pembelian') Supplier: {{ $row->supplier->name ?? '-' }}
                                    @elseif($type == 'production') Item: {{ $row->item->name ?? '-' }}
                                    @elseif($type == 'sale_return') Ref Penjualan: {{ $row->sale->invoice_number ?? '-' }}
                                    @elseif($type == 'retur_pembelian') Supplier: {{ $row->pembelian->supplier->name ?? '-' }}
                                    @elseif($type == 'expense') Kategori: {{ $row->category->name ?? '-' }} | Total: Rp {{ number_format($row->amount, 0, ',', '.') }}
                                    @endif
                                </small>
                            </td>
                            <td>
                                <div class="small">{{ $row->deleted_at->format('d M Y H:i') }}</div>
                                <small class="text-muted">{{ $row->deleted_at->diffForHumans() }}</small>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('settings.trash.restore', [$type, $row->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-soft-success" title="Pulihkan">
                                            <i class="fas fa-undo"></i> Pulihkan
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-soft-danger" 
                                            onclick="confirmForceDelete('{{ $type }}', {{ $row->id }})" title="Hapus Permanen">
                                        <i class="fas fa-times-circle"></i> Permanen
                                    </button>
                                    <form id="force-delete-{{ $row->id }}" action="{{ route('settings.trash.force_delete', [$type, $row->id]) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <div class="opacity-25 mb-3">
                                    <i class="fas fa-trash-restore fa-4x text-muted"></i>
                                </div>
                                <h6 class="text-muted">Tidak ada data yang dihapus untuk kategori ini.</h6>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($data->hasPages())
        <div class="card-footer bg-white border-top p-4 d-flex justify-content-end">
            {{ $data->appends(['type' => $type])->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .nav-pills .nav-link.active {
        background-color: #fff;
        color: var(--bs-primary);
        font-weight: 700;
    }
    .btn-soft-success {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
        border: none;
    }
    .btn-soft-success:hover {
        background-color: #198754;
        color: #fff;
    }
    .btn-soft-danger {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: none;
    }
    .btn-soft-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }
    .text-gradient {
        background: linear-gradient(135deg, var(--bs-primary), var(--bs-secondary));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmForceDelete(type, id) {
        Swal.fire({
            title: 'Hapus Permanen?',
            text: "Data ini akan dihapus selamanya dari database dan tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus Permanen!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('force-delete-' + id).submit();
            }
        });
    }
</script>
@endpush
