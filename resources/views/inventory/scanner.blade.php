@extends('layouts.app')

@section('title', 'QR Scanner Professional')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            {{-- Header --}}
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-qrcode fs-3 text-primary"></i>
                </div>
                <h4 class="fw-bold mb-1">Scanner Produk Mobile</h4>
                <p class="text-muted small">Optimalkan pengecekan stok dengan pindaian cepat</p>
            </div>

            {{-- Scanner Area --}}
            <div class="position-relative">
                <div class="card border-0 shadow-lg overflow-hidden rounded-4 mb-4">
                    <div id="reader-wrapper" class="position-relative bg-dark" style="min-height: 400px;">
                        <div id="reader"></div>
                        
                        {{-- Custom Overlay --}}
                        <div id="scanner-overlay" class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center pointer-events-none" style="z-index: 10;">
                            <div class="scanner-frame position-relative">
                                <div class="scanner-line"></div>
                                <div class="corner corner-tl"></div>
                                <div class="corner corner-tr"></div>
                                <div class="corner corner-bl"></div>
                                <div class="corner corner-br"></div>
                            </div>
                            <p class="text-white small mt-4 opacity-75">Arahkan kamera ke QR Code Produk</p>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between align-items-center px-4">
                        <div class="d-flex align-items-center">
                            <div id="status-indicator" class="status-dot me-2 bg-warning"></div>
                            <span id="scan-status" class="small fw-bold text-muted">Menyiapkan Kamera...</span>
                        </div>
                        <div class="d-flex gap-2">
                            <button id="torch-btn" class="btn btn-sm btn-light rounded-circle shadow-sm" title="Nyalakan Lampu">
                                <i class="fas fa-lightbulb"></i>
                            </button>
                            <button class="btn btn-sm btn-light rounded-circle shadow-sm" onclick="location.reload()" title="Refresh">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info Alert --}}
            <div class="alert alert-soft-primary border-0 rounded-4 d-flex align-items-start mb-4">
                <i class="fas fa-lightbulb mt-1 me-3 fs-5"></i>
                <div class="small">
                    <span class="fw-bold d-block mb-1">Tips Efisiensi:</span>
                    <ul class="mb-0 ps-3">
                        <li>Gunakan lampu (torch) di area gudang yang gelap.</li>
                        <li>Sistem otomatis akan mendeteksi data produk secara real-time.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Result --}}
<div class="modal fade" id="resultModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header bg-primary text-white border-0 p-3">
                <h6 class="modal-title fw-bold"><i class="fas fa-box me-2"></i>Informasi Produk</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="item-preview-content">
                    {{-- Content populated via JS --}}
                </div>
            </div>
            <div class="modal-footer border-0 p-3 bg-light bg-opacity-50">
                <button type="button" class="btn btn-secondary btn-sm px-4 rounded-pill" data-bs-dismiss="modal">Scan Lagi</button>
                <a href="#" id="view-detail-btn" class="btn btn-primary btn-sm px-4 rounded-pill">Detail Lengkap</a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Scanner UI Styles */
    #reader-wrapper {
        border-radius: 0;
        background: #000;
    }
    
    #reader {
        width: 100% !important;
        border: none !important;
    }
    
    #reader video {
        object-fit: cover !important;
        width: 100% !important;
        height: 100% !important;
        min-height: 400px;
    }

    /* Target Frame Animation */
    .scanner-frame {
        width: 260px;
        height: 260px;
        border: 2px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 0 0 4000px rgba(0, 0, 0, 0.5);
        position: relative;
    }

    .scanner-line {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, transparent, var(--primary), transparent);
        box-shadow: 0 0 15px var(--primary);
        animation: scan 2.5s infinite linear;
        border-radius: 100%;
        z-index: 5;
    }

    @keyframes scan {
        0% { top: 0; opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { top: 100%; opacity: 0; }
    }

    .corner {
        position: absolute;
        width: 25px;
        height: 25px;
        border: 4px solid var(--primary);
        z-index: 6;
    }

    .corner-tl { top: -2px; left: -2px; border-right: 0; border-bottom: 0; border-radius: 4px 0 0 0; }
    .corner-tr { top: -2px; right: -2px; border-left: 0; border-bottom: 0; border-radius: 0 4px 0 0; }
    .corner-bl { bottom: -2px; left: -2px; border-right: 0; border-top: 0; border-radius: 0 0 0 4px; }
    .corner-br { bottom: -2px; right: -2px; border-left: 0; border-top: 0; border-radius: 0 0 4px 0; }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.08); color: #0d6efd; }

    /* Modal Styling */
    .item-preview-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 20px;
        text-align: center;
        border-bottom: 1px solid #dee2e6;
    }
    
    .item-preview-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 16px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 15px;
        background: #fff;
    }

    .item-stat-card {
        padding: 12px;
        background: #fdfdfd;
        border-radius: 12px;
        border: 1px solid #f0f0f0;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    let html5QrCode;
    let isScanning = false;
    let modal = new bootstrap.Modal(document.getElementById('resultModal'));
    let scanTimeout = false;

    // Synthetic Beep Sound using Web Audio API
    function playBeep() {
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioCtx.createOscillator();
        const gainNode = audioCtx.createGain();

        oscillator.connect(gainNode);
        gainNode.connect(audioCtx.destination);

        oscillator.type = 'sine';
        oscillator.frequency.setValueAtTime(800, audioCtx.currentTime);
        gainNode.gain.setValueAtTime(0.1, audioCtx.currentTime);

        oscillator.start();
        oscillator.stop(audioCtx.currentTime + 0.1);
    }

    function onScanSuccess(decodedText) {
        if (scanTimeout) return;
        
        // Pause scanning
        scanTimeout = true;
        playBeep();
        
        // Vibrate if supported
        if ("vibrate" in navigator) {
            navigator.vibrate(100);
        }

        updateStatus('Mencari data produk...', 'info');

        // Send to backend via AJAX
        $.ajax({
            url: "{{ route('inventory.scanner.result') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                code: decodedText
            },
            success: function(response) {
                if (response.success) {
                    showProductModal(response.item);
                    updateStatus('Produk Berhasil Dideteksi!', 'success');
                } else {
                    Swal.fire({
                        title: 'Scan Berhasil',
                        text: response.message || 'QR Code tidak terdaftar dalam sistem inventaris.',
                        icon: 'warning',
                        confirmButtonText: 'Scan Lagi'
                    }).then(() => {
                        scanTimeout = false;
                        updateStatus('Siap Memindai...', 'success');
                    });
                }
            },
            error: function() {
                Swal.fire('Error', 'Gagal memproses pindaian.', 'error').then(() => {
                    scanTimeout = false;
                    updateStatus('Siap Memindai...', 'success');
                });
            }
        });
    }

    function showProductModal(item) {
        const content = `
            <div class="item-preview-header">
                ${item.image ? `<img src="${item.image}" class="item-preview-img">` : `<div class="item-preview-img d-flex align-items-center justify-content-center bg-white"><i class="fas fa-box fa-3x text-light"></i></div>`}
                <h5 class="fw-bold mb-1">${item.name}</h5>
                <span class="badge bg-primary px-3 rounded-pill">${item.sku}</span>
            </div>
            <div class="p-4">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="item-stat-card">
                            <small class="text-muted d-block mb-1">Stok Saat Ini</small>
                            <h4 class="fw-bold mb-0 ${item.stock < 10 ? 'text-danger' : 'text-dark'}">${item.stock} <small class="fw-normal fs-6 text-muted">${item.unit}</small></h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-stat-card">
                            <small class="text-muted d-block mb-1">Harga Retail</small>
                            <h4 class="fw-bold mb-0">Rp ${item.price}</h4>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="item-stat-card d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block mb-1">Kategori</small>
                                <span class="fw-semibold">${item.category}</span>
                            </div>
                            <i class="fas fa-tags text-primary opacity-25 fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.getElementById('item-preview-content').innerHTML = content;
        document.getElementById('view-detail-btn').href = item.url;
        modal.show();
    }

    document.getElementById('resultModal').addEventListener('hidden.bs.modal', function () {
        scanTimeout = false;
        updateStatus('Siap Memindai...', 'success');
    });

    function updateStatus(text, type) {
        const dot = document.getElementById('status-indicator');
        const label = document.getElementById('scan-status');
        
        label.innerText = text;
        dot.className = 'status-dot me-2';
        
        if (type === 'success') {
            dot.classList.add('bg-success');
            label.className = 'small fw-bold text-success';
        } else if (type === 'info') {
            dot.classList.add('bg-info');
            label.className = 'small fw-bold text-info';
        } else if (type === 'warning') {
            dot.classList.add('bg-warning');
            label.className = 'small fw-bold text-warning';
        } else {
            dot.classList.add('bg-danger');
            label.className = 'small fw-bold text-danger';
        }
    }

    // Initialize Camera
    function startScanner() {
        html5QrCode = new Html5Qrcode("reader");
        const config = { fps: 15, qrbox: { width: 250, height: 250 } };

        // Select the back camera
        Html5Qrcode.getCameras().then(cameras => {
            if (cameras && cameras.length) {
                let backCameraId = cameras[0].id;
                // Prefer rear camera
                for (let i = 0; i < cameras.length; i++) {
                    if (cameras[i].label.toLowerCase().includes('back') || 
                        cameras[i].label.toLowerCase().includes('rear')) {
                        backCameraId = cameras[i].id;
                        break;
                    }
                }
                
                html5QrCode.start(
                    backCameraId, 
                    config, 
                    onScanSuccess, 
                    (errorMessage) => {} // Failures ignored for performance
                ).then(() => {
                    updateStatus('Siap Memindai...', 'success');
                    isScanning = true;
                    
                    // Setup Torch if supported
                    const track = html5QrCode.getRunningTrack();
                    const capabilities = track.getCapabilities();
                    if (capabilities.torch) {
                        const torchBtn = document.getElementById('torch-btn');
                        torchBtn.style.display = 'block';
                        let torchOn = false;
                        torchBtn.onclick = () => {
                            torchOn = !torchOn;
                            track.applyConstraints({
                                advanced: [{ torch: torchOn }]
                            });
                            torchBtn.classList.toggle('btn-warning');
                            torchBtn.classList.toggle('btn-light');
                        };
                    } else {
                        document.getElementById('torch-btn').style.display = 'none';
                    }
                });
            }
        }).catch(err => {
            updateStatus('Kamera Tidak Ditemukan', 'danger');
            Swal.fire('Error Kamera', 'Pastikan izin kamera sudah diberikan.', 'error');
        });
    }

    $(document).ready(function() {
        startScanner();
    });
</script>
@endpush
@endsection
