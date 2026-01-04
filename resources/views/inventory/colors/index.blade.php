@extends('layouts.app')

@section('title', 'Master Warna')

@section('content')
    <div class="container-fluid">
        {{-- Notification --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-palette me-2"></i>Master Warna</h5>
                    <a href="{{ route('inventory.colors.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Warna
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-responsive-stack" id="colors-table">
                        <thead class="thead-dark bg-light">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="10%" class="text-center">Pratinjau</th>
                                <th>Nama Warna</th>
                                <th>Kode Hex</th>
                                <th>Keterangan</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($colors as $color)
                                <tr class="animate-fade">
                                    <td data-label="No" class="text-center">{{ $loop->iteration }}</td>
                                    <td data-label="Pratinjau" class="text-center">
                                        <div class="rounded-circle shadow-sm border mx-auto" 
                                             style="width: 30px; height: 30px; background-color: {{ $color->hex_code ?: '#fff' }};"
                                             title="{{ $color->hex_code }}"></div>
                                    </td>
                                    <td data-label="Nama Warna" class="fw-bold">{{ $color->name }}</td>
                                    <td data-label="Kode Hex"><code>{{ $color->hex_code ?: '-' }}</code></td>
                                    <td data-label="Keterangan">{{ $color->description ?: '-' }}</td>
                                    <td data-label="Aksi" class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('inventory.colors.edit', $color->id) }}" class="btn btn-action btn-soft-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-action btn-soft-danger delete-btn" 
                                                    data-id="{{ $color->id }}" 
                                                    data-name="{{ $color->name }}"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#colors-table').DataTable({
                responsive: true,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                }
            });

            $(document).on('click', '.delete-btn', function () {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let url = "{{ route('inventory.colors.destroy', ':id') }}".replace(':id', id);

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Warna '" + name + "' akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
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
                            success: function (response) {
                                Swal.fire('Terhapus!', response.success, 'success').then(() => {
                                    location.reload();
                                });
                            },
                            error: function (xhr) {
                                Swal.fire('Gagal!', xhr.responseJSON.error, 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
