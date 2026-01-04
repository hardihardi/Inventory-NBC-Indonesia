@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold text-gradient"><i class="fas fa-users me-2"></i>Manajemen User</h4>
        @if(Auth::user()->hasPermission('settings.users'))
        <a href="{{ route('settings.users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-2"></i>Tambah User
        </a>
        @endif
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

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="users-table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Terdaftar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-3">
                                        @if($user->image)
                                            <img src="{{ Storage::url($user->image) }}" alt="{{ $user->name }}" 
                                                 class="rounded-circle shadow-sm border border-2 border-white" 
                                                 width="45" height="45" style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-soft-primary d-flex align-items-center justify-content-center text-primary fw-bold shadow-sm" style="width: 45px; height: 45px; font-size: 16px;">
                                                {{ strtoupper(substr($user->name, 0, 1)) . strtoupper(substr(strstr($user->name, ' ') ?: $user->name, 1, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $user->name }}</div>
                                        <div class="small text-muted">{{ $user->phone ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @php
                                    $roleData = match($user->role) {
                                        'admin' => ['color' => 'danger', 'name' => 'Administrator (Super Admin)'],
                                        'procurement' => ['color' => 'primary', 'name' => 'Staff Pengadaan (Procurement)'],
                                        'finance' => ['color' => 'success', 'name' => 'Finance'],
                                        'kepala_gudang' => ['color' => 'dark', 'name' => 'Kepala Gudang (Supervisor)'],
                                        'staff_gudang' => ['color' => 'info', 'name' => 'Staff Gudang / Operator Gudang'],
                                        'produksi' => ['color' => 'warning', 'name' => 'Bagian Produksi / PPIC'],
                                        default => ['color' => 'secondary', 'name' => ucfirst($user->role)]
                                    };
                                @endphp
                                <span class="badge bg-{{ $roleData['color'] }}">{{ $roleData['name'] }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ $user->status == 'active' ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    @if(Auth::user()->hasPermission('settings.users'))
                                        <a href="{{ route('settings.users.edit', $user->id) }}" class="btn btn-action btn-soft-warning" data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-action btn-soft-danger delete-btn" 
                                                data-url="{{ route('settings.users.destroy', $user->id) }}"
                                                data-name="{{ $user->name }}" 
                                                data-bs-toggle="tooltip" title="Hapus"
                                                {{ Auth::id() === $user->id ? 'disabled' : '' }}>
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data user.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#users-table').DataTable();
        
        $('.delete-btn').on('click', function() {
            const btn = $(this);
            const name = btn.data('name');
            const url = btn.data('url');
            
            Swal.fire({
                title: 'Hapus User?',
                html: `Yakin ingin menghapus user <b>${name}</b>? Tindakan ini tidak dapat dibatalkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
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
                            Swal.fire('Berhasil!', response.success, 'success');
                        },
                        error: function(xhr) {
                            let msg = 'Terjadi kesalahan.';
                            if (xhr.responseJSON && xhr.responseJSON.error) msg = xhr.responseJSON.error;
                            Swal.fire('Gagal!', msg, 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
