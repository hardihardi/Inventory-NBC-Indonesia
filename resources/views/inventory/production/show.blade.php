@extends('layouts.app')

@section('title', 'Detail Permintaan Material - ' . $production->code)

@section('content')
<div class="container-fluid">
    {{-- Header Content --}}
    <div class="row align-items-center mb-4">
        <div class="col-md-7">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('inventory.production.index') }}">Produksi / PPIC</a></li>
                    <li class="breadcrumb-item active">{{ $production->code }}</li>
                </ol>
            </nav>
            <h3 class="fw-bold text-dark mb-0">Permintaan Material #{{ $production->code }}</h3>
            <p class="text-muted">PIC: <span class="fw-medium">{{ $production->user->name ?? '-' }}</span> • Dibuat: {{ $production->created_at->format('d M Y, H:i') }}</p>
        </div>
        <div class="col-md-5 text-md-end d-flex gap-2 justify-content-md-end align-items-center">
            @if($production->status == 'planned' && Auth::user()->hasPermission('production.edit'))
            <a href="{{ route('inventory.production.edit', $production->id) }}" class="btn btn-outline-warning">
                <i class="fas fa-edit me-2"></i>Edit Rencana
            </a>
            @endif
            <a href="{{ route('inventory.production.index') }}" class="btn btn-light border shadow-sm px-4">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle fa-2x me-3"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
            <div>{{ session('error') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row g-4">
        {{-- Main Content Column --}}
        <div class="col-xl-8">
            
            {{-- Workflow Card --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-tasks me-2 text-primary"></i>Workflow Monitoring</h6>
                        @php
                            $statusStyle = match($production->status) {
                                'planned' => 'secondary text-dark border',
                                'approved' => 'info text-white',
                                'ready' => 'warning text-dark',
                                'in_progress' => 'primary text-white',
                                'completed' => 'success text-white',
                                'cancelled' => 'danger text-white',
                                default => 'light text-muted border'
                            };
                            $statusLabel = match($production->status) {
                                'planned' => 'MENUNGGU APPROVAL',
                                'approved' => 'DISETUJUI / DISIAPKAN',
                                'ready' => 'SIAP DIAMBIL',
                                'in_progress' => 'DALAM PRODUKSI',
                                'completed' => 'SELESAI',
                                'cancelled' => 'DIBATALKAN',
                                default => strtoupper($production->status)
                            };
                        @endphp
                        <span class="badge bg-{{ $statusStyle }} px-3 py-2 rounded-pill shadow-sm">
                            {{ $statusLabel }}
                        </span>
                    </div>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="workflow-container mt-3">
                        <ul class="row list-unstyled workflow-steps g-0">
                            <li class="col workflow-step {{ in_array($production->status, ['planned', 'approved', 'ready', 'in_progress', 'completed']) ? 'completed' : '' }}">
                                <span class="step-num">1</span>
                                <span class="step-icon"><i class="fas fa-file-contract"></i></span>
                                <span class="step-text">Rencana</span>
                            </li>
                            <li class="col workflow-step {{ in_array($production->status, ['approved', 'ready', 'in_progress', 'completed']) ? 'completed' : '' }}">
                                <span class="step-num">2</span>
                                <span class="step-icon"><i class="fas fa-user-check"></i></span>
                                <span class="step-text">Approval</span>
                            </li>
                            <li class="col workflow-step {{ in_array($production->status, ['ready', 'in_progress', 'completed']) ? 'completed' : '' }}">
                                <span class="step-num">3</span>
                                <span class="step-icon"><i class="fas fa-box-open"></i></span>
                                <span class="step-text">Ready</span>
                            </li>
                            <li class="col workflow-step {{ in_array($production->status, ['in_progress', 'completed']) ? 'completed' : '' }}">
                                <span class="step-num">4</span>
                                <span class="step-icon"><i class="fas fa-tools"></i></span>
                                <span class="step-text">Produksi</span>
                            </li>
                            <li class="col workflow-step {{ $production->status == 'completed' ? 'completed' : '' }}">
                                <span class="step-num">5</span>
                                <span class="step-icon"><i class="fas fa-flag-checkered"></i></span>
                                <span class="step-text">Selesai</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Dynamic Interaction Panel based on Status --}}
                    <div class="action-panel mt-4 p-3 bg-light rounded-3 border border-light-subtle">
                        @if($production->status == 'planned')
                            @if(Auth::user()->hasPermission('production.approve'))
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-circle bg-warning text-white me-3"><i class="fas fa-shield-alt"></i></div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">Verifikasi & Persetujuan</h6>
                                        <p class="small text-muted mb-0">Periksa detail bahan baku di bawah sebelum menyetujui permintaan.</p>
                                    </div>
                                </div>
                                <form action="{{ route('inventory.production.update', $production->id) }}" method="POST" class="d-flex gap-2 mt-2">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="action" value="approve" class="btn btn-success flex-grow-1 shadow-sm py-2">
                                        <i class="fas fa-check-circle me-2"></i>Setujui Sekarang
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-cancel-request">
                                        <i class="fas fa-times-circle me-2"></i>Tolak Rencana
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-soft-info border-0 mb-0 d-flex align-items-center">
                                    <i class="fas fa-info-circle fa-lg me-3 text-info"></i>
                                    <div>Menunggu pemeriksaan dan persetujuan dari <strong>Kepala Gudang / Supervisor</strong>.</div>
                                </div>
                            @endif
                        @endif

                        @if($production->status == 'approved')
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-info text-white me-3 animate-pulse"><i class="fas fa-box"></i></div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-info">Persiapan Barang</h6>
                                        <p class="small text-muted mb-0">Tim Gudang sedang menyiapkan material sesuai daftar permintaan.</p>
                                    </div>
                                </div>
                                @if(Auth::user()->hasPermission('production.edit'))
                                <form action="{{ route('inventory.production.update', $production->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="action" value="mark_ready" class="btn btn-info text-white px-4 shadow-sm">
                                        <i class="fas fa-check me-2"></i>Material SIAP DIAMBIL
                                    </button>
                                </form>
                                @endif
                            </div>
                        @endif

                        @if($production->status == 'ready')
                            <div class="text-center py-2">
                                <div class="text-success mb-2"><i class="fas fa-check-circle fa-2x"></i></div>
                                <h6 class="fw-bold fs-5 mb-1">Material Siap Diserahterimakan!</h6>
                                <p class="text-muted small mb-3 px-md-5">Tekan tombol di bawah saat material sudah diterima oleh bagian produksi untuk memulai perhitungan stok keluar.</p>
                                
                                <form action="{{ route('inventory.production.update', $production->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="action" value="start" class="btn btn-primary btn-lg px-5 shadow rounded-pill">
                                        <i class="fas fa-play-circle me-2"></i>Mulai Proses Produksi
                                    </button>
                                </form>
                            </div>
                        @endif

                        @if($production->status == 'in_progress')
                            <div class="bg-white p-3 rounded shadow-xs border">
                                <h6 class="fw-bold mb-3 d-flex align-items-center">
                                    <i class="fas fa-clipboard-check text-warning me-2"></i>Update Progress Realisasi
                                </h6>
                                <form action="{{ route('inventory.production.update', $production->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="action" value="update_usage">
                                    
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-12">
                                            <div class="p-2 bg-light bg-opacity-75 rounded border-start border-4 border-warning">
                                                <label class="form-label fw-bold mb-1 small text-muted text-uppercase">Prediksi Hasil ({{ $production->item->name }})</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" name="qty_actual" value="{{ $production->qty_actual ?? $production->qty_planned }}" min="0">
                                                    <span class="input-group-text">{{ $production->item->unit->name ?? 'item' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-muted text-uppercase mb-2">Penyesuaian Pemakaian Material</label>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-modern align-middle mb-0" style="font-size: 0.85rem;">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th>Bahan Baku</th>
                                                        <th class="text-center">Rencana</th>
                                                        <th class="text-center" width="180">Aktual Dipakai</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($production->materials as $mat)
                                                    <tr>
                                                        <td class="fw-medium text-dark">{{ $mat->item->name }}</td>
                                                        <td class="text-center text-muted">{{ $mat->qty_needed }} {{ $mat->item->unit->name ?? '' }}</td>
                                                        <td class="text-center">
                                                            <div class="input-group input-group-sm">
                                                                <input type="number" class="form-control text-center" 
                                                                       name="materials[{{ $mat->id }}]" 
                                                                       value="{{ $mat->qty_used > 0 ? $mat->qty_used : $mat->qty_needed }}">
                                                                <span class="input-group-text">{{ $mat->item->unit->name ?? '' }}</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-warning flex-grow-1 py-2">
                                            <i class="fas fa-save me-2"></i>Update Progress Sementara
                                        </button>
                                        <button type="button" class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#completeModal">
                                            <i class="fas fa-check-double me-2"></i>Selesai & Tutup Batch
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        @if($production->status == 'completed')
                            <div class="completed-summary py-2 px-1">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0">Hasil Produksi Final</h6>
                                    <a href="#" class="btn btn-link btn-sm text-decoration-none">
                                        <i class="fas fa-print me-1"></i>Cetak Surat Hasil
                                    </a>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div class="card bg-success-soft border-0 text-center py-3">
                                            <div class="display-6 fw-bold text-success mb-0">{{ number_format($production->qty_actual, 0) }}</div>
                                            <div class="text-muted small text-uppercase fw-bold">Yield ({{ $production->item->unit->name ?? 'item' }})</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-danger-soft border-0 text-center py-3">
                                            <div class="display-6 fw-bold text-danger mb-0">{{ number_format($production->waste_qty, 1) }}</div>
                                            <div class="text-muted small text-uppercase fw-bold">Waste / Susut</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-primary-soft border-0 text-center py-3">
                                            @php $efficiency = $production->qty_planned > 0 ? ($production->qty_actual / $production->qty_planned) * 100 : 0; @endphp
                                            <div class="display-6 fw-bold text-primary mb-0">{{ number_format($efficiency, 1) }}%</div>
                                            <div class="text-muted small text-uppercase fw-bold">Efisiensi</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-dark bg-opacity-10 border-0 text-center py-3">
                                            <div class="fw-bold fs-5 text-dark mb-0">Rp{{ number_format($production->total_cost, 0, ',', '.') }}</div>
                                            <div class="text-muted small text-uppercase fw-bold">Total Biaya Baku</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Material Details Table --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-microchip me-2 text-primary"></i>Daftar Rincian Bahan Baku</h6>
                    @if($production->status == 'planned')
                    <span class="badge bg-light text-muted border py-2 px-3">Status ketersediaan stok saat ini</span>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4 py-3">Nama Barang</th>
                                    <th class="text-center py-3">Request</th>
                                    <th class="text-center py-3">Stock Saat Ini</th>
                                    <th class="text-center py-3">Status</th>
                                    <th class="text-center py-3" width="100">Info</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($production->materials as $mat)
                                    @php
                                        $currentStock = $mat->item->stock ?? 0;
                                        $isShortage = $currentStock < $mat->qty_needed;
                                    @endphp
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="p-1 bg-white border rounded shadow-xs me-3 overflow-hidden" style="width: 40px; height: 40px;">
                                                    @if($mat->item->image)
                                                        <img src="{{ asset('storage/' . $mat->item->image) }}" class="img-fluid h-100 w-100 object-fit-cover" alt="Pic">
                                                    @else
                                                        <div class="h-100 w-100 d-flex align-items-center justify-content-center bg-light text-muted" style="font-size: 0.7rem;">
                                                            <i class="fas fa-image"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $mat->item->name }}</div>
                                                    <div class="small text-muted">SKU: {{ $mat->item->sku ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center fw-medium">
                                            <span class="fs-6">{{ $mat->qty_needed }}</span> 
                                            <span class="small text-muted ms-1">{{ $mat->item->unit->name ?? '' }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold {{ $isShortage ? 'text-danger' : 'text-success' }}">
                                                {{ number_format($currentStock, 0) }} {{ $mat->item->unit->name ?? '' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($isShortage)
                                                <span class="badge bg-danger">STOK KURANG</span>
                                            @else
                                                <span class="badge bg-success-soft text-success border border-success border-opacity-25">TERSEDIA</span>
                                            @endif
                                        </td>
                                        <td class="text-center pe-3">
                                            <button class="btn btn-sm btn-light border" data-bs-toggle="collapse" data-bs-target="#stockDetail{{ $mat->id }}">
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="collapse" id="stockDetail{{ $mat->id }}">
                                        <td colspan="5" class="bg-light-subtle p-0">
                                            <div class="p-3 border-top border-bottom">
                                                <h6 class="small fw-bold text-uppercase text-muted mb-2">Sebaran Stok di Gudang</h6>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @forelse($mat->item->warehouseStocks as $ws)
                                                        <div class="p-2 bg-white rounded border shadow-xs d-flex align-items-center">
                                                            <i class="fas fa-warehouse me-2 text-primary small"></i>
                                                            <span class="small fw-medium me-2">{{ $ws->warehouse->name }}:</span>
                                                            <span class="small fw-bold">{{ number_format($ws->stock, 0) }}</span>
                                                        </div>
                                                    @empty
                                                        <span class="small text-muted italic">Tidak ada data stok gudang</span>
                                                    @endforelse
                                                </div>
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

        {{-- Sidebar Column --}}
        <div class="col-xl-4">
            {{-- Target Output Card --}}
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div class="card-header bg-primary text-white py-3 border-0">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-bullseye me-2"></i>Produk Yang Dihasilkan</h6>
                </div>
                <div class="card-body p-0">
                    <div class="p-4 text-center border-bottom bg-light bg-opacity-50">
                        <div class="bg-white mx-auto shadow-sm rounded p-3 mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                             @if($production->item->image)
                                 <img src="{{ asset('storage/' . $production->item->image) }}" class="img-fluid rounded" alt="Product">
                             @else
                                 <i class="fas fa-layer-group fa-2x text-primary opacity-25"></i>
                             @endif
                        </div>
                        <h5 class="fw-bold mb-1 text-dark">{{ $production->item->name }}</h5>
                        <div class="text-muted small text-uppercase fw-bold mb-3">{{ $production->item->category->name ?? 'Kategori Umum' }}</div>
                        <div class="d-flex justify-content-center gap-2">
                            <div class="bg-white border rounded px-3 py-2 shadow-xs">
                                <div class="text-muted small" style="font-size: 0.65rem;">TARGET RENCANA</div>
                                <div class="fw-bold fs-5">{{ number_format($production->qty_planned, 0) }} <span class="small text-muted">{{ $production->item->unit->name ?? 'item' }}</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 bg-white">
                        <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                            <span class="text-muted small">Tgl Mulai</span>
                            <span class="fw-bold small">{{ $production->start_date->format('d M Y') }}</span>
                        </div>
                        @if($production->machine_name)
                        <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                            <span class="text-muted small">Mesin / Line</span>
                            <span class="fw-bold small text-primary">{{ $production->machine_name }}</span>
                        </div>
                        @endif
                        @if($production->batch_number)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Batch Code</span>
                            <span class="badge bg-light text-dark border fw-bold">{{ $production->batch_number }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Notes & Logs --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-0 fw-bold small text-uppercase text-muted">Aktivitas & Catatan</div>
                <div class="card-body p-4 pt-0">
                    @if($production->notes)
                        <div class="p-3 bg-light rounded-3 border-start border-4 border-info mb-4">
                            <h6 class="small fw-bold mb-2">CATATAN PPIC:</h6>
                            <p class="small text-dark mb-0 italic">"{{ $production->notes }}"</p>
                        </div>
                    @endif
                    
                    @php
                        $auditLog = \App\Models\ActivityLog::where('description', 'like', '%'.$production->code.'%')
                                    ->latest()->limit(5)->get();
                    @endphp
                    
                    @if($auditLog->count() > 0)
                    <div class="audit-timeline">
                        @foreach($auditLog as $log)
                        <div class="timeline-item pb-3 border-start ps-3 position-relative">
                            <div class="dot"></div>
                            <div class="small fw-bold mb-0 text-dark">{{ $log->activity }}</div>
                            <div class="small text-muted opacity-75">{{ $log->created_at->diffForHumans() }} oleh {{ $log->user->name ?? 'System' }}</div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-3 text-muted">
                        <i class="fas fa-history d-block mb-2 opacity-25 fa-2x"></i>
                        <div class="small italic">Histori aktivitas belum tersedia</div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Danger Zone --}}
            @if(in_array($production->status, ['planned', 'approved', 'ready']))
            <div class="card border-danger border-opacity-10 bg-danger bg-opacity-10">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-danger mb-2">Danger Zone</h6>
                    <p class="small text-danger opacity-75 mb-3">Batalkan permintaan ini hanya jika rencana produksi ditiadakan atau data salah input.</p>
                    
                    <form action="{{ route('inventory.production.update', $production->id) }}" method="POST" id="cancelRequestForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="action" value="cancel">
                        <button type="button" class="btn btn-outline-danger w-100 btn-cancel-request">
                            <i class="fas fa-times me-2"></i>Batalkan Permintaan
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- MODAL: Selesaikan Produksi --}}
<div class="modal fade" id="completeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-success text-white py-3">
        <h5 class="modal-title fw-bold"><i class="fas fa-check-circle me-2"></i>Konfirmasi Final & Gudang</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('inventory.production.complete', $production->id) }}" method="POST">
        @csrf
        <div class="modal-body p-4">
          <div class="text-center mb-4">
              <h4 class="fw-bold text-dark mb-1">Batch Selesai?</h4>
              <p class="text-muted small">Data stok akan diproses secara real-time saat Anda konfirmasi.</p>
          </div>

          <div class="row g-3 mb-4">
              <div class="col-6">
                  <div class="p-3 bg-light rounded text-center border">
                      <label class="form-label fw-bold small text-muted text-uppercase mb-1">Hasil Akhir</label>
                      <div class="input-group">
                          <input type="number" class="form-control text-center fw-bold fs-5" name="qty_actual" value="{{ $production->qty_actual ?? $production->qty_planned }}" required>
                      </div>
                      <div class="small text-muted mt-1">{{ $production->item->unit->name ?? 'item' }}</div>
                  </div>
              </div>
              <div class="col-6">
                  <div class="p-3 bg-light rounded text-center border">
                      <label class="form-label fw-bold small text-muted text-uppercase mb-1">Waste / Susut</label>
                      <div class="input-group">
                          <input type="number" class="form-control text-center fw-bold fs-5" name="waste_qty" value="0" step="0.1">
                      </div>
                      <div class="small text-muted mt-1">{{ $production->item->unit->name ?? 'item' }}</div>
                  </div>
              </div>
          </div>

          <div class="mb-3">
              <label class="form-label fw-bold title-card-tiny mb-1">Alasan Penurunan/Waste</label>
              <input type="text" class="form-control" name="waste_reason" placeholder="Contoh: Kotor, sambungan kain, dll">
          </div>
          
          <div class="mb-3">
              <label class="form-label fw-bold title-card-tiny mb-1">Gunakan Mesin / Jalur</label>
              <input type="text" class="form-control" name="machine_name" value="{{ $production->machine_name }}" placeholder="Contoh: KNIT-12 / FINISH-01">
          </div>

          <div class="alert alert-warning border-0 p-3 small mb-0 rounded-3">
              <div class="d-flex">
                  <i class="fas fa-exclamation-triangle mt-1 me-3"></i>
                  <div>
                      <strong class="d-block mb-1">PENTING:</strong>
                      <ul class="ps-3 mb-0">
                          <li>Stok barang baku akan berkurang otomatis.</li>
                          <li>Stok kain hasil ({{ $production->item->name }}) akan bertambah.</li>
                          <li>Batch #{{ $production->code }} akan dikunci dari pengeditan.</li>
                      </ul>
                  </div>
              </div>
          </div>
        </div>
        <div class="modal-footer border-0 p-4 pt-0">
          <button type="button" class="btn btn-light border flex-grow-1" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-success flex-grow-1 px-4 py-2 fw-bold">PROSES DATA & SELESAI</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('styles')
<style>
    .workflow-steps {
        position: relative;
        text-align: center;
    }
    .workflow-steps::after {
        content: '';
        position: absolute;
        top: 30px;
        left: 5%;
        right: 5%;
        height: 3px;
        background: #e9ecef;
        z-index: 0;
    }
    .workflow-step {
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
    }
    .step-num {
        display: block;
        width: 24px;
        height: 24px;
        background: #fff;
        border: 2px solid #dee2e6;
        border-radius: 50%;
        margin: 0 auto 5px;
        font-size: 0.7rem;
        font-weight: bold;
        line-height: 20px;
        color: #adb5bd;
    }
    .step-icon {
        display: block;
        width: 45px;
        height: 45px;
        background: #fff;
        border: 2px solid #dee2e6;
        border-radius: 50%;
        margin: 0 auto 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: #adb5bd;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .step-text {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #adb5bd;
        letter-spacing: 0.5px;
    }
    .workflow-step.completed .step-num {
        background: #0D47A1;
        border-color: #0D47A1;
        color: #fff;
    }
    .workflow-step.completed .step-icon {
        background: #0D47A1;
        border-color: #0D47A1;
        color: #fff;
        box-shadow: 0 5px 15px rgba(13, 71, 161, 0.25);
        transform: translateY(-5px);
    }
    .workflow-step.completed .step-text {
        color: #0D47A1;
    }
    
    /* Animation for current step */
    .workflow-step.completed:last-child .step-icon,
    .workflow-step.completed.active .step-icon {
        animation: activePulse 2s infinite ease-in-out;
    }
    
    @keyframes activePulse {
        0% { transform: scale(1) translateY(-5px); box-shadow: 0 5px 15px rgba(13, 71, 161, 0.25); }
        50% { transform: scale(1.08) translateY(-8px); box-shadow: 0 8px 25px rgba(13, 71, 161, 0.4); }
        100% { transform: scale(1) translateY(-5px); box-shadow: 0 5px 15px rgba(13, 71, 161, 0.25); }
    }

    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .bg-success-soft { background-color: rgba(46, 204, 113, 0.1); }
    .bg-danger-soft { background-color: rgba(231, 76, 60, 0.1); }
    .bg-primary-soft { background-color: rgba(52, 152, 219, 0.1); }
    
    .audit-timeline {
        position: relative;
    }
    .timeline-item .dot {
        position: absolute;
        left: -4px;
        top: 5px;
        width: 8px;
        height: 8px;
        background: #dee2e6;
        border-radius: 50%;
    }
    .timeline-item:first-child .dot {
        background: #0D47A1;
        width: 10px;
        height: 10px;
        left: -5px;
    }
    
    .table-modern thead th {
        font-weight: bold;
        color: #495057;
        font-size: 0.75rem;
    }
    .animate-pulse {
        animation: pulseSubtle 2s infinite ease-in-out;
    }
    @keyframes pulseSubtle {
        0% { opacity: 0.7; }
        50% { opacity: 1; }
        100% { opacity: 0.7; }
    }
    .title-card-tiny {
        font-size: 0.7rem;
        text-transform: uppercase;
        color: #6c757d;
        letter-spacing: 0.5px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('.btn-cancel-request').on('click', function() {
            Swal.fire({
                title: 'Batalkan Permintaan?',
                text: "Status akan diubah menjadi 'Batal'. Rencana produksi ini tidak dapat dilanjutkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Tutup'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#cancelRequestForm').submit();
                }
            });
        });
    });
</script>
@endpush
