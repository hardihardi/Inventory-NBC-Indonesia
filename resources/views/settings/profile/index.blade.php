@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Profile Overview Card -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div class="bg-primary py-5"></div>
                <div class="card-body text-center mt-n5">
                    <div class="position-relative d-inline-block mt-n4">
                        @if($user->image)
                            <img src="{{ Storage::url($user->image) }}" alt="{{ $user->name }}" class="rounded-circle border border-4 border-white shadow" width="120" height="120" style="object-fit: cover; margin-top: -60px;">
                        @else
                            <div class="rounded-circle border border-4 border-white shadow bg-light d-flex align-items-center justify-content-center text-primary fw-bold mx-auto" style="width: 120px; height: 120px; font-size: 3rem; margin-top: -60px;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <h4 class="mt-3 mb-1 fw-bold">{{ $user->name }}</h4>
                    <p class="text-muted small mb-3">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</p>
                    
                    <div class="d-flex justify-content-around border-top pt-3 mt-3">
                         <div class="text-center">
                             <div class="fw-bold text-dark">{{ $activities->count() }}</div>
                             <div class="small text-muted">Aktivitas</div>
                         </div>
                         <div class="text-center">
                             <div class="fw-bold text-dark">{{ $user->created_at->diffForHumans(null, true) }}</div>
                             <div class="small text-muted">Bergabung</div>
                         </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-history me-2"></i>Aktivitas Terakhir</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush small">
                        @forelse($activities as $log)
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 fw-bold">{{ $log->action }}</h6>
                                <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-0 text-muted">{{ $log->details }}</p>
                        </div>
                        @empty
                        <div class="p-4 text-center text-muted italic">Belum ada aktivitas.</div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer bg-white text-center py-2">
                    <a href="{{ route('settings.activity-logs.index') }}" class="btn btn-sm btn-link text-decoration-none">Lihat Semua</a>
                </div>
            </div>
        </div>

        <!-- Edit Profile & Password Cards -->
        <div class="col-md-8">
            <!-- Edit Profile -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-user-edit me-2"></i>Edit Informasi Profil</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. Telepon</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Foto Profil</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-danger"><i class="fas fa-key me-2"></i>Ganti Password</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-danger px-4">Ganti Password</button>
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
    .mt-n5 { margin-top: -3rem !important; }
    .mt-n4 { margin-top: -1.5rem !important; }
</style>
@endpush
