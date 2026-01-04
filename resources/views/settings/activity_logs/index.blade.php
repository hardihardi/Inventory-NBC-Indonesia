@extends('layouts.app')

@section('title', 'History Aktivitas User')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold text-gradient">
            <i class="fas fa-history me-2"></i> History Aktivitas User
        </h4>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white p-3">
            <h5 class="card-title mb-0 fs-6 fw-bold text-muted">Aktivitas Terbaru Seluruh Pengguna</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-uppercase small text-muted">
                            <th class="ps-4 border-0">Waktu</th>
                            <th class="border-0">User</th>
                            <th class="border-0">Aktivitas</th>
                            <th class="border-0">Keterangan</th>
                            <th class="text-center border-0 pe-4">IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td class="ps-4 border-0">
                                <div class="fw-bold text-dark">{{ $log->created_at->format('d M Y') }}</div>
                                <small class="text-muted">{{ $log->created_at->format('H:i') }}</small>
                            </td>
                            <td class="border-0">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-xs me-2 @if ($log->user) bg-soft-primary text-primary @else bg-light text-muted @endif">
                                        {{ substr(($log->user->name ?? 'S'), 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold small">{{ $log->user->name ?? 'System' }}</div>
                                        <small class="text-muted" style="font-size: 0.7rem;">{{ ucfirst($log->user->role ?? 'auto') }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="border-0">
                                <span class="badge @if(Str::contains($log->activity, 'Hapus')) bg-soft-danger text-danger @elseif(Str::contains($log->activity, 'Edit') || Str::contains($log->activity, 'Update')) bg-soft-warning text-warning @else bg-soft-success text-success @endif px-3">
                                    {{ $log->activity }}
                                </span>
                            </td>
                            <td class="border-0 text-muted small">
                                {{ $log->description ?? '-' }}
                            </td>
                            <td class="text-center border-0 pe-4">
                                <code class="small text-muted">{{ $log->ip_address }}</code>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-search fa-3x mb-3 opacity-25"></i>
                                <p>Belum ada rekaman aktivitas.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white p-3 d-flex justify-content-end">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .text-gradient {
        background: linear-gradient(135deg, var(--bs-primary), var(--bs-secondary));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    .avatar-xs {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f0f2f5;
        font-size: 0.7rem;
        font-weight: 700;
        color: #555;
    }
    .table th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
        color: #6c757d;
    }
    .table td {
        font-size: 0.875rem;
    }
    .truncate-text {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .op-2 { opacity: 0.2; }
</style>
@endpush
