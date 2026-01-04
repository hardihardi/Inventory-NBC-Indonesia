@extends('layouts.app')

@section('title', 'System Tools')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="fw-bold text-gradient"><i class="fas fa-cogs me-2"></i>System Tools & Maintenance</h4>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row g-4">
        {{-- Cache Management --}}
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3 text-warning">
                        <i class="fas fa-bolt fa-3x"></i>
                    </div>
                    <h5 class="fw-bold">System Cache</h5>
                    <p class="text-muted small">
                        Bersihkan cache aplikasi, view, dan konfigurasi jika terjadi error atau perubahan tidak terbaca.
                    </p>
                    <form action="{{ route('settings.system.cache') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-sync-alt me-2"></i>Clear Cache
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Database Backup --}}
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3 text-primary">
                        <i class="fas fa-database fa-3x"></i>
                    </div>
                    <h5 class="fw-bold">Database Backup</h5>
                    <p class="text-muted small">
                        Download backup database (SQL) untuk keamanan data. Lakukan secara berkala.
                    </p>
                    <form action="{{ route('settings.system.backup') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-download me-2"></i>Download Backup
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Environment Info --}}
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="fas fa-server me-2"></i>Informasi Server</h5>
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            PHP Version
                            <span class="badge bg-secondary">{{ phpversion() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Laravel Version
                            <span class="badge bg-secondary">{{ app()->version() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Server OS
                            <span class="text-muted">{{ php_uname('s') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Database
                            <span class="text-muted">{{ env('DB_CONNECTION') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
