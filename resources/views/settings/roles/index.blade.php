@extends('layouts.app')

@section('title', 'Kelola Hak Akses')

@section('content')
<div class="container-fluid">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h4 class="fw-bold text-primary mb-1"><i class="fas fa-user-shield me-2"></i>Kelola Hak Akses</h4>
            <p class="text-muted small mb-0">Atur izin akses modul untuk setiap peran (role) pengguna.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <div class="d-flex justify-content-md-end gap-2 mt-3 mt-md-0">
                <div class="input-group search-box" style="width: 250px;">
                    <span class="input-group-text bg-white border-end-0 py-2"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="permission-search" class="form-control border-start-0 py-2" placeholder="Cari izin akses...">
                </div>
                <button type="submit" form="permissions-form" class="btn btn-primary px-4">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
            </div>
        </div>
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

    <div class="card shadow-lg border-0 overflow-hidden" style="border-radius: 1.25rem;">
        <div class="card-body p-0">
            <form action="{{ route('settings.roles.update') }}" method="POST" id="permissions-form">
                @csrf
                @method('PUT')
                
                <div class="table-responsive" style="max-height: 70vh;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="sticky-top bg-white shadow-sm" style="z-index: 10;">
                            <tr class="text-uppercase small fw-bold text-muted border-bottom">
                                <th class="px-4 py-3 bg-white" style="width: 35%; min-width: 250px;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-key me-2 text-primary"></i>
                                            MODUL & IZIN AKSES
                                        </div>
                                    </div>
                                </th>
                                @foreach($roles as $role)
                                    <th class="px-3 text-center bg-white" style="min-width: 150px;">
                                        <div class="mb-2">
                                            @if($role == 'admin') <span class="badge rounded-pill bg-danger shadow-sm">Administrator</span>
                                            @elseif($role == 'procurement') <span class="badge rounded-pill bg-primary shadow-sm">Staff Pengadaan (Procurement)</span>
                                            @elseif($role == 'finance') <span class="badge rounded-pill bg-success shadow-sm">Finance</span>
                                            @elseif($role == 'kepala_gudang') <span class="badge rounded-pill bg-dark shadow-sm">Kepala Gudang</span>
                                            @elseif($role == 'staff_gudang') <span class="badge rounded-pill bg-info shadow-sm">Staff Gudang</span>
                                            @elseif($role == 'produksi') <span class="badge rounded-pill bg-warning text-dark shadow-sm">Bagian Produksi</span>
                                            @else {{ ucfirst($role) }} @endif
                                        </div>
                                        @if($role !== 'admin')
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input check-all-role shadow-none" type="checkbox" data-role="{{ $role }}" title="Pilih Semua Untuk Role Ini" style="cursor: pointer;">
                                            </div>
                                        @endif
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $group => $perms)
                                @php
                                    $groupIcons = [
                                        'Inventory' => 'fa-boxes',
                                        'Transactions' => 'fa-exchange-alt',
                                        'Production' => 'fa-industry',
                                        'Warehouse' => 'fa-warehouse',
                                        'Finance' => 'fa-file-invoice-dollar',
                                        'Reports' => 'fa-chart-pie',
                                        'Settings' => 'fa-cog',
                                        'Sales' => 'fa-shopping-cart',
                                        'Payment' => 'fa-credit-card',
                                        'Master Data' => 'fa-database',
                                        'Approval' => 'fa-check-circle'
                                    ];
                                    $icon = $groupIcons[$group] ?? 'fa-folder-open';
                                @endphp
                                <tr class="bg-light border-bottom group-header" data-group-name="{{ $group }}">
                                    <td class="px-4 py-3 bg-light">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3">
                                                <i class="fas {{ $icon }} fa-fw"></i>
                                            </div>
                                            <div>
                                                <div class="text-uppercase fw-bold text-dark small mb-0">{{ $group }}</div>
                                                <div class="text-muted" style="font-size: 0.65rem;">Kontrol akses modul {{ strtolower($group) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    @foreach($roles as $role)
                                        <td class="text-center bg-light">
                                            @if($role !== 'admin')
                                                <button type="button" class="btn btn-xs btn-outline-primary toggle-role-group" 
                                                        data-role="{{ $role }}" data-group="{{ Str::slug($group) }}"
                                                        data-bs-toggle="tooltip"
                                                        title="Check/Uncheck Module {{ $group }} untuk {{ $role }}">
                                                    <i class="fas fa-check-double"></i>
                                                </button>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                @foreach($perms as $perm)
                                    <tr class="permission-row-item transition-all" data-search="{{ strtolower($perm->description . ' ' . $perm->name) }}" data-perm-id="{{ $perm->id }}">
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex flex-column">
                                                    <span class="fw-medium text-dark">{{ $perm->description }}</span>
                                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $perm->name }}</small>
                                                </div>
                                                <button type="button" class="btn btn-xs btn-outline-info toggle-row-perms me-1" 
                                                        data-perm-id="{{ $perm->id }}"
                                                        data-bs-toggle="tooltip" 
                                                        title="Check/Uncheck baris ini untuk semua Role (kecuali Admin)">
                                                    <i class="fas fa-arrows-alt-h"></i>
                                                </button>
                                            </div>
                                        </td>
                                        @foreach($roles as $role)
                                            <td class="text-center px-3">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input perm-checkbox shadow-none role-{{ $role }} group-{{ Str::slug($group) }}" 
                                                           type="checkbox" 
                                                           name="permissions[{{ $role }}][{{ $perm->id }}]" 
                                                           value="1" 
                                                           @if(in_array($perm->id, $rolePermissions[$role] ?? [])) checked @endif
                                                           @if($role === 'admin') disabled checked @endif>
                                                    @if($role === 'admin')
                                                        <input type="hidden" name="permissions[{{ $role }}][{{ $perm->id }}]" value="1">
                                                    @endif
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        <div class="card-footer bg-white py-4 border-top">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i> Perubahan akan segera aktif setelah disimpan. Admin memiliki akses penuh secara default.
                </div>
                <button type="submit" form="permissions-form" class="btn btn-primary px-5 py-2 fw-bold shadow-lg" style="border-radius: 2rem; background: linear-gradient(135deg, #6366f1, #a855f7); border: none;">
                    <i class="fas fa-save me-2"></i>SIMPAN PERUBAHAN
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-soft-light { background-color: rgba(243, 244, 246, 0.4); }
    .transition-all { transition: all 0.2s ease-in-out; }
    .table-hover tbody tr.permission-row-item:hover { background-color: rgba(99, 102, 241, 0.04) !important; }
    .form-check-input { cursor: pointer; width: 1.15em; height: 1.15em; border-radius: 4px; }
    .form-check-input:checked { background-color: #6366f1; border-color: #6366f1; }
    .btn-xs { padding: 0.15rem 0.3rem; font-size: 0.65rem; border-radius: 0.2rem; }
    .search-box .form-control:focus { border-color: #dee2e6; box-shadow: none; }
    .sticky-top { top: -1px; }
    .group-header { border-left: 4px solid #6366f1; }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Search Functionality
    $('#permission-search').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $('.permission-row-item').each(function() {
            const text = $(this).data('search');
            $(this).toggle(text.indexOf(value) > -1);
        });

        // Hide group headers if all items below are hidden
        $('.group-header').each(function() {
            const groupName = $(this).data('group-name');
            const visibleItems = $(this).nextUntil('.group-header').filter('.permission-row-item').filter(':visible').length;
            $(this).toggle(visibleItems > 0);
        });
    });

    // Function to update indeterminate states
    function updateIndeterminateStates() {
        $('.check-all-role').each(function() {
            const role = $(this).data('role');
            const checkboxes = $(`.perm-checkbox.role-${role}`).not(':disabled');
            const checkedCount = checkboxes.filter(':checked').length;
            const totalCount = checkboxes.length;

            if (checkedCount === 0) {
                $(this).prop('checked', false);
                $(this).prop('indeterminate', false);
            } else if (checkedCount === totalCount) {
                $(this).prop('checked', true);
                $(this).prop('indeterminate', false);
            } else {
                $(this).prop('checked', false);
                $(this).prop('indeterminate', true);
            }
        });

        // Update Toggle Role Group button states
        $('.toggle-role-group').each(function() {
            const role = $(this).data('role');
            const group = $(this).data('group');
            const checkboxes = $(`.perm-checkbox.role-${role}.group-${group}`).not(':disabled');
            const checkedCount = checkboxes.filter(':checked').length;
            const totalCount = checkboxes.length;

            if (checkedCount === totalCount && totalCount > 0) {
                $(this).removeClass('btn-outline-primary').addClass('btn-primary');
            } else if (checkedCount > 0) {
                $(this).removeClass('btn-outline-primary').addClass('btn-warning text-dark');
            } else {
                $(this).removeClass('btn-primary btn-warning text-dark').addClass('btn-outline-primary');
            }
        });
    }

    // Run initial state update
    updateIndeterminateStates();

    // Re-run state update whenever a checkbox changes
    $('.perm-checkbox').on('change', function() {
        updateIndeterminateStates();
    });

    // Check All per Role (Column)
    $('.check-all-role').on('change', function() {
        const role = $(this).data('role');
        const isChecked = $(this).is(':checked');
        $(`.perm-checkbox.role-${role}`).not(':disabled').prop('checked', isChecked);
        updateIndeterminateStates();
    });

    // Toggle Role in specific Group (Cell header toggle)
    $('.toggle-role-group').on('click', function() {
        const role = $(this).data('role');
        const group = $(this).data('group');
        const checkboxes = $(`.perm-checkbox.role-${role}.group-${group}`).not(':disabled');
        
        // If all are checked, uncheck all. Otherwise, check all.
        const allChecked = checkboxes.filter(':not(:checked)').length === 0;
        checkboxes.prop('checked', !allChecked);
        updateIndeterminateStates();
    });

    // Toggle per Row (Row toggle)
    $('.toggle-row-perms').on('click', function() {
        const permId = $(this).data('perm-id');
        const checkboxes = $(this).closest('tr').find('.perm-checkbox').not(':disabled');
        
        // If any are unchecked, check all. Else, uncheck all.
        const anyUnchecked = checkboxes.filter(':not(:checked)').length > 0;
        checkboxes.prop('checked', anyUnchecked);
        updateIndeterminateStates();
    });

    // Confirmation on Submit
    $('#permissions-form').on('submit', function(e) {
        e.preventDefault();
        const form = this;
        
        Swal.fire({
            title: 'Simpan Perubahan?',
            text: "Hak akses pengguna akan segera diperbarui sesuai pilihan Anda.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6366f1',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush
