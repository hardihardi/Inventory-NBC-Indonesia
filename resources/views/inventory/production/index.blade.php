@extends('layouts.app')

@section('title', 'Daftar Permintaan Material')

@section('content')
<div class="container-fluid">
    {{-- Header Section --}}
    <div class="row align-items-center mb-4">
        <div class="col-md-7">
            <h4 class="mb-0 fw-bold text-dark"><i class="fas fa-clipboard-list me-2 text-primary"></i>Monitoring Permintaan Material</h4>
            <p class="text-muted small mb-0">Kelola dan pantau alur kerja material produksi (PPIC)</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0 d-flex gap-2 justify-content-md-end">
            <a href="{{ route('inventory.production.stock_check') }}" class="btn btn-light border shadow-sm px-3">
                <i class="fas fa-boxes me-2 text-secondary"></i>Cek Stok Material
            </a>
            @if(Auth::user()->hasPermission('production.create'))
            <a href="{{ route('inventory.production.create') }}" class="btn btn-primary shadow-sm px-4">
                <i class="fas fa-plus-circle me-2"></i>Request Material
            </a>
            @endif
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 h-100 overflow-hidden">
                <div class="card-body p-3 position-relative border-start border-secondary border-4">
                    <div class="d-flex align-items-center mb-1">
                        <div class="flex-shrink-0 bg-secondary-subtle p-2 rounded-3 me-2">
                            <i class="fas fa-hourglass-half text-secondary"></i>
                        </div>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem;">Planned</small>
                    </div>
                    <h3 class="fw-bold mb-0 text-dark">{{ $stats['pending'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 h-100 overflow-hidden">
                <div class="card-body p-3 position-relative border-start border-info border-4">
                    <div class="d-flex align-items-center mb-1">
                        <div class="flex-shrink-0 bg-info-subtle p-2 rounded-3 me-2">
                            <i class="fas fa-warehouse text-info"></i>
                        </div>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem;">Penyiapan</small>
                    </div>
                    <h3 class="fw-bold mb-0 text-dark">{{ $stats['approved'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 h-100 overflow-hidden">
                <div class="card-body p-3 position-relative border-start border-warning border-4">
                    <div class="d-flex align-items-center mb-1">
                        <div class="flex-shrink-0 bg-warning-subtle p-2 rounded-3 me-2">
                            <i class="fas fa-truck-loading text-warning text-dark"></i>
                        </div>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem;">Ready</small>
                    </div>
                    <h3 class="fw-bold mb-0 text-dark">{{ $stats['ready'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 h-100 overflow-hidden">
                <div class="card-body p-3 position-relative border-start border-primary border-4">
                    <div class="d-flex align-items-center mb-1">
                        <div class="flex-shrink-0 bg-primary-subtle p-2 rounded-3 me-2">
                            <i class="fas fa-cog fa-spin text-primary"></i>
                        </div>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem;">Produksi</small>
                    </div>
                    <h3 class="fw-bold mb-0 text-dark">{{ $stats['in_progress'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-2 fa-lg"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Main Data Card --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">ID RENCANA</th>
                            <th class="py-3">NO. BATCH</th>
                            <th class="py-3">PRODUK HASIL</th>
                            <th class="text-center py-3">TARGET</th>
                            <th class="text-center py-3">AKTUAL</th>
                            <th class="py-3">PIC</th>
                            <th class="py-3 text-center">STATUS</th>
                            <th class="py-3">TGL MULAI</th>
                            <th class="text-center py-3 pe-4">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($productions as $p)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $p->code }}</div>
                                <div class="small text-muted" style="font-size: 0.7rem;">{{ $p->created_at->format('d/m/y H:i') }}</div>
                            </td>
                            <td>
                                @if($p->batch_number)
                                    <div class="mt-1 small"><span class="badge bg-light text-muted border py-1">Batch: {{ $p->batch_number }}</span></div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-primary">{{ $p->item->name }}</div>
                                <div class="small text-muted fw-medium">{{ $p->item->category->name ?? '-' }}</div>
                            </td>
                            <td class="text-center fw-bold text-dark">
                                {{ number_format($p->qty_planned, 2, ',', '.') }}
                                <div class="small text-muted fw-normal" style="font-size: 0.7rem;">{{ $p->item->unit->short_name ?? '' }}</div>
                            </td>
                            <td class="text-center fw-bold">
                                @if($p->qty_actual)
                                    {{ number_format($p->qty_actual, 2, ',', '.') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light-subtle rounded-circle me-2 p-1 text-center" style="width: 25px; height: 25px;">
                                        <i class="fas fa-user text-muted small"></i>
                                    </div>
                                    <span class="small fw-medium">{{ $p->user->name ?? 'System' }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusConfig = match($p->status) {
                                        'planned' => ['bg' => '#f8f9fa', 'text' => '#6c757d', 'icon' => 'clock', 'label' => 'Rencana'],
                                        'approved' => ['bg' => '#e3f2fd', 'text' => '#0d6efd', 'icon' => 'check-circle', 'label' => 'Validasi'],
                                        'ready' => ['bg' => '#fff8e1', 'text' => '#ff8f00', 'icon' => 'box', 'label' => 'Ready'],
                                        'in_progress' => ['bg' => '#e8f5e9', 'text' => '#2e7d32', 'icon' => 'spinner fa-spin', 'label' => 'Produksi'],
                                        'completed' => ['bg' => '#f3e5f5', 'text' => '#7b1fa2', 'icon' => 'flag-checkered', 'label' => 'Selesai'],
                                        'cancelled' => ['bg' => '#ffebee', 'text' => '#c62828', 'icon' => 'times-circle', 'label' => 'Batal'],
                                        default => ['bg' => '#f8f9fa', 'text' => '#6c757d', 'icon' => 'question', 'label' => $p->status]
                                    };
                                @endphp
                                <span class="badge border-0 fw-bold px-3 py-2" style="background-color: {{ $statusConfig['bg'] }}; color: {{ $statusConfig['text'] }}; border-radius: 8px;">
                                    <i class="fas fa-{{ $statusConfig['icon'] }} me-1"></i> {{ strtoupper($statusConfig['label']) }}
                                </span>
                            </td>
                            <td>
                                <div class="small fw-bold text-dark">{{ $p->start_date ? $p->start_date->format('d M Y') : '-' }}</div>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                    <a href="{{ route('inventory.production.show', $p->id) }}" class="btn btn-light btn-sm px-3" data-bs-toggle="tooltip" title="Lihat Progress">
                                        <i class="fas fa-eye text-primary"></i>
                                    </a>
                                    @if($p->status == 'planned' && Auth::user()->hasPermission('production.edit'))
                                    <a href="{{ route('inventory.production.edit', $p->id) }}" class="btn btn-light btn-sm px-3 border-start" data-bs-toggle="tooltip" title="Ubah Rencana">
                                        <i class="fas fa-edit text-warning"></i>
                                    </a>
                                    @endif
                                    @if(Auth::user()->hasPermission('production.delete'))
                                    <button type="button" class="btn btn-light btn-sm px-3 border-start delete-btn" 
                                        data-url="{{ route('inventory.production.destroy', $p->id) }}" 
                                        data-code="{{ $p->code }}"
                                        data-bs-toggle="tooltip" title="Hapus Permanen">
                                        <i class="fas fa-trash-alt text-danger"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i>
                                <p class="mb-0 fw-bold">Belum ada data permintaan material.</p>
                                <p class="small italic">Silahkan buat permintaan baru atau sesuaikan filter pencarian.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($productions->hasPages())
                <div class="px-4 py-3 border-top bg-light">
                    {{ $productions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Delete Confirmation with AJAX
        $('.delete-btn').on('click', function() {
            const btn = $(this);
            const url = btn.data('url');
            const code = btn.data('code');
            
            Swal.fire({
                title: 'Hapus Permintaan?',
                text: `Apakah Anda yakin ingin menghapus rencana produksi ${code}? Tindakan ini tidak dapat dibatalkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus Sekarang',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            btn.closest('tr').fadeOut(300, function() { $(this).remove(); });
                            Swal.fire({
                                title: 'Terhapus!',
                                text: response.success || 'Data telah dihapus dari sistem.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        },
                        error: function(xhr) {
                            Swal.fire('Gagal!', 'Permintaan gagal dihapus. Mungkin data sudah terkunci.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
@endsection
