@extends('layouts.app')

@section('title', 'Pusat Bantuan & Pembelajaran')

@section('content')
<div class="container-fluid">
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h4 class="mb-0 fw-bold text-gradient"><i class="fas fa-graduation-cap me-2"></i>Pusat Bantuan & Pembelajaran</h4>
            <p class="text-muted small mb-0">Panduan lengkap mengoperasikan sistem inventori PT NBC Indonesia</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary shadow-sm border-0">
                <i class="fas fa-home me-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Hero Banner --}}
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm overflow-hidden rounded-4" style="background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);">
                <div class="card-body p-4 p-md-5 text-white position-relative">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h2 class="fw-bold mb-3">Selamat Datang di Learning Center</h2>
                            <p class="lead mb-4 text-white-50">Sistem ini dirancang untuk mengotomatisasi alur kerja inventori, produksi, dan penjualan secara terintegrasi. Pelajari setiap modul dengan panduan lengkap di bawah ini.</p>
                            <div class="d-flex gap-3 flex-wrap">
                                <a href="#quickstart" class="btn btn-light rounded-pill px-4 fw-bold text-primary"><i class="fas fa-rocket me-2"></i>Mulai Cepat</a>
                                <a href="#faq" class="btn btn-outline-light rounded-pill px-4 fw-bold">Pertanyaan Umum</a>
                            </div>
                        </div>
                        <div class="col-md-5 d-none d-md-block text-center">
                            <i class="fas fa-book-open fa-10x opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Navigation Sidebar --}}
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px; z-index: 100;">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-3 px-2 text-muted small text-uppercase letter-spacing-1">Navigasi Materi</h6>
                    <div class="nav flex-column nav-pills" id="help-tabs" role="tablist">
                        <button class="nav-link active text-start py-3 mb-2 rounded-3 border-0" data-bs-toggle="pill" data-bs-target="#quickstart" type="button">
                            <i class="fas fa-rocket me-3"></i>Panduan Memulai
                        </button>
                        <button class="nav-link text-start py-3 mb-2 rounded-3 border-0" data-bs-toggle="pill" data-bs-target="#workflow-roles" type="button">
                            <i class="fas fa-sitemap me-3"></i>Alur & Peran User
                        </button>
                        <button class="nav-link text-start py-3 mb-2 rounded-3 border-0" data-bs-toggle="pill" data-bs-target="#inventory" type="button">
                            <i class="fas fa-boxes me-3"></i>Kelola Barang
                        </button>
                        <button class="nav-link text-start py-3 mb-2 rounded-3 border-0" data-bs-toggle="pill" data-bs-target="#purchase" type="button">
                            <i class="fas fa-truck-loading me-3"></i>Pembelian & Stok
                        </button>
                        <button class="nav-link text-start py-3 mb-2 rounded-3 border-0" data-bs-toggle="pill" data-bs-target="#sales" type="button">
                            <i class="fas fa-cash-register me-3"></i>Penjualan
                        </button>
                        <button class="nav-link text-start py-3 mb-2 rounded-3 border-0" data-bs-toggle="pill" data-bs-target="#reports" type="button">
                            <i class="fas fa-chart-bar me-3"></i>Laporan & Analitik
                        </button>
                        <button class="nav-link text-start py-3 mb-2 rounded-3 border-0" data-bs-toggle="pill" data-bs-target="#finance" type="button">
                            <i class="fas fa-coins me-3"></i>Keuangan
                        </button>
                        <button class="nav-link text-start py-3 mb-2 rounded-3 border-0" data-bs-toggle="pill" data-bs-target="#settings" type="button">
                            <i class="fas fa-cogs me-3"></i>Pengaturan Sistem
                        </button>
                        <button class="nav-link text-start py-3 mb-2 rounded-3 border-0" data-bs-toggle="pill" data-bs-target="#shortcuts" type="button">
                            <i class="fas fa-keyboard me-3"></i>Pintasan Keyboard
                        </button>
                        <button class="nav-link text-start py-3 mb-2 rounded-3 border-0" data-bs-toggle="pill" data-bs-target="#faq" type="button">
                            <i class="fas fa-question-circle me-3"></i>FAQ & Troubleshoot
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content Area --}}
        <div class="col-lg-9">
            <div class="tab-content border-0" id="help-content">
                
                {{-- TAB: Workflow & Roles --}}
                <div class="tab-pane fade" id="workflow-roles" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <h3 class="fw-bold mb-4 text-primary"><i class="fas fa-sitemap me-2"></i>Struktur Peran & Alur Kerja</h3>
                        <p class="text-muted mb-4">Pembagian tanggung jawab, kode akses, dan alur operasional Sistem Informasi Inventory PT NBC Indonesia.</p>

                        <div class="row g-3 g-md-4 mb-5" id="roles-grid">
                            {{-- Administrator --}}
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="role-card p-4 rounded-4 border h-100 position-relative border-primary bg-white shadow-hover transition-300">
                                    <div class="role-status-badge">SUPER USER</div>
                                    <div class="role-icon-wrapper bg-soft-primary text-primary shadow-sm mb-4">
                                        <i class="fas fa-shield-alt fa-lg"></i>
                                    </div>
                                    <h5 class="fw-bold mb-1">1. Administrator</h5>
                                    <p class="small text-primary fw-semibold mb-3">System Architecture & Security</p>
                                    
                                    <div class="role-meta mb-3 p-2 bg-light rounded-3">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-envelope fa-fw me-2 text-muted x-small"></i>
                                            <code class="x-small">admin@gmail.com</code>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-key fa-fw me-2 text-muted x-small"></i>
                                            <span class="x-small text-muted">Full Access Control</span>
                                        </div>
                                    </div>

                                    <ul class="small text-muted ps-3 mb-0 role-list">
                                        <li class="mb-2"><strong>RBAC Management:</strong> Mengelola struktur izin (Permissions) dan hierarki peran tingkat lanjut.</li>
                                        <li class="mb-2"><strong>Security Audit:</strong> Monitoring Audit Log untuk melacak setiap mutasi data sensitif di seluruh sistem.</li>
                                        <li class="mb-2"><strong>Disaster Recovery:</strong> Pemulihan data dari Pusat Pemulihan dan pengelolaan Backup Database.</li>
                                    </ul>
                                </div>
                            </div>
                            
                            {{-- Procurement --}}
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="role-card p-4 rounded-4 border h-100 position-relative border-info bg-white shadow-hover transition-300">
                                    <div class="role-status-badge bg-info">DUAL ROLE</div>
                                    <div class="role-icon-wrapper bg-soft-info text-info shadow-sm mb-4">
                                        <i class="fas fa-shopping-bag fa-lg"></i>
                                    </div>
                                    <h5 class="fw-bold mb-1">2. Staff Pengadaan</h5>
                                    <p class="small text-info fw-semibold mb-3">Procurement & Sales Spec.</p>

                                    <div class="role-meta mb-3 p-2 bg-light rounded-3">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-envelope fa-fw me-2 text-muted x-small"></i>
                                            <code class="x-small">procurement@gudang.com</code>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-briefcase fa-fw me-2 text-muted x-small"></i>
                                            <span class="x-small text-muted">Purchase & Sales Ops</span>
                                        </div>
                                    </div>

                                    <ul class="small text-muted ps-3 mb-0 role-list">
                                        <li class="mb-2"><strong>Purchase Management:</strong> Eksekusi PO, koordinasi supplier, dan tracking delivery untuk inventory restocking.</li>
                                        <li class="mb-2"><strong>Sales Operations:</strong> Memproses transaksi penjualan, mencatat pembayaran, dan mengelola data customer.</li>
                                        <li class="mb-2"><strong>Finance Tracking:</strong> Monitoring AP/AR untuk menjaga cash flow dan kredibilitas bisnis.</li>
                                    </ul>
                                </div>
                            </div>

                            {{-- Finance --}}
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="role-card p-4 rounded-4 border h-100 position-relative border-warning bg-white shadow-hover transition-300">
                                    <div class="role-status-badge bg-warning text-dark">VALUATION</div>
                                    <div class="role-icon-wrapper bg-soft-warning text-warning shadow-sm mb-4">
                                        <i class="fas fa-chart-line fa-lg"></i>
                                    </div>
                                    <h5 class="fw-bold mb-1">3. Finance & Analyst</h5>
                                    <p class="small text-warning fw-semibold mb-3">Asset & Cash Flow Controller</p>

                                    <div class="role-meta mb-3 p-2 bg-light rounded-3">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-envelope fa-fw me-2 text-muted x-small"></i>
                                            <code class="x-small">finance@gudang.com</code>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-dollar-sign fa-fw me-2 text-muted x-small"></i>
                                            <span class="x-small text-muted">P&L & Valuation Reports</span>
                                        </div>
                                    </div>

                                    <ul class="small text-muted ps-3 mb-0 role-list">
                                        <li class="mb-2"><strong>Inventory Valuation:</strong> Analisis nilai aset gudang dan laporan Laba Rugi operasional.</li>
                                        <li class="mb-2"><strong>Cash Flow Control:</strong> Rekonsiliasi mutasi bank dengan transaksi penjualan dan pembelian.</li>
                                        <li class="mb-2"><strong>Settlement:</strong> Eksekusi pembayaran Hutang dan monitoring Aging Piutang pelanggan.</li>
                                    </ul>
                                </div>
                            </div>

                            {{-- Supervisor --}}
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="role-card p-4 rounded-4 border h-100 position-relative border-danger bg-white shadow-hover transition-300">
                                    <div class="role-status-badge bg-danger">FIELD SV</div>
                                    <div class="role-icon-wrapper bg-soft-danger text-danger shadow-sm mb-4">
                                        <i class="fas fa-user-check fa-lg"></i>
                                    </div>
                                    <h5 class="fw-bold mb-1">4. Kepala Gudang</h5>
                                    <p class="small text-danger fw-semibold mb-3">Quality & Stock Supervisor</p>

                                    <div class="role-meta mb-3 p-2 bg-light rounded-3">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-envelope fa-fw me-2 text-muted x-small"></i>
                                            <code class="x-small">supervisor@gudang.com</code>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-check-double fa-fw me-2 text-muted x-small"></i>
                                            <span class="x-small text-muted">L1 Approval Authority</span>
                                        </div>
                                    </div>

                                    <ul class="small text-muted ps-3 mb-0 role-list">
                                        <li class="mb-2"><strong>L1 Validation:</strong> Melakukan verifikasi awal untuk setiap pengajuan Penyesuaian (Adjustment).</li>
                                        <li class="mb-2"><strong>Quality Control:</strong> Memastikan barang yang diterima atau dikirim sesuai standar spesifikasi PT NBC.</li>
                                        <li class="mb-2"><strong>Warehouse Audit:</strong> Scheduled Stock Opname dan optimalisasi tata letak (Layout) gudang.</li>
                                    </ul>
                                </div>
                            </div>

                            {{-- Staff Gudang --}}
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="role-card p-4 rounded-4 border h-100 position-relative border-success bg-white shadow-hover transition-300">
                                    <div class="role-status-badge bg-success">OPERATOR</div>
                                    <div class="role-icon-wrapper bg-soft-success text-success shadow-sm mb-4">
                                        <i class="fas fa-qrcode fa-lg"></i>
                                    </div>
                                    <h5 class="fw-bold mb-1">5. Staff Gudang</h5>
                                    <p class="small text-success fw-semibold mb-3">Logistics & Execution</p>

                                    <div class="role-meta mb-3 p-2 bg-light rounded-3">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-envelope fa-fw me-2 text-muted x-small"></i>
                                            <code class="x-small">staff@gudang.com</code>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-mobile-alt fa-fw me-2 text-muted x-small"></i>
                                            <span class="x-small text-muted">Mobile QR Scanner User</span>
                                        </div>
                                    </div>

                                    <ul class="small text-muted ps-3 mb-0 role-list">
                                        <li class="mb-2"><strong>Scanning Ops:</strong> Eksekusi mutasi barang (Masuk/Keluar) menggunakan perangkat Mobile QR.</li>
                                        <li class="mb-2"><strong>Pick & Pack:</strong> Penataan barang berdasarkan label SKU dan penyiapan order produksi/penjualan.</li>
                                        <li class="mb-2"><strong>Labeling:</strong> Pencetakan dan penempelan Kode QR pada setiap roll kain atau unit produk.</li>
                                    </ul>
                                </div>
                            </div>

                            {{-- PPIC --}}
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="role-card p-4 rounded-4 border h-100 position-relative border-dark bg-white shadow-hover transition-300">
                                    <div class="role-status-badge bg-dark">PLANNER</div>
                                    <div class="role-icon-wrapper bg-soft-dark text-dark shadow-sm mb-4">
                                        <i class="fas fa-industry fa-lg"></i>
                                    </div>
                                    <h5 class="fw-bold mb-1">6. Produksi / PPIC</h5>
                                    <p class="small text-dark fw-semibold mb-3">Planning & Material Controller</p>

                                    <div class="role-meta mb-3 p-2 bg-light rounded-3">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-envelope fa-fw me-2 text-muted x-small"></i>
                                            <code class="x-small">produksi@gudang.com</code>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-cogs fa-fw me-2 text-muted x-small"></i>
                                            <span class="x-small text-muted">Production Flow Owner</span>
                                        </div>
                                    </div>

                                    <ul class="small text-muted ps-3 mb-0 role-list">
                                        <li class="mb-2"><strong>MRP:</strong> Perencanaan kebutuhan bahan baku berdasarkan target order barang jadi.</li>
                                        <li class="mb-2"><strong>Material Request:</strong> Pengajuan pengambilan bahan baku ke gudang via sistem (Paperless).</li>
                                        <li class="mb-2"><strong>Yield Analysis:</strong> Pelaporan hasil produksi dan pemantauan efisensi penggunaan bahan baku.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Enterprise Workflow Integration --}}
                        <div class="premium-workflow-container rounded-4 p-3 p-md-5 mb-5 shadow-sm">
                            <h4 class="fw-bold mb-4 mb-md-5 text-center"><i class="fas fa-project-diagram me-2 me-md-3 text-primary"></i>SIKLUS OPERASIONAL TERPADU</h4>
                            
                            <div class="workflow-grid row g-3 g-md-4 position-relative">
                                {{-- Step 1 --}}
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div class="workflow-card p-4 rounded-4 bg-white border h-100 transition-300">
                                        <div class="workflow-number">01</div>
                                        <div class="workflow-icon bg-soft-primary text-primary mb-3">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Demand & Insight</h6>
                                        <p class="small text-muted mb-2"><strong>Management</strong> meninjau tren stok & demand via dashboard analitik.</p>
                                        <div class="workflow-actor x-small text-primary"><i class="fas fa-user-tie me-1"></i>Administrator</div>
                                    </div>
                                </div>

                                {{-- Step 2 --}}
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div class="workflow-card p-4 rounded-4 bg-white border h-100 transition-300">
                                        <div class="workflow-number">02</div>
                                        <div class="workflow-icon bg-soft-dark text-dark mb-3">
                                            <i class="fas fa-calendar-check"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Production Planning</h6>
                                        <p class="small text-muted mb-2">Pembuatan <strong>Production Order</strong> dan reservasi bahan baku sistem.</p>
                                        <div class="workflow-actor x-small text-dark"><i class="fas fa-industry me-1"></i>PPIC / Produksi</div>
                                    </div>
                                </div>

                                {{-- Step 3 --}}
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div class="workflow-card p-4 rounded-4 bg-white border h-100 transition-300">
                                        <div class="workflow-number">03</div>
                                        <div class="workflow-icon bg-soft-info text-info mb-3">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Restocking (If Needed)</h6>
                                        <p class="small text-muted mb-2">Jika bahan baku kurang, <strong>Procurement</strong> mengeksekusi PO ke Supplier.</p>
                                        <div class="workflow-actor x-small text-info"><i class="fas fa-shopping-bag me-1"></i>Staff Pengadaan</div>
                                    </div>
                                </div>

                                {{-- Step 4 --}}
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div class="workflow-card p-4 rounded-4 bg-white border h-100 transition-300">
                                        <div class="workflow-number">04</div>
                                        <div class="workflow-icon bg-soft-success text-success mb-3">
                                            <i class="fas fa-qrcode"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Warehouse Execution</h6>
                                        <p class="small text-muted mb-2">Penerimaan & Pengeluaran material via <strong>QR Scanner Mobile</strong>.</p>
                                        <div class="workflow-actor x-small text-success"><i class="fas fa-user me-1"></i>Staff Gudang</div>
                                    </div>
                                </div>

                                {{-- Step 5 --}}
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div class="workflow-card p-4 rounded-4 bg-white border h-100 transition-300">
                                        <div class="workflow-number">05</div>
                                        <div class="workflow-icon bg-soft-danger text-danger mb-3">
                                            <i class="fas fa-vial"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Quality Assurance</h6>
                                        <p class="small text-muted mb-2">Inspeksi fisik dan validasi akhir status <strong>Finish Goods</strong>.</p>
                                        <div class="workflow-actor x-small text-danger"><i class="fas fa-eye me-1"></i>Kepala Gudang</div>
                                    </div>
                                </div>

                                {{-- Step 6 --}}
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div class="workflow-card p-4 rounded-4 bg-white border h-100 transition-300">
                                        <div class="workflow-number">06</div>
                                        <div class="workflow-icon bg-soft-warning text-warning mb-3">
                                            <i class="fas fa-university"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Financial Settlement</h6>
                                        <p class="small text-muted mb-2">Closing invoice, pelunasan AP/AR, dan audit arus kas berkala.</p>
                                        <div class="workflow-actor x-small text-warning"><i class="fas fa-file-invoice-dollar me-1"></i>Finance</div>
                                    </div>
                                </div>

                                {{-- Step 7 --}}
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div class="workflow-card p-4 rounded-4 bg-white border h-100 transition-300">
                                        <div class="workflow-number">07</div>
                                        <div class="workflow-icon bg-soft-primary text-primary mb-3">
                                            <i class="fas fa-box-open"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Stock Reconciliation</h6>
                                        <p class="small text-muted mb-2">Penyelarasan data digital vs fisik melalui periodic <strong>Stock Opname</strong>.</p>
                                        <div class="workflow-actor x-small text-primary"><i class="fas fa-users-cog me-1"></i>All Roles</div>
                                    </div>
                                </div>

                                {{-- Step 8 --}}
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div class="workflow-card p-4 rounded-4 bg-dark text-white border-0 h-100 transition-300 shadow-lg">
                                        <div class="workflow-number text-white-50">08</div>
                                        <div class="workflow-icon bg-white bg-opacity-10 text-white mb-3">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                        <h6 class="fw-bold text-white">System Integrity Audit</h6>
                                        <p class="small text-white-50 mb-2">Review <strong>Activity Log</strong> untuk menjamin transparansi & keamanan sistem.</p>
                                        <div class="workflow-actor x-small text-white opacity-75"><i class="fas fa-shield-alt me-1"></i>System Admin</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Technical Security Specs --}}
                        <div class="row g-4">
                            <div class="col-12">
                                <h4 class="fw-bold mb-3"><i class="fas fa-shield-alt me-2 text-danger"></i>Spesifikasi Akses & Keamanan (Teknis)</h4>
                                <p class="text-muted small mb-4">Protokol keamanan yang harus dipatuhi oleh seluruh pengguna sistem (Laravel 12 Engine).</p>
                            </div>
                            <div class="col-md-4">
                                <div class="p-4 bg-soft-primary rounded-4 h-100 border border-primary border-opacity-10 shadow-sm">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-primary text-white rounded-circle p-2 me-3" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-mobile-alt small"></i>
                                        </div>
                                        <h6 class="fw-bold mb-0">Mobile-First Usage</h6>
                                    </div>
                                    <p class="small mb-0 text-muted"><strong>Staff & Kepala Gudang</strong> wajib menggunakan perangkat Mobile/Tablet di area gudang untuk fitur <strong>Scan QR Code</strong> yang cepat dan akurat.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-4 bg-soft-success rounded-4 h-100 border border-success border-opacity-10 shadow-sm">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-success text-white rounded-circle p-2 me-3" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-history small"></i>
                                        </div>
                                        <h6 class="fw-bold mb-0">Integritas Data (Soft Deletes)</h6>
                                    </div>
                                    <p class="small mb-0 text-muted">Data yang dihapus hanya akan masuk ke <strong>Archive</strong>. Pemulihan (Recovery) hanya bisa dilakukan oleh Admin/Supervisor melalui <strong>Pusat Pemulihan</strong>.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-4 bg-soft-danger rounded-4 h-100 border border-danger border-opacity-10 shadow-sm">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-danger text-white rounded-circle p-2 me-3" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-lock small"></i>
                                        </div>
                                        <h6 class="fw-bold mb-0">Keamanan Akun</h6>
                                    </div>
                                    <p class="small mb-0 text-muted">Password dienkripsi dengan <strong>Bcrypt</strong>. Dilarang berbagi akun antar pengguna untuk menjamin validitas <strong>History Aktivitas</strong> (Log Trail).</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB: Quick Start --}}
                <div class="tab-pane fade show active" id="quickstart" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <h3 class="fw-bold mb-3"><i class="fas fa-rocket me-2 text-primary"></i>7 Langkah Konfigurasi Awal</h3>
                        <p class="text-muted mb-4">Ikuti panduan ini untuk menyiapkan sistem dari awal hingga siap beroperasi. <span class="badge bg-info">Estimasi: 30 menit</span></p>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="step-card p-4 rounded-4 border h-100">
                                    <span class="badge bg-primary rounded-pill mb-2">Step 1</span>
                                    <h5 class="fw-bold">Daftarkan Gudang</h5>
                                    <p class="small text-muted mb-2">Minimal 1 gudang diperlukan untuk menyimpan stok barang. Contoh: Gudang Utama, Gudang Bahan Baku.</p>
                                    <a href="{{ route('inventory.warehouses.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                        <i class="fas fa-warehouse me-1"></i>Buka Menu Gudang
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="step-card p-4 rounded-4 border h-100">
                                    <span class="badge bg-primary rounded-pill mb-2">Step 2</span>
                                    <h5 class="fw-bold">Tambah Satuan</h5>
                                    <p class="small text-muted mb-2">Buat satuan ukuran seperti Kg, Pcs, Meter, Roll, Lusin, dll sesuai kebutuhan bisnis Anda.</p>
                                    <a href="{{ route('inventory.units.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                        <i class="fas fa-ruler me-1"></i>Buka Menu Satuan
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="step-card p-4 rounded-4 border h-100">
                                    <span class="badge bg-success rounded-pill mb-2">Step 3</span>
                                    <h5 class="fw-bold">Input Produk/Barang</h5>
                                    <p class="small text-muted mb-2">Daftarkan benang, kimia, kain, atau bahan baku lainnya. Gunakan SKU unik untuk setiap barang.</p>
                                    <a href="{{ route('inventory.items.create') }}" class="btn btn-sm btn-outline-success rounded-pill">
                                        <i class="fas fa-plus me-1"></i>Tambah Produk
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="step-card p-4 rounded-4 border h-100">
                                    <span class="badge bg-success rounded-pill mb-2">Step 4</span>
                                    <h5 class="fw-bold">Daftarkan Supplier & Customer</h5>
                                    <p class="small text-muted mb-2">Input supplier untuk pembelian dan customer untuk penjualan. Data kontak lengkap akan memudahkan pelacakan.</p>
                                    <a href="{{ route('inventory.suppliers.create') }}" class="btn btn-sm btn-outline-success rounded-pill me-2">
                                        <i class="fas fa-truck me-1"></i>Supplier
                                    </a>
                                    <a href="{{ route('inventory.customers.create') }}" class="btn btn-sm btn-outline-success rounded-pill">
                                        <i class="fas fa-users me-1"></i>Customer
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="step-card p-4 rounded-4 border h-100">
                                    <span class="badge bg-warning text-dark rounded-pill mb-2">Step 5</span>
                                    <h5 class="fw-bold">Isi Stok Awal</h5>
                                    <p class="small text-muted mb-2">Gunakan <strong>Pembelian</strong> atau <strong>Stock Adjustment</strong> untuk memasukkan stok fisik yang sudah ada di gudang.</p>
                                    <a href="{{ route('pembelian.create') }}" class="btn btn-sm btn-outline-warning rounded-pill">
                                        <i class="fas fa-shopping-cart me-1"></i>Buat Pembelian
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="step-card p-4 rounded-4 border h-100">
                                    <span class="badge bg-info rounded-pill mb-2">Step 6</span>
                                    <h5 class="fw-bold">Buat Penjualan Pertama</h5>
                                    <p class="small text-muted mb-2">Coba buat transaksi penjualan. Stok otomatis berkurang dan arus kas tercatat.</p>
                                    <a href="{{ route('penjualan.transaksi.create') }}" class="btn btn-sm btn-outline-info rounded-pill">
                                        <i class="fas fa-receipt me-1"></i>Penjualan Baru
                                    </a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="step-card p-4 rounded-4 bg-light border-0">
                                    <span class="badge bg-dark rounded-pill mb-2">Step 7</span>
                                    <h5 class="fw-bold"><i class="fas fa-chart-line me-2"></i>Pantau Dashboard</h5>
                                    <p class="small text-muted mb-0">Kembali ke Dashboard untuk melihat ringkasan penjualan, stok, dan grafik real-time. Sistem siap digunakan!</p>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-success border-0 shadow-sm rounded-3 mt-4">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Pro Tip:</strong> Gunakan fitur <strong>Import CSV</strong> untuk input data produk, customer, dan supplier secara massal.
                        </div>
                    </div>
                </div>

                {{-- TAB: Inventory --}}
                <div class="tab-pane fade" id="inventory" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <h3 class="fw-bold mb-4"><i class="fas fa-boxes me-2 text-primary"></i>Panduan Kelola Barang</h3>
                        
                        <div class="alert alert-info border-0 shadow-sm rounded-3 mb-4">
                            <i class="fas fa-lightbulb me-2"></i>
                            <strong>Tip SKU:</strong> Gunakan format yang konsisten seperti <code>BNG-CTN-001</code> (Benang Cotton #001) agar mudah dicari.
                        </div>

                        <h5 class="fw-bold mb-3">Menambah Produk Baru</h5>
                        <ol class="mb-4">
                            <li class="mb-2">Buka menu <strong>Master Data → Produk</strong></li>
                            <li class="mb-2">Klik tombol <span class="badge bg-primary">+ Tambah Produk Baru</span></li>
                            <li class="mb-2">Pilih <strong>Kategori</strong> (Benang, Kain, Kimia, dll) — formulir akan menyesuaikan otomatis</li>
                            <li class="mb-2">Isi Nama Produk, SKU, Harga Modal, Harga Jual, dan Stok Minimum</li>
                            <li class="mb-2">Pilih <strong>Gudang Penyimpanan</strong> default</li>
                            <li class="mb-2">Upload foto produk untuk identifikasi visual (opsional)</li>
                            <li class="mb-2">Klik <span class="badge bg-success">Simpan</span></li>
                        </ol>

                        <h5 class="fw-bold mb-3 mt-4">Fitur Pengelolaan Stok</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="feature-box p-3 rounded-3 border h-100">
                                    <i class="fas fa-barcode text-primary fa-2x mb-2"></i>
                                    <h6 class="fw-bold">Cetak Label Barcode</h6>
                                    <p class="small text-muted mb-0">Pilih barang di daftar, lalu klik "Cetak Label Terpilih" untuk mencetak barcode massal dalam format stiker.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-box p-3 rounded-3 border h-100">
                                    <i class="fas fa-file-csv text-success fa-2x mb-2"></i>
                                    <h6 class="fw-bold">Import/Export CSV</h6>
                                    <p class="small text-muted mb-0">Download template CSV, isi data, lalu import untuk input massal. Export untuk backup data.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-box p-3 rounded-3 border h-100">
                                    <i class="fas fa-exchange-alt text-info fa-2x mb-2"></i>
                                    <h6 class="fw-bold">Transfer Stok Antar Gudang</h6>
                                    <p class="small text-muted mb-0">Pindahkan barang antar gudang via menu <strong>Gudang & Stok → Transfer</strong>. Semua perpindahan tercatat di jurnal stok.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-box p-3 rounded-3 border h-100">
                                    <i class="fas fa-sliders-h text-warning fa-2x mb-2"></i>
                                    <h6 class="fw-bold">Penyesuaian Stok (Adjustment)</h6>
                                    <p class="small text-muted mb-0">Koreksi stok jika ada selisih fisik vs sistem. Setiap adjustment memerlukan alasan dan persetujuan.</p>
                                </div>
                            </div>
                        </div>

                        <h5 class="fw-bold mb-3 mt-4">Stock Opname (Stok Fisik)</h5>
                        <div class="p-3 bg-light rounded-3">
                            <p class="small mb-2"><strong>Langkah Stock Opname:</strong></p>
                            <ol class="small mb-0">
                                <li>Cetak laporan stok saat ini dari menu <strong>Laporan → Valuasi</strong></li>
                                <li>Hitung stok fisik di gudang</li>
                                <li>Bandingkan dengan laporan sistem</li>
                                <li>Jika ada selisih, buat <strong>Stock Adjustment</strong> dengan catatan alasan</li>
                                <li>Dokumentasikan hasil opname untuk audit</li>
                            </ol>
                        </div>
                    </div>
                </div>

                {{-- TAB: Purchase --}}
                <div class="tab-pane fade" id="purchase" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <h3 class="fw-bold mb-4"><i class="fas fa-truck-loading me-2 text-warning"></i>Panduan Pembelian & Stok Masuk</h3>
                        <p class="text-muted mb-4">Pembelian adalah cara utama untuk menambah stok barang dari supplier. Setiap pembelian otomatis menambah stok dan mencatat hutang jika belum lunas.</p>

                        <h5 class="fw-bold mb-3">Langkah Membuat Pembelian</h5>
                        <ol class="mb-4">
                            <li class="mb-2">Buka menu <strong>Pembelian</strong></li>
                            <li class="mb-2">Klik <span class="badge bg-primary">+ Pembelian Baru</span></li>
                            <li class="mb-2">Pilih <strong>Supplier</strong> dan isi Tanggal Pembelian serta No. Invoice Supplier</li>
                            <li class="mb-2">Tambahkan item: pilih produk, masukkan kuantitas dan harga beli per unit</li>
                            <li class="mb-2">Klik <span class="badge bg-info">+ Tambah Item</span> untuk menambah baris baru</li>
                            <li class="mb-2">Di bagian pembayaran, masukkan <strong>Jumlah Dibayar</strong>:
                                <ul class="mt-2">
                                    <li><strong>Bayar penuh</strong> = Status Lunas</li>
                                    <li><strong>Bayar sebagian/nol</strong> = Status Hutang (wajib isi Jatuh Tempo)</li>
                                </ul>
                            </li>
                            <li class="mb-2">Klik <span class="badge bg-success">Simpan Pembelian</span></li>
                        </ol>

                        <div class="alert alert-warning border-0 shadow-sm rounded-3 mb-4">
                            <i class="fas fa-magic me-2"></i>
                            <strong>Otomatis:</strong> Setelah disimpan, stok barang akan <strong>bertambah otomatis</strong> dan arus kas keluar tercatat.
                        </div>

                        <h5 class="fw-bold mb-3 mt-4">Mengelola Hutang Supplier</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 bg-danger bg-opacity-10 rounded-3 h-100">
                                    <h6 class="fw-bold text-danger"><i class="fas fa-clock me-2"></i>Melihat Hutang</h6>
                                    <p class="small mb-0">Buka menu <strong>Keuangan → Hutang</strong> untuk melihat daftar pembelian yang belum lunas beserta jatuh temponya.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-success bg-opacity-10 rounded-3 h-100">
                                    <h6 class="fw-bold text-success"><i class="fas fa-money-bill-wave me-2"></i>Bayar Hutang</h6>
                                    <p class="small mb-0">Buka detail pembelian → Klik <strong>"Bayar Hutang"</strong> → Masukkan nominal pembayaran.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB: Sales --}}
                <div class="tab-pane fade" id="sales" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <h3 class="fw-bold mb-4"><i class="fas fa-cash-register me-2 text-success"></i>Panduan Penjualan</h3>
                        
                        <h5 class="fw-bold mb-3">Langkah Membuat Penjualan</h5>
                        <ol class="mb-4">
                            <li class="mb-2">Buka menu <strong>Penjualan → Transaksi</strong></li>
                            <li class="mb-2">Klik <span class="badge bg-success">+ Transaksi Baru</span></li>
                            <li class="mb-2">Pilih <strong>Pelanggan</strong> dari dropdown, atau ketik nama baru untuk walk-in customer</li>
                            <li class="mb-2">Cari dan pilih <strong>Produk</strong> — akan otomatis ditambahkan ke keranjang</li>
                            <li class="mb-2">Atur kuantitas dan periksa subtotal</li>
                            <li class="mb-2">Masukkan <strong>Diskon</strong> (%) dan <strong>Pajak</strong> (%) jika ada</li>
                            <li class="mb-2">Masukkan <strong>Jumlah Dibayar</strong>:
                                <ul class="mt-2">
                                    <li>Jika bayar penuh → Kembalian dihitung otomatis</li>
                                    <li>Jika kurang dari Grand Total → Kolom <strong>Jatuh Tempo</strong> muncul (PIUTANG)</li>
                                </ul>
                            </li>
                            <li class="mb-2">Klik <span class="badge bg-success">Proses Penjualan</span></li>
                        </ol>

                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <div class="p-3 bg-success bg-opacity-10 rounded-3 h-100">
                                    <h6 class="fw-bold text-success"><i class="fas fa-print me-2"></i>Cetak Invoice</h6>
                                    <p class="small mb-0">Buka detail transaksi → Klik "Cetak Invoice" untuk faktur profesional.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-warning bg-opacity-10 rounded-3 h-100">
                                    <h6 class="fw-bold text-warning"><i class="fas fa-undo me-2"></i>Retur Penjualan</h6>
                                    <p class="small mb-0">Ada barang dikembalikan? Buka detail → Klik "Proses Retur".</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-info bg-opacity-10 rounded-3 h-100">
                                    <h6 class="fw-bold text-info"><i class="fas fa-hand-holding-usd me-2"></i>Terima Piutang</h6>
                                    <p class="small mb-0">Buka detail penjualan → Klik "Terima Pembayaran" untuk pelunasan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB: Reports --}}
                <div class="tab-pane fade" id="reports" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <h3 class="fw-bold mb-4"><i class="fas fa-chart-bar me-2 text-info"></i>Panduan Laporan & Analitik</h3>
                        <p class="text-muted mb-4">Sistem menyediakan berbagai laporan untuk memantau kesehatan bisnis dan inventori secara real-time.</p>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="p-4 border rounded-4 h-100">
                                    <i class="fas fa-coins text-warning fa-2x mb-3"></i>
                                    <h5 class="fw-bold">Valuasi Stok</h5>
                                    <p class="small text-muted">Melihat total nilai aset inventori berdasarkan harga beli, harga jual, atau rata-rata. Deteksi <strong>Dead Stock</strong> (barang tidak laku >90 hari).</p>
                                    <ul class="small text-muted mb-0">
                                        <li>Filter per gudang atau kategori</li>
                                        <li>Grafik komposisi nilai per kategori</li>
                                        <li>Export ke PDF & Excel</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-4 border rounded-4 h-100">
                                    <i class="fas fa-history text-primary fa-2x mb-3"></i>
                                    <h5 class="fw-bold">Jurnal Stok (Stock Ledger)</h5>
                                    <p class="small text-muted">Melihat riwayat lengkap pergerakan stok: masuk, keluar, transfer, adjustment.</p>
                                    <ul class="small text-muted mb-0">
                                        <li>Filter per periode dan gudang</li>
                                        <li>Lacak sumber setiap perubahan</li>
                                        <li>Ringkasan stok per kategori</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-4 border rounded-4 h-100">
                                    <i class="fas fa-file-invoice-dollar text-success fa-2x mb-3"></i>
                                    <h5 class="fw-bold">Laporan Penjualan</h5>
                                    <p class="small text-muted">Analisis performa penjualan per periode, customer, atau produk.</p>
                                    <ul class="small text-muted mb-0">
                                        <li>Top 10 produk terlaris</li>
                                        <li>Top customer berdasarkan nilai</li>
                                        <li>Grafik tren penjualan bulanan</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-4 border rounded-4 h-100">
                                    <i class="fas fa-shopping-basket text-danger fa-2x mb-3"></i>
                                    <h5 class="fw-bold">Laporan Pembelian</h5>
                                    <p class="small text-muted">Track pengeluaran untuk pembelian barang dan performa supplier.</p>
                                    <ul class="small text-muted mb-0">
                                        <li>Total pembelian per periode</li>
                                        <li>Supplier dengan nilai tertinggi</li>
                                        <li>Hutang yang jatuh tempo</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info border-0 shadow-sm rounded-3 mt-4">
                            <i class="fas fa-download me-2"></i>
                            <strong>Export:</strong> Semua laporan bisa di-export ke <strong>PDF</strong> untuk cetak atau <strong>Excel</strong> untuk analisis lebih lanjut.
                        </div>
                    </div>
                </div>

                {{-- TAB: Finance --}}
                <div class="tab-pane fade" id="finance" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <h3 class="fw-bold mb-4"><i class="fas fa-coins me-2 text-warning"></i>Panduan Keuangan</h3>
                        <p class="text-muted mb-4">Modul keuangan membantu Anda memantau arus kas, hutang, piutang, dan kesehatan finansial bisnis.</p>

                        <h5 class="fw-bold mb-3">Dashboard Keuangan</h5>
                        <div class="p-3 bg-light rounded-3 mb-4">
                            <p class="small mb-2">Dashboard Keuangan menampilkan:</p>
                            <ul class="small mb-0">
                                <li><strong>Saldo Kas:</strong> Total uang masuk dikurangi uang keluar sepanjang waktu</li>
                                <li><strong>Net Movement:</strong> Selisih kas masuk-keluar pada periode yang dipilih</li>
                                <li><strong>Total Piutang & Overdue:</strong> Tagihan yang belum dibayar customer</li>
                                <li><strong>Total Hutang & Overdue:</strong> Kewajiban ke supplier yang belum dilunasi</li>
                                <li><strong>Grafik Arus Kas:</strong> Perbandingan uang masuk vs keluar 6 bulan terakhir</li>
                                <li><strong>Distribusi Pengeluaran:</strong> Breakdown pengeluaran per kategori</li>
                            </ul>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 h-100">
                                    <h6 class="fw-bold text-primary"><i class="fas fa-hand-holding-usd me-2"></i>Mengelola Piutang</h6>
                                    <ol class="small mb-0">
                                        <li>Buka <strong>Keuangan → Piutang</strong></li>
                                        <li>Lihat daftar penjualan yang belum lunas</li>
                                        <li>Klik detail untuk melihat riwayat pembayaran</li>
                                        <li>Klik "Terima Pembayaran" untuk mencatat pelunasan</li>
                                    </ol>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 h-100">
                                    <h6 class="fw-bold text-danger"><i class="fas fa-file-invoice-dollar me-2"></i>Mengelola Hutang</h6>
                                    <ol class="small mb-0">
                                        <li>Buka <strong>Keuangan → Hutang</strong></li>
                                        <li>Lihat daftar pembelian yang belum lunas</li>
                                        <li>Prioritaskan yang sudah jatuh tempo (merah)</li>
                                        <li>Klik "Bayar Hutang" untuk mencatat pelunasan</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB: Settings --}}
                <div class="tab-pane fade" id="settings" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <h3 class="fw-bold mb-4"><i class="fas fa-cogs me-2 text-secondary"></i>Panduan Pengaturan Sistem</h3>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="p-4 border rounded-4 h-100">
                                    <i class="fas fa-building text-primary fa-2x mb-3"></i>
                                    <h5 class="fw-bold">Profil Perusahaan</h5>
                                    <p class="small text-muted">Atur nama, alamat, logo, dan footer yang muncul di invoice dan laporan.</p>
                                    <p class="small mb-0"><strong>Menu:</strong> Pengaturan → Profil Perusahaan</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-4 border rounded-4 h-100">
                                    <i class="fas fa-users-cog text-info fa-2x mb-3"></i>
                                    <h5 class="fw-bold">Manajemen Pengguna</h5>
                                    <p class="small text-muted">Tambah, edit, atau nonaktifkan akun pengguna. Reset password jika lupa.</p>
                                    <p class="small mb-0"><strong>Menu:</strong> Pengaturan → Data Pengguna</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-4 border rounded-4 h-100">
                                    <i class="fas fa-user-shield text-warning fa-2x mb-3"></i>
                                    <h5 class="fw-bold">Hak Akses (RBAC)</h5>
                                    <p class="small text-muted">Atur permission untuk setiap role (Admin, Manager, Staff Gudang, Finance, dll).</p>
                                    <p class="small mb-0"><strong>Menu:</strong> Pengaturan → Hak Akses</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-4 border rounded-4 h-100">
                                    <i class="fas fa-tags text-success fa-2x mb-3"></i>
                                    <h5 class="fw-bold">Master Data</h5>
                                    <p class="small text-muted">Kelola kategori produk, satuan, gudang, dan data master lainnya.</p>
                                    <p class="small mb-0"><strong>Menu:</strong> Inventori → submenu terkait</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB: Shortcuts --}}
                <div class="tab-pane fade" id="shortcuts" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <h3 class="fw-bold mb-4"><i class="fas fa-keyboard me-2 text-dark"></i>Pintasan Keyboard</h3>
                        <p class="text-muted mb-4">Gunakan pintasan keyboard untuk navigasi dan aksi lebih cepat.</p>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Pintasan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><kbd>Ctrl</kbd> + <kbd>/</kbd></td>
                                        <td>Fokus ke kolom pencarian</td>
                                    </tr>
                                    <tr>
                                        <td><kbd>Ctrl</kbd> + <kbd>S</kbd></td>
                                        <td>Simpan formulir (pada halaman form)</td>
                                    </tr>
                                    <tr>
                                        <td><kbd>Esc</kbd></td>
                                        <td>Tutup modal/popup</td>
                                    </tr>
                                    <tr>
                                        <td><kbd>Tab</kbd></td>
                                        <td>Pindah antar field formulir</td>
                                    </tr>
                                    <tr>
                                        <td><kbd>Enter</kbd></td>
                                        <td>Submit formulir / Konfirmasi aksi</td>
                                    </tr>
                                    <tr>
                                        <td><kbd>Ctrl</kbd> + <kbd>P</kbd></td>
                                        <td>Cetak halaman (pada halaman laporan)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="alert alert-secondary border-0 shadow-sm rounded-3 mt-4">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Tips:</strong> Gunakan <strong>Tab</strong> untuk berpindah field saat input data agar lebih cepat daripada menggunakan mouse.
                        </div>
                    </div>
                </div>

                {{-- TAB: FAQ --}}
                <div class="tab-pane fade" id="faq" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                        <h3 class="fw-bold mb-3 text-center"><i class="fas fa-question-circle me-2"></i>Tanya Jawab (FAQ)</h3>
                        
                        <div class="row justify-content-center mb-4">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                    <input type="text" class="form-control border-start-0" id="faqSearch" placeholder="Cari pertanyaan...">
                                </div>
                            </div>
                        </div>

                        <div class="accordion accordion-flush" id="faqAccordion">
                            <div class="accordion-item border-bottom faq-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold px-0 bg-transparent py-4 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#q1">
                                        Mengapa saya tidak bisa menghapus barang?
                                    </button>
                                </h2>
                                <div id="q1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body px-0 py-2 pb-4 text-muted small">
                                        Barang yang sudah pernah digunakan dalam transaksi (Penjualan, Pembelian, atau Produksi) tidak dapat dihapus demi integritas histori data. Anda sebaiknya mengubah status barang menjadi <strong>non-aktif</strong> saja.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border-bottom faq-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold px-0 bg-transparent py-4 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#q2">
                                        Bagaimana cara mencetak invoice penjualan?
                                    </button>
                                </h2>
                                <div id="q2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body px-0 py-2 pb-4 text-muted small">
                                        Masuk ke menu <strong>Daftar Penjualan</strong>, cari transaksi yang diinginkan, klik tombol <strong>"Detail"</strong> (ikon mata), lalu klik tombol <strong>"Cetak Invoice"</strong> di bagian atas halaman detail.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border-bottom faq-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold px-0 bg-transparent py-4 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#q3">
                                        Apa yang harus dilakukan jika stok di gudang dan sistem berbeda?
                                    </button>
                                </h2>
                                <div id="q3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body px-0 py-2 pb-4 text-muted small">
                                        Lakukan <strong>Stock Opname</strong> secara berkala. Jika ditemukan perbedaan, buatlah entri di menu <strong>Penyesuaian Stok (Adjustment)</strong> dengan alasan yang jelas agar stok di sistem kembali sinkron dengan fisik.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border-bottom faq-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold px-0 bg-transparent py-4 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#q4">
                                        Bagaimana cara mencatat hutang ke supplier?
                                    </button>
                                </h2>
                                <div id="q4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body px-0 py-2 pb-4 text-muted small">
                                        Saat membuat <strong>Pembelian</strong>, masukkan <strong>"Jumlah Dibayar"</strong> kurang dari total. Sistem otomatis mencatat selisih sebagai Hutang. Untuk melunasi, buka detail pembelian dan klik "Bayar Hutang".
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border-bottom faq-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold px-0 bg-transparent py-4 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#q5">
                                        Bagaimana cara mencatat piutang dari pelanggan?
                                    </button>
                                </h2>
                                <div id="q5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body px-0 py-2 pb-4 text-muted small">
                                        Saat membuat <strong>Penjualan</strong>, masukkan <strong>"Jumlah Dibayar"</strong> kurang dari Grand Total. Sistem otomatis mencatat selisih sebagai Piutang dengan jatuh tempo yang Anda tentukan.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border-bottom faq-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold px-0 bg-transparent py-4 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#q6">
                                        Siapa yang bisa mengakses menu tertentu?
                                    </button>
                                </h2>
                                <div id="q6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body px-0 py-2 pb-4 text-muted small">
                                        Sistem menggunakan <strong>Role-Based Access Control (RBAC)</strong>. Admin dapat mengatur hak akses setiap role di menu <strong>Pengaturan → Hak Akses</strong>. Setiap role memiliki permission berbeda.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border-bottom faq-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold px-0 bg-transparent py-4 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#q7">
                                        Bagaimana cara import data dari Excel/CSV?
                                    </button>
                                </h2>
                                <div id="q7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body px-0 py-2 pb-4 text-muted small">
                                        <ol class="mb-0">
                                            <li>Klik <strong>Download Template</strong> untuk mendapatkan format yang benar</li>
                                            <li>Isi file dengan data Anda (gunakan header yang sama)</li>
                                            <li>Klik <strong>Import CSV</strong> dan pilih file yang sudah diisi</li>
                                            <li>Sistem akan memvalidasi dan menampilkan hasil import</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border-bottom faq-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold px-0 bg-transparent py-4 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#q8">
                                        Bagaimana cara melakukan retur penjualan?
                                    </button>
                                </h2>
                                <div id="q8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body px-0 py-2 pb-4 text-muted small">
                                        Buka menu <strong>Penjualan → Daftar Transaksi</strong>, cari transaksi yang ingin diretur, klik <strong>"Detail"</strong>, lalu klik tombol <strong>"Proses Retur"</strong>. Pilih item yang diretur dan stok akan otomatis kembali.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border-bottom faq-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold px-0 bg-transparent py-4 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#q9">
                                        Bagaimana cara reset password yang lupa?
                                    </button>
                                </h2>
                                <div id="q9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body px-0 py-2 pb-4 text-muted small">
                                        Pada halaman login, klik link <strong>"Lupa Password?"</strong>. Masukkan email Anda, sistem akan mengirimkan link reset password ke email tersebut. Klik link dan buat password baru.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border-0 faq-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold px-0 bg-transparent py-4 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#q10">
                                        Mengapa grafik di dashboard kosong?
                                    </button>
                                </h2>
                                <div id="q10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body px-0 py-2 pb-4 text-muted small">
                                        Grafik memerlukan data transaksi. Jika sistem baru diinstall atau belum ada transaksi dalam periode yang dipilih, grafik akan kosong. Mulai buat transaksi pembelian dan penjualan untuk melihat data di grafik.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // FAQ Search
    $('#faqSearch').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('.faq-item').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>
@endpush

<style>
    /* Premium Color Palette & Utilities */
    :root {
        --textile-primary: #0d6efd;
        --textile-secondary: #6c757d;
        --textile-dark: #212529;
        --soft-blue: rgba(13, 110, 253, 0.05);
        --glass-bg: rgba(255, 255, 255, 0.7);
    }

    .text-gradient {
        background: linear-gradient(135deg, #0d6efd, #0dcaf0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .transition-300 { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .letter-spacing-1 { letter-spacing: 1px; }
    .x-small { font-size: 0.7rem; }
    
    /* Navigation Sidebar Refinement */
    #help-tabs .nav-link {
        color: #495057;
        font-weight: 500;
        border-radius: 12px;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }
    #help-tabs .nav-link:hover:not(.active) {
        background: var(--soft-blue);
        color: var(--textile-primary);
        border-left-color: rgba(13, 110, 253, 0.3);
    }
    #help-tabs .nav-link.active {
        background: var(--textile-primary) !important;
        color: #fff !important;
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.15);
        border-left-color: #004dc0;
    }

    /* Role Cards Premium Design */
    .role-card {
        border: 1px solid rgba(0,0,0,0.08) !important;
        background: #fff;
        z-index: 1;
    }
    .role-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.08) !important;
        border-color: var(--textile-primary) !important;
    }

    .role-status-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 0.6rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 50px;
        background: var(--soft-blue);
        color: var(--textile-primary);
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .role-icon-wrapper {
        width: 54px;
        height: 54px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .role-list {
        list-style: none;
        padding-left: 0;
    }
    .role-list li {
        position: relative;
        padding-left: 1.25rem;
        line-height: 1.4;
    }
    .role-list li::before {
        content: '→';
        position: absolute;
        left: 0;
        color: var(--textile-primary);
        font-weight: bold;
    }

    /* Premium Workflow Grid */
    .premium-workflow-container {
        background: linear-gradient(to bottom right, #f8f9fa, #ffffff);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .workflow-card {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .workflow-card:hover {
        transform: scale(1.02);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .workflow-number {
        position: absolute;
        top: -10px;
        right: -5px;
        font-size: 4rem;
        font-weight: 900;
        opacity: 0.03;
        line-height: 1;
    }

    .workflow-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    /* Soft Colors */
    .bg-soft-primary { background: rgba(13, 110, 253, 0.08) !important; color: #0d6efd; }
    .bg-soft-info { background: rgba(13, 202, 240, 0.08) !important; color: #0dcaf0; }
    .bg-soft-warning { background: rgba(255, 193, 7, 0.08) !important; color: #ffc107; }
    .bg-soft-danger { background: rgba(220, 53, 69, 0.08) !important; color: #dc3545; }
    .bg-soft-success { background: rgba(25, 135, 84, 0.08) !important; color: #198754; }
    .bg-soft-dark { background: rgba(33, 37, 41, 0.08) !important; color: #212529; }

    .workflow-actor {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    .role-meta {
        overflow-wrap: break-word;
        word-wrap: break-word;
    }

    /* Responsive Adjustments */
    @media (max-width: 991.98px) {
        .sticky-top { position: relative !important; top: 0 !important; margin-bottom: 2rem; }
        .card-body { padding: 1.5rem !important; }
    }

    @media (max-width: 767.98px) {
        /* Typography Scaling */
        .tab-pane h3 { font-size: 1.5rem !important; }
        .tab-pane h4 { font-size: 1.25rem !important; }
        .tab-pane h5 { font-size: 1.1rem !important; }
        .tab-pane h6 { font-size: 0.95rem !important; }
        
        .workflow-number { font-size: 2.5rem; }
        .role-card { margin-bottom: 0.75rem; }
        
        .role-status-badge {
            font-size: 0.55rem;
            padding: 3px 8px;
            top: 12px;
            right: 12px;
        }
        
        .role-icon-wrapper {
            width: 44px;
            height: 44px;
            margin-bottom: 1rem;
        }
        
        .workflow-icon {
            width: 38px;
            height: 38px;
            font-size: 1rem;
        }
        
        .workflow-card {
            padding: 1rem !important;
        }
        
        .premium-workflow-container {
            padding: 1.5rem !important;
        }
    }

    /* Mobile Phones (≤575px) */
    @media (max-width: 575.98px) {
        .tab-pane h3 { font-size: 1.3rem !important; margin-bottom: 1rem !important; }
        .tab-pane h4 { font-size: 1.15rem !important; }
        .tab-pane h5 { font-size: 1rem !important; margin-bottom: 0.5rem !important; }
        .tab-pane h6 { font-size: 0.9rem !important; }
        
        .role-card { padding: 1rem !important; }
        
        .role-status-badge {
            font-size: 0.5rem;
            padding: 2px 6px;
            top: 10px;
            right: 10px;
        }
        
        .role-icon-wrapper {
            width: 40px;
            height: 40px;
            margin-bottom: 0.75rem;
        }
        
        .role-meta {
            padding: 0.5rem !important;
            font-size: 0.75rem !important;
        }
        
        .role-meta code,
        .role-meta span {
            font-size: 0.65rem !important;
        }
        
        .role-list li {
            font-size: 0.8rem;
            margin-bottom: 0.5rem !important;
            line-height: 1.5;
        }
        
        .workflow-number { font-size: 2rem; }
        
        .workflow-icon {
            width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }
        
        .workflow-card h6 { font-size: 0.9rem !important; }
        .workflow-card .small { font-size: 0.75rem !important; }
        .workflow-actor { font-size: 0.65rem !important; }
        
        .premium-workflow-container { padding: 1rem !important; }
        
        .mb-5 { margin-bottom: 2rem !important; }
        .mb-4 { margin-bottom: 1.5rem !important; }
    }

    /* Small Mobile (≤375px) */
    @media (max-width: 375px) {
        .role-status-badge {
            font-size: 0.45rem;
            padding: 2px 5px;
        }
        
        .role-icon-wrapper {
            width: 36px;
            height: 36px;
        }
        
        .workflow-icon {
            width: 32px;
            height: 32px;
        }
        
        .role-card,
        .workflow-card {
            padding: 0.75rem !important;
        }
        
        .x-small { font-size: 0.6rem !important; }
    }

    /* Animations */
    .tab-pane { animation: slideUp 0.5s ease-out; }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    kbd {
        background-color: #eee;
        border-radius: 3px;
        border: 1px solid #b4b4b4;
        box-shadow: 0 1px 1px rgba(24, 17, 17, 0.2);
        color: #333;
        display: inline-block;
        font-size: .85em;
        font-weight: 700;
        line-height: 1;
        padding: 2px 4px;
        white-space: nowrap;
    }
</style>
@endsection
