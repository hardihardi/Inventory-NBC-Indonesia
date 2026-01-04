@extends('layouts.app')

@section('title', 'Edit Permintaan Material')

@section('content')
<div class="container-fluid">
    {{-- Header & Breadcrumbs --}}
    <div class="row align-items-center mb-4">
        <div class="col-md-7">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('inventory.production.index') }}">Produksi / PPIC</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inventory.production.show', $production) }}">{{ $production->code }}</a></li>
                    <li class="breadcrumb-item active">Edit Rencana</li>
                </ol>
            </nav>
            <h3 class="fw-bold text-dark mb-0">Edit Permintaan Material</h3>
            <p class="text-muted">Perbarui detail rencana atau kebutuhan bahan baku.</p>
        </div>
        <div class="col-md-5 text-md-end">
            <a href="{{ route('inventory.production.show', $production) }}" class="btn btn-light border shadow-sm px-4">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail
            </a>
        </div>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-circle fa-2x me-3"></i>
            <div>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('inventory.production.update', $production->id) }}" method="POST" id="productionForm">
        @csrf
        @method('PUT')
        <div class="row g-4">
            {{-- Form Information Column --}}
            <div class="col-xl-4 col-lg-5">
                <div class="card border-0 shadow-sm h-100 mb-4">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-edit me-2 text-primary"></i>Informasi Rencana Produksi</h6>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <div class="p-3 bg-light rounded-3 mb-4 border border-light-subtle">
                            <label class="form-label small fw-bold text-uppercase text-muted opacity-75 mb-1" style="font-size: 0.65rem;">Kode Permintaan</label>
                            <input type="text" class="form-control bg-white fw-bold border-0 fs-5" name="code" value="{{ $production->code }}" readonly>
                        </div>

                        <div class="mb-4">
                            <label class="form-label required fw-bold text-primary">Produk Hasil (Output)</label>
                            <select class="form-select select2-rich" name="item_id" required>
                                <option value="">--- Pilih Produk Jadi ---</option>
                                @foreach($outputItems as $item)
                                    <option value="{{ $item->id }}" 
                                        {{ $production->item_id == $item->id ? 'selected' : '' }}
                                        data-type="{{ $item->category->type }}"
                                        data-unit="{{ $item->unit->short_name ?? $item->unit->name }}"
                                        data-stock="{{ number_format($item->stock, 2, ',', '.') }}"
                                        data-spec="{{ $item->technical_spec }}"
                                        data-composition="{{ $item->composition }}"
                                        data-variant="{{ $item->gsm ? $item->gsm . 'gsm' : '' }} {{ $item->width ? $item->width . '"' : '' }}"
                                        data-color="{{ $item->color_name }}"
                                        data-brand="{{ $item->brand }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4 progres-target-container">
                            <label class="form-label required fw-bold">Target Jumlah Output</label>
                            <div class="input-group input-group-lg">
                                <input type="number" class="form-control fw-bold border-end-0" name="qty_planned" min="1" step="0.01" value="{{ $production->qty_planned }}" required placeholder="0">
                                <span class="input-group-text bg-white fw-bold text-primary border-start-0" id="output-unit-label">{{ $production->item->unit->short_name ?? 'UNIT' }}</span>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label required fw-bold">Tgl Mulai Rencana</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted border-end-0"><i class="fas fa-calendar-day"></i></span>
                                    <input type="date" class="form-control border-start-0" name="start_date" value="{{ $production->start_date->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label class="form-label fw-bold">Alokasi Mesin / Jalur</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted border-end-0"><i class="fas fa-microchip"></i></span>
                                    <input type="text" class="form-control border-start-0" name="machine_name" value="{{ $production->machine_name }}" placeholder="Misal: KNIT-12 / FINISH-ALPHA">
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold">Keterangan Tambahan</label>
                            <textarea class="form-control bg-light-subtle" name="notes" rows="4" placeholder="Instruksi khusus atau catatan...">{{ $production->notes }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Material Selection Column --}}
            <div class="col-xl-8 col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-boxes me-2 text-primary"></i>Daftar Kebutuhan Bahan Baku</h6>
                        <button type="button" class="btn btn-primary btn-sm px-3 shadow-sm rounded-pill" id="add-material">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Material
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="materials-table">
                                <thead class="bg-light text-muted small text-uppercase fw-bold">
                                    <tr>
                                        <th class="ps-4 py-3" width="50%">Bahan Baku</th>
                                        <th class="text-center py-3" width="25%">Jumlah Request</th>
                                        <th class="text-center py-3" width="15%">Info Stock</th>
                                        <th class="text-center py-3 pe-4" width="10%">Hapus</th>
                                    </tr>
                                </thead>
                                <tbody id="materials-body">
                                    @foreach($production->materials as $index => $material)
                                    <tr class="material-row">
                                        <td class="ps-4">
                                            <select class="form-select select2-material-rich" name="materials[{{ $index }}][item_id]" required>
                                                <option value="">Cari Material...</option>
                                                @foreach($materialItems as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $material->item_id == $item->id ? 'selected' : '' }}
                                                        data-type="{{ $item->category->type }}"
                                                        data-unit="{{ $item->unit->short_name ?? $item->unit->name }}"
                                                        data-stock-raw="{{ $item->stock }}"
                                                        data-stock="{{ number_format($item->stock, 2, ',', '.') }}"
                                                        data-spec="{{ $item->technical_spec }}"
                                                        data-composition="{{ $item->composition }}"
                                                        data-variant="{{ $item->gsm ? $item->gsm . 'gsm' : '' }} {{ $item->width ? $item->width . '"' : '' }}"
                                                        data-color="{{ $item->color_name }}"
                                                        data-brand="{{ $item->brand }}">
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control text-center fw-bold qty-input" name="materials[{{ $index }}][qty_needed]" step="0.01" value="{{ $material->qty_needed }}" required>
                                                <span class="input-group-text bg-light small material-unit">{{ $material->item->unit->short_name ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="stock-info-container">
                                                <span class="badge bg-light text-muted border stock-badge">Stok: {{ number_format($material->item->stock, 2, ',', '.') }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center pe-4">
                                            <button type="button" class="btn btn-sm btn-outline-danger border-0 remove-row">
                                                <i class="fas fa-trash-alt fa-lg"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div id="empty-msg" class="text-center py-5" style="{{ $production->materials->count() > 0 ? 'display:none' : '' }}">
                            <div class="mb-3"><i class="fas fa-list-check fa-4x text-muted opacity-25"></i></div>
                            <h6 class="text-muted fw-bold">Belum ada material ditambahkan</h6>
                        </div>

                        {{-- Validation Summary/Indicator --}}
                        <div id="stock-summary" class="p-4 bg-light border-top mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-1">Status Ketersediaan Material</h6>
                                    <p class="small text-muted mb-0" id="stock-status-text">Memeriksa ketersediaan stok...</p>
                                </div>
                                <div id="stock-indicator" class="badge bg-secondary px-3 py-2 rounded-pill">CHECKING</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Actions --}}
        <div class="mt-4 pt-3 pb-5 d-flex justify-content-end gap-2">
            <a href="{{ route('inventory.production.show', $production) }}" class="btn btn-link text-decoration-none text-muted">Batal</a>
            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-lg" id="submitBtn">
                <i class="fas fa-save me-2"></i>Update Rencana Produksi
            </button>
        </div>
    </form>
</div>

{{-- Template Row untuk JS --}}
<template id="material-row-template">
    <tr class="material-row animate-fade-in">
        <td class="ps-4">
            <select class="form-select select2-material-rich" required>
                <option value="">Cari Material / Benang / Kimia...</option>
                @foreach($materialItems as $item)
                    <option value="{{ $item->id }}"
                        data-type="{{ $item->category->type }}"
                        data-unit="{{ $item->unit->short_name ?? $item->unit->name }}"
                        data-stock-raw="{{ $item->stock }}"
                        data-stock="{{ number_format($item->stock, 2, ',', '.') }}"
                        data-spec="{{ $item->technical_spec }}"
                        data-composition="{{ $item->composition }}"
                        data-variant="{{ $item->gsm ? $item->gsm . 'gsm' : '' }} {{ $item->width ? $item->width . '"' : '' }}"
                        data-color="{{ $item->color_name }}"
                        data-brand="{{ $item->brand }}">
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
        </td>
        <td>
            <div class="input-group">
                <input type="number" class="form-control text-center fw-bold qty-input" min="0" step="0.01" required placeholder="0.00">
                <span class="input-group-text bg-light small material-unit">-</span>
            </div>
        </td>
        <td class="text-center">
            <div class="stock-info-container">
                <span class="badge bg-light text-muted border stock-badge">Pilih item</span>
            </div>
        </td>
        <td class="text-center pe-4">
            <button type="button" class="btn btn-sm btn-outline-danger border-0 remove-row">
                <i class="fas fa-trash-alt fa-lg"></i>
            </button>
        </td>
    </tr>
</template>

@endsection

@push('styles')
<style>
    .animate-fade-in { animation: fadeIn 0.3s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    
    .select2-container--bootstrap-5 .select2-selection {
        border-radius: 8px;
        border-color: #dee2e6;
        padding-top: 3px;
        padding-bottom: 3px;
    }
    .select2-container--bootstrap-5 .select2-selection--single {
        height: auto !important;
    }
    
    .progres-target-container .input-group-lg > .form-control {
        border-radius: 12px 0 0 12px;
        font-size: 1.5rem;
    }
    .progres-target-container .input-group-lg > .input-group-text {
        border-radius: 0 12px 12px 0;
        font-size: 0.9rem;
    }

    .material-row:hover {
        background-color: rgba(248, 249, 250, 0.5);
    }
    
    .bg-success-soft { background-color: rgba(46, 204, 113, 0.1); color: #2ecc71; }
    .bg-danger-soft { background-color: rgba(231, 76, 60, 0.1); color: #e74c3c; }
    .bg-warning-soft { background-color: rgba(241, 196, 15, 0.1); color: #f39c12; }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        let rowIdx = {{ $production->materials->count() }};

        function formatProduct(repo) {
            if (repo.loading) return repo.text;
            const element = repo.element;
            const comp = $(element).data('composition') || '';
            const variant = $(element).data('variant') || '';
            const stock = $(element).data('stock') || '0';
            const unit = $(element).data('unit') || '';

            return $(`
                <div class="d-flex justify-content-between align-items-center py-1">
                    <div>
                        <div class="fw-bold text-dark" style="font-size: 0.9rem;">${repo.text}</div>
                        <div class="small text-muted mt-1">
                            ${comp ? '<span class="me-2"><i class="fas fa-tag me-1"></i>'+comp+'</span>' : ''}
                            ${variant ? '<span><i class="fas fa-layer-group me-1"></i>'+variant+'</span>' : ''}
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="badge bg-light text-dark border p-2">Stok: ${stock} ${unit}</div>
                    </div>
                </div>
            `);
        }

        function initRichSelect2(selector) {
            $(selector).select2({
                theme: 'bootstrap-5',
                placeholder: 'Cari material...',
                templateResult: formatProduct,
                templateSelection: function(repo) {
                    if (!repo.id) return repo.text;
                    return repo.text;
                }
            });
        }

        // Initialize Existing Select2
        initRichSelect2('.select2-material-rich');
        $('.select2-rich').select2({
            theme: 'bootstrap-5',
            templateResult: formatProduct
        }).on('select2:select', function(e) {
            const unit = $(e.params.data.element).data('unit');
            $('#output-unit-label').text(unit || 'UNIT');
        });

        function validateStock() {
            let hasShortage = false;
            let totalRows = $('.material-row').length;
            
            if (totalRows === 0) {
                $('#stock-summary').fadeOut();
                return;
            }

            $('.material-row').each(function() {
                const row = $(this);
                const select = row.find('.select2-material-rich');
                const qtyInput = row.find('.qty-input');
                const badge = row.find('.stock-badge');
                
                const selected = select.select2('data')[0];
                if (!selected || !selected.id) return;

                const stockRaw = parseFloat($(selected.element).data('stock-raw')) || 0;
                const qtyNeeded = parseFloat(qtyInput.val()) || 0;

                if (qtyNeeded > stockRaw) {
                    badge.removeClass('bg-light bg-success-soft text-muted text-success').addClass('bg-danger-soft text-danger');
                    badge.html(`<i class="fas fa-exclamation-triangle me-1"></i> KURANG`);
                    hasShortage = true;
                } else if (qtyNeeded > 0) {
                    badge.removeClass('bg-light bg-danger-soft text-muted text-danger').addClass('bg-success-soft text-success');
                    badge.html(`<i class="fas fa-check-circle me-1"></i> TERSEDIA`);
                } else {
                    badge.removeClass('bg-success-soft bg-danger-soft text-success text-danger').addClass('bg-light text-muted');
                    badge.html(`Stok: ${stockRaw}`);
                }
            });

            $('#stock-summary').fadeIn();
            if (hasShortage) {
                $('#stock-indicator').removeClass('bg-success bg-secondary').addClass('bg-warning');
                $('#stock-indicator').html('<i class="fas fa-exclamation-circle me-1"></i> KURANG STOK');
                $('#stock-status-text').text('Beberapa material tidak mencukupi stok gudang saat ini.');
            } else {
                $('#stock-indicator').removeClass('bg-warning bg-secondary').addClass('bg-success');
                $('#stock-indicator').html('<i class="fas fa-check-circle me-1"></i> AMAN');
                $('#stock-status-text').text('Semua material terpilih tersedia dalam jumlah yang cukup.');
            }
        }

        function addRow() {
            const template = document.getElementById('material-row-template');
            const clone = template.content.cloneNode(true);
            const tr = $(clone).find('tr');
            
            tr.find('.select2-material-rich').attr('name', `materials[${rowIdx}][item_id]`);
            tr.find('.qty-input').attr('name', `materials[${rowIdx}][qty_needed]`);
            
            $('#materials-body').append(tr);
            $('#empty-msg').hide();
            
            const select = tr.find('.select2-material-rich');
            initRichSelect2(select);
            
            select.on('select2:select', function(e) {
                const unit = $(e.params.data.element).data('unit');
                tr.find('.material-unit').text(unit || '-');
                validateStock();
            });

            tr.find('.qty-input').on('input', validateStock);
            
            rowIdx++;
            validateStock();
            return tr;
        }

        // Attach events to existing rows
        $('.material-row').each(function() {
            const row = $(this);
            row.find('.select2-material-rich').on('select2:select', validateStock);
            row.find('.qty-input').on('input', validateStock);
        });

        // Initial Validation
        validateStock();

        $('#add-material').on('click', addRow);
        
        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').fadeOut(200, function() {
                $(this).remove();
                if ($('#materials-body tr').length === 0) {
                    $('#empty-msg').show();
                }
                validateStock();
            });
        });

        $('#productionForm').on('submit', function(e) {
            const btn = $('#submitBtn');
            btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...').prop('disabled', true);
        });
    });
</script>
@endpush
