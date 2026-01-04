@extends('layouts.app')

@section('title', '403 - Akses Ditolak')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="row justify-content-center align-items-center" style="min-height: 75vh;">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
            
            {{-- Main Card --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                {{-- Header with gradient --}}
                <div class="card-header text-center py-4 py-md-5 border-0" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                    <div class="mb-3">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white bg-opacity-25 error-icon-wrapper">
                            <i class="fas fa-shield-alt text-white error-icon"></i>
                        </div>
                    </div>
                    <h1 class="text-white mb-0 error-code">403</h1>
                    <p class="text-white-50 mb-0 mt-2 fs-6 fs-md-5">Akses Ditolak</p>
                </div>
                
                {{-- Body --}}
                <div class="card-body p-4 p-md-5 text-center">
                    {{-- Role Badge --}}
                    <div class="mb-4">
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill role-badge">
                            <i class="fas fa-user-shield me-2"></i>
                            Role: <strong>{{ ucfirst(str_replace('_', ' ', Auth::user()->role ?? 'Guest')) }}</strong>
                        </span>
                    </div>
                    
                    {{-- Error Message --}}
                    <div class="alert alert-light border rounded-3 mb-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-exclamation-triangle text-warning me-3 mt-1 flex-shrink-0"></i>
                            <p class="mb-0 text-muted text-start small error-message">
                                {{ $exception->getMessage() ?: 'Role Anda tidak memiliki izin untuk mengakses halaman ini. Silakan hubungi Administrator jika Anda merasa ini adalah kesalahan.' }}
                            </p>
                        </div>
                    </div>
                    
                    {{-- Help Text --}}
                    <p class="text-muted small mb-4 d-none d-md-block">
                        <i class="fas fa-info-circle me-1"></i>
                        Setiap role memiliki hak akses berbeda. Kunjungi Pusat Bantuan untuk informasi lebih lanjut.
                    </p>
                    
                    {{-- Action Buttons - Stack on mobile --}}
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4 rounded-pill order-2 order-md-1">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 rounded-pill order-1 order-md-2">
                            <i class="fas fa-home me-2"></i>Dashboard
                        </a>
                    </div>
                    
                    {{-- Help Link --}}
                    <div class="mt-4 pt-3 border-top">
                        <a href="{{ route('help.index') }}" class="text-decoration-none text-info small">
                            <i class="fas fa-question-circle me-1"></i>Pusat Bantuan
                        </a>
                    </div>
                </div>
            </div>
            
            {{-- Debug Info (only in debug mode) --}}
            @if(config('app.debug'))
            <div class="mt-3 p-3 bg-light rounded-3 text-center">
                <small class="text-muted text-break">
                    <i class="fas fa-bug me-1"></i>
                    <strong>Debug:</strong> {{ request()->url() }}
                </small>
            </div>
            @endif
            
        </div>
    </div>
</div>

<style>
    /* Icon wrapper sizing */
    .error-icon-wrapper {
        width: 80px;
        height: 80px;
    }
    .error-icon {
        font-size: 2.5rem;
    }
    .error-code {
        font-size: 4rem;
        font-weight: 800;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }
    .role-badge {
        font-size: 0.85rem;
    }
    
    /* Pulse animation */
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.9; }
    }
    .error-icon-wrapper {
        animation: pulse 2s ease-in-out infinite;
    }
    
    /* Mobile specific styles */
    @media (max-width: 576px) {
        .error-icon-wrapper {
            width: 60px;
            height: 60px;
        }
        .error-icon {
            font-size: 1.8rem;
        }
        .error-code {
            font-size: 3rem;
        }
        .role-badge {
            font-size: 0.75rem;
        }
        .error-message {
            font-size: 0.8rem !important;
        }
        .card-header {
            padding-top: 1.5rem !important;
            padding-bottom: 1.5rem !important;
        }
        .card-body {
            padding: 1.25rem !important;
        }
        .btn {
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
        }
    }
    
    /* Tablet styles */
    @media (min-width: 577px) and (max-width: 768px) {
        .error-icon-wrapper {
            width: 70px;
            height: 70px;
        }
        .error-icon {
            font-size: 2rem;
        }
        .error-code {
            font-size: 3.5rem;
        }
    }
    
    /* Desktop enhancements */
    @media (min-width: 992px) {
        .error-icon-wrapper {
            width: 100px;
            height: 100px;
        }
        .error-icon {
            font-size: 3rem;
        }
        .error-code {
            font-size: 5rem;
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0,0,0,0.175) !important;
        }
    }
</style>
@endsection
