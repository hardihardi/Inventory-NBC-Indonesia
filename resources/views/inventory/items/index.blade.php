@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
        <div class="container-fluid">
        {{-- Notifikasi Session --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i><strong>Error:</strong><br>{!! nl2br(e(session('error'))) !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Card Utama --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-boxes me-2"></i>Daftar Produk</h5>
                    <div class="ms-auto d-flex gap-2">
                        @if(Auth::user()->hasPermission('inventory.label'))
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="print-labels-btn">
                            <i class="fas fa-barcode me-2"></i>Cetak Label Terpilih
                        </button>
                        @endif
                        <a href="{{ route('inventory.items.export') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-file-export me-2"></i>Export CSV
                        </a>
                        <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#importCsvModal">
                            <i class="fas fa-file-import me-2"></i>Import CSV
                        </button>
                        @if(Auth::user()->hasPermission('inventory.create'))
                        <a href="{{ route('inventory.items.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-2"></i>Tambah Produk Baru
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- Kontrol Pencarian --}}
                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" class="form-control border-start-0" id="search_input"
                            placeholder="Cari SKU, Nama Produk, Spesifikasi di kategori aktif...">
                    </div>
                </div>

                {{-- Navigasi Tab untuk Kategori Tekstil --}}
                <ul class="nav nav-tabs nav-bordered mb-3" id="categoryTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#yarn-pane">
                            <i class="fas fa-scroll me-1"></i> Benang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#chemical-pane">
                            <i class="fas fa-vial me-1"></i> Kimia
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#dyestuff-pane">
                            <i class="fas fa-palette me-1"></i> Zat Warna
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#fabric-pane">
                            <i class="fas fa-tshirt me-1"></i> Kain
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#sparepart-pane">
                            <i class="fas fa-cog me-1"></i> Sparepart
                        </a>
                    </li>
                    @if($otherItems->isNotEmpty())
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#other-pane">
                            <i class="fas fa-layer-group me-1"></i> Lainnya
                        </a>
                    </li>
                    @endif
                </ul>

                {{-- Konten Tab --}}
                <div class="tab-content" id="categoryTabContent">
                    {{-- PANE TEMPLATE FUNCTION --}}
                    @php
                        function renderTable($items, $id, $extraCols = []) {
                            $isEmpty = $items->isEmpty();
                            echo '<div class="tab-pane fade '.($id == "yarn-pane" ? "show active" : "").'" id="'.$id.'" role="tabpanel">';
                            echo '<div class="table-responsive">';
                            echo '<table class="table table-hover align-middle mb-0 '.($isEmpty ? "is-empty" : "").' table-responsive-stack" id="'.$id.'-table" style="width:100%;">';
                            echo '<thead class="thead-dark bg-light"><tr>';
                            echo '<th class="text-center" width="4%"><input type="checkbox" class="select-all-items"></th>';
                            echo '<th class="text-center" width="5%">No</th>';
                            echo '<th class="text-center" width="10%">Foto</th>';
                            echo '<th>SKU / Kode</th>';
                            echo '<th>Nama Produk</th>';
                            foreach($extraCols as $col) echo '<th>'.$col.'</th>';
                            echo '<th class="text-end">Harga</th>';
                            echo '<th class="text-center">Stok</th>';
                            echo '<th class="text-center">Aksi</th>';
                            echo '</tr></thead><tbody>';
                            
                            foreach($items as $index => $item) {
                                $imagePath = $item->image ? asset('storage/' . $item->image) : asset('assets/img/noproduct.png');
                                echo '<tr>';
                                echo '<td class="text-center"><input type="checkbox" class="item-checkbox" value="'.$item->id.'"></td>';
                                echo '<td data-label="No" class="text-center fw-semibold">'.($index + 1).'</td>';
                                echo '<td data-label="Foto" class="text-center">
                                        <div class="rounded-3 border overflow-hidden mx-auto" style="width: 48px; height: 48px;">
                                            <img src="'.$imagePath.'" class="img-fluid w-100 h-100 object-fit-cover" alt="'.$item->name.'">
                                        </div>
                                      </td>';
                                echo '<td data-label="SKU/Kode"><div class="fw-bold">'.$item->sku.'</div><small class="text-muted">'.$item->product_code.'</small></td>';
                                echo '<td data-label="Nama Produk"><div>'.$item->name.'</div><small class="text-muted d-block text-wrap" style="max-width: 200px;">'.$item->description.'</small></td>';
                                
                                // Dynamic Extra Columns Logic
                                foreach($extraCols as $col) {
                                    $val = '-';
                                    if ($col == 'Komposisi') $val = $item->composition ?: '-';
                                    elseif ($col == 'Spec') $val = $item->technical_spec ?: '-';
                                    elseif ($col == 'GSM') $val = $item->gsm ?: '-';
                                    elseif ($col == 'Lebar') $val = $item->width ?: '-';
                                    elseif ($col == 'Brand') $val = $item->brand ?: '-';
                                    elseif ($col == 'Warna') $val = $item->color_name ?: '-';
                                    
                                    echo '<td data-label="'.$col.'"><span class="small">'.$val.'</span></td>';
                                }
                                
                                echo '<td data-label="Harga" class="text-end text-nowrap">
                                        <div class="fw-bold text-danger" title="Modal">Rp '.number_format((float)($item->purchase_price ?? 0), 0, ',', '.').'</div>
                                        <div class="small fw-semibold text-primary" title="Jual">Rp '.number_format((float)($item->price ?? 0), 0, ',', '.').'</div>
                                      </td>';
                                echo '<td data-label="Stok" class="text-center">
                                        <span class="badge rounded-pill bg-'.($item->stock > 100 ? "success" : ($item->stock > 0 ? "warning" : "danger")).'">'.number_format($item->stock, 0, ',', '.').'</span>
                                        <small class="d-block text-muted">'.($item->unit->short_name ?? $item->unit->name ?? $item->unit ?? '-').'</small>
                                      </td>';
                                echo '<td data-label="Aksi" class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="'.route('inventory.items.show', $item->id).'" class="btn btn-action btn-soft-info" data-bs-toggle="tooltip" title="Detail"><i class="fas fa-eye"></i></a>
                                            
                                            '.(auth()->user()->hasPermission('inventory.edit') ? '
                                            <a href="'.route('inventory.items.edit', $item->id).'" class="btn btn-action btn-soft-warning" data-bs-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                                            ' : '').'
                                            
                                            '.(auth()->user()->hasPermission('inventory.delete') ? '
                                            <form action="'.route('inventory.items.destroy', $item->id).'" method="POST" class="d-inline delete-form">
                                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="button" class="btn btn-action btn-soft-danger delete-btn" data-item-name="'.$item->name.'" data-bs-toggle="tooltip" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            ' : '').'
                                        </div>
                                      </td>';
                                echo '</tr>';
                            }
                            
                            if($isEmpty) {
                                echo '<tr><td colspan="15" class="text-center py-5 border-0">
                                    <div class="empty-state py-4 p-md-5">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="fas fa-boxes fa-3x"></i>
                                        </div>
                                        <h4 class="fw-bold text-dark">Gudang Masih Kosong?</h4>
                                        <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">Belum ada produk yang terdaftar di kategori ini. Mulai dengan menambahkan produk baru atau gunakan fitur Import CSV untuk memindahkan data massal.</p>
                                        <div class="d-flex justify-content-center gap-3">
                                            <a href="'.route('inventory.items.create').'" class="btn btn-primary rounded-pill px-4"><i class="fas fa-plus me-2"></i>Tambah Produk</a>
                                            <a href="'.route('help.index').'#inventory" class="btn btn-outline-secondary rounded-pill px-4">Pelajari Dulu</a>
                                        </div>
                                    </div>
                                </td></tr>';
                            }
                            
                            echo '</tbody></table></div></div>';
                        }
                    @endphp

                    {{-- Render Sections --}}
                    @php 
                        renderTable($yarnItems, 'yarn-pane', ['Komposisi', 'Spec', 'Brand', 'Warna']);
                        renderTable($chemicalItems, 'chemical-pane', ['Brand']);
                        renderTable($dyestuffItems, 'dyestuff-pane', ['Brand']);
                        renderTable($fabricItems, 'fabric-pane', ['Komposisi', 'GSM', 'Lebar', 'Brand', 'Warna']);
                        renderTable($sparepartItems, 'sparepart-pane', ['Brand']);
                        if($otherItems->isNotEmpty())
                            renderTable($otherItems, 'other-pane', []);
                    @endphp

                </div>
            </div>
        </div>
    </div>

    {{-- Modal Batch Cetak Label --}}
    <div class="modal fade" id="printLabelsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white border-0 py-3">
                    <h5 class="modal-title fw-bold"><i class="fas fa-barcode me-2"></i>Batch Cetak Label Produk</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted mb-4 small">Tentukan jumlah label yang ingin dicetak untuk setiap produk terpilih. Gunakan helper untuk mengisi otomatis sesuai stok saat ini.</p>
                    
                    <div class="table-responsive" style="max-height: 400px;">
                        <table class="table table-hover align-middle" id="selected-items-label-table">
                            <thead class="bg-light">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center" width="150">Stok Saat Ini</th>
                                    <th class="text-center" width="200">Jumlah Label</th>
                                </tr>
                            </thead>
                            <tbody id="print-items-list">
                                {{-- Diisi via JS --}}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3 px-4 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" id="fill-qty-stock">
                        <i class="fas fa-magic me-1"></i> Isi sesuai Stok
                    </button>
                    <div>
                        <button type="button" class="btn btn-secondary btn-sm px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary btn-sm px-4 rounded-pill" id="confirm-print-btn">
                            <i class="fas fa-print me-1"></i> Lanjut Cetak
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Import CSV --}}
    <div class="modal fade" id="importCsvModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <form action="{{ route('inventory.items.import_csv') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-info text-white border-0 py-3">
                        <h5 class="modal-title fw-bold"><i class="fas fa-file-import me-2"></i>Import Produk dari CSV</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="alert alert-info small border-0 mb-4 shadow-sm">
                            <div class="d-flex">
                                <i class="fas fa-info-circle me-3 mt-1 fs-5"></i>
                                <div>
                                    <p class="mb-2 fw-bold">Petunjuk Impor:</p>
                                    <ul class="mb-0 ps-3">
                                        <li>Gunakan file CSV dengan header yang sesuai.</li>
                                        <li>Kolom <strong>sku</strong> bersifat unik; jika SKU sudah ada, data produk tersebut akan diperbarui.</li>
                                        <li>Pastikan nama <strong>kategori</strong> dan <strong>satuan</strong> sudah ada di sistem.</li>
                                    </ul>
                                    <a href="{{ route('inventory.items.download_template') }}" class="btn btn-sm btn-info text-white mt-3 rounded-pill px-3">
                                        <i class="fas fa-download me-1"></i> Download Template CSV
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="csv_file" class="form-label fw-semibold">Pilih File CSV</label>
                            <input type="file" name="file" id="csv_file" class="form-control" accept=".csv" required>
                            <div class="form-text mt-2 text-muted italic">Maksimal ukuran file: 2MB</div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0 py-3 px-4">
                        <button type="button" class="btn btn-secondary btn-sm px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info btn-sm px-4 rounded-pill text-white">
                            <i class="fas fa-upload me-1"></i> Proses Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .text-gradient {
            background: linear-gradient(135deg, var(--bs-primary), var(--bs-indigo));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .nav-bordered .nav-link {
            border: none;
            border-bottom: 2px solid transparent;
            color: #6c757d;
            font-weight: 500;
        }

        .nav-bordered .nav-link.active {
            border-bottom-color: var(--bs-primary);
            color: var(--bs-primary);
            background-color: transparent;
        }

        .table th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .badge.rounded-pill {
            padding: 0.4em 0.8em;
            font-size: 0.85rem;
        }

        /* === RESPONSIVE FIXES === */
        @media (max-width: 768px) {
            /* Header buttons stack vertically */
            .card-header .d-flex {
                flex-direction: column;
                align-items: stretch !important;
                gap: 0.75rem;
            }
            .card-header .ms-auto {
                margin-left: 0 !important;
                margin-top: 0.5rem;
            }
            .card-header .d-flex.gap-2 {
                flex-wrap: wrap;
                justify-content: flex-start;
            }
            .card-header .btn {
                flex: 1 1 calc(50% - 0.5rem);
                font-size: 0.75rem;
                padding: 0.5rem 0.75rem;
            }

            /* Scrollable tabs */
            .nav-tabs {
                flex-wrap: nowrap;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            }
            .nav-tabs::-webkit-scrollbar { display: none; }
            .nav-tabs .nav-link {
                white-space: nowrap;
                font-size: 0.8rem;
                padding: 0.5rem 0.75rem;
            }

            /* DataTables pagination */
            .dataTables_info, .dataTables_paginate {
                text-align: center !important;
                margin-top: 0.5rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function () {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            let activeDataTable = null;

            function initDataTable(tableId) {
                if (!tableId || $(`#${tableId}`).hasClass('is-empty')) {
                    if (activeDataTable) { activeDataTable.destroy(); activeDataTable = null; }
                    return;
                }

                if ($.fn.DataTable.isDataTable(`#${tableId}`)) {
                    activeDataTable = $(`#${tableId}`).DataTable();
                    return;
                }

                activeDataTable = $(`#${tableId}`).DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    responsive: true,
                    dom: '<"row"<"col-sm-12"t>><"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                    language: {
                        search: "Cari:", zeroRecords: "Tidak ditemukan data", info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        paginate: { next: "›", previous: "‹" }
                    },
                    columnDefs: [
                        { searchable: false, orderable: false, targets: 0 },
                        { orderable: false, targets: -1 }
                    ]
                });
            }

            function setupTable(paneSelector) {
                const tableId = $(paneSelector).find('table').attr('id');
                if (activeDataTable) activeDataTable.destroy();
                initDataTable(tableId);
            }

            // Initial setup for active pane
            setupTable('#categoryTabContent .tab-pane.active');

            // Setup on tab change
            $('#categoryTabs a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                setupTable($(e.target).attr('href'));
                $('#search_input').val('').trigger('keyup');
            });

            // Global search
            $('#search_input').on('keyup', function () {
                if (activeDataTable) {
                    activeDataTable.search(this.value).draw();
                }
            });

            // Select All Logic
            $(document).on('change', '.select-all-items', function() {
                const isChecked = $(this).is(':checked');
                $('.item-checkbox').prop('checked', isChecked);
                $('.select-all-items').prop('checked', isChecked); // Sync all select-alls across tabs
            });

            // Print Labels Logic
            $('#print-labels-btn').on('click', function() {
                const selectedItems = [];
                $('.item-checkbox:checked').each(function() {
                    const row = $(this).closest('tr');
                    selectedItems.push({
                        id: $(this).val(),
                        sku: row.find('td[data-label="SKU/Kode"]').text().trim(),
                        name: row.find('td[data-label="Nama Produk"] div').first().text().trim(),
                        stock: row.find('.badge').text().trim()
                    });
                });

                if (selectedItems.length === 0) {
                    Swal.fire('Peringatan', 'Silakan pilih setidaknya satu produk.', 'warning');
                    return;
                }

                // Populate Modal
                let html = '';
                selectedItems.forEach(item => {
                    html += `
                        <tr data-id="${item.id}">
                            <td>
                                <div class="fw-bold text-primary">${item.name}</div>
                                <small class="text-muted">${item.sku}</small>
                            </td>
                            <td class="text-center"><span class="badge bg-light text-dark border">${item.stock}</span></td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary btn-qty-minus" type="button">-</button>
                                    <input type="number" class="form-control text-center label-qty-input" value="1" min="1">
                                    <button class="btn btn-outline-secondary btn-qty-plus" type="button">+</button>
                                </div>
                            </td>
                        </tr>
                    `;
                });

                $('#print-items-list').html(html);
                $('#printLabelsModal').modal('show');
            });

            // Qty Helpers in Modal
            $(document).on('click', '.btn-qty-plus', function() {
                const input = $(this).closest('.input-group').find('input');
                input.val(parseInt(input.val()) + 1);
            });

            $(document).on('click', '.btn-qty-minus', function() {
                const input = $(this).closest('.input-group').find('input');
                if (parseInt(input.val()) > 1) input.val(parseInt(input.val()) - 1);
            });

            $('#fill-qty-stock').on('click', function() {
                $('#print-items-list tr').each(function() {
                    const stockVal = parseInt($(this).find('.badge').text().replace(/[,.]/g, '')) || 1;
                    $(this).find('.label-qty-input').val(stockVal > 0 ? stockVal : 1);
                });
            });

            // Final Confirmation
            $('#confirm-print-btn').on('click', function() {
                const ids = [];
                const qtys = [];
                
                $('#print-items-list tr').each(function() {
                    ids.push($(this).data('id'));
                    qtys.push($(this).find('.label-qty-input').val());
                });

                const url = "{{ route('inventory.items.print_labels') }}?ids=" + ids.join(',') + "&qtys=" + qtys.join(',');
                window.open(url, '_blank');
                $('#printLabelsModal').modal('hide');
            });

            // AJAX Delete
            $(document).on('click', '.delete-btn', function (e) {
                e.preventDefault();
                const btn = $(this);
                const form = btn.closest('form');
                const itemName = btn.data('item-name');

                Swal.fire({
                    title: 'Anda Yakin?',
                    html: `Menghapus: <b>${itemName}</b>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.attr('action'),
                            type: 'POST',
                            data: form.serialize(),
                            success: function (response) {
                                activeDataTable.row(btn.closest('tr')).remove().draw(false);
                                Swal.fire('Berhasil!', response.success, 'success');
                            },
                            error: function (xhr) {
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