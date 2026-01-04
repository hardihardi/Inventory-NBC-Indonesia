<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $company->name ?? config('app.name', 'Gudang') }} - @yield('title')</title>

  {{-- Library Font & Ikon --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  {{-- Library CSS Pihak Ketiga --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
  <link rel="icon" href="{{ $company->favicon ? asset('storage/' . $company->favicon) : asset('logo.ico') }}" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  <style>
    :root {
      --primary: #06609CFF;
      --secondary: #2c3e50;
      --success: #27ae60;
      --danger: #e74c3c;
      --warning: #f39c12;
      --info: #2980b9;
      --light: #ecf0f1;
      --dark: #2c3e50;
      --sidebar-width: 250px;
      --topbar-height: 60px;
    }

    * {
      font-family: 'Poppins', sans-serif;
      box-sizing: border-box;
    }

    body {
      background-color: #f5f7fa;
      overflow-x: hidden;
    }

    /* Layout */
    .wrapper {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .sidebar {
      width: var(--sidebar-width);
      background: var(--primary);
      color: white;
      position: fixed;
      height: 100vh;
      z-index: 1050;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 2px 0 20px rgba(0, 0, 0, 0.2);
      overflow-y: auto;
      overflow-x: hidden;
      backface-visibility: hidden;
      -webkit-backface-visibility: hidden;
    }

    .main-content {
      margin-left: var(--sidebar-width);
      width: calc(100% - var(--sidebar-width));
      transition: all 0.3s ease;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .content {
      margin-top: var(--topbar-height);
      flex: 1;
      padding: 20px;
    }

    /* Footer */
    footer {
      width: 100%;
      box-sizing: border-box;
    }

    /* Navbar */
    .navbar {
      height: var(--topbar-height);
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
      position: fixed;
      top: 0;
      right: 0;
      left: var(--sidebar-width);
      z-index: 1040;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      background: rgba(6, 96, 156, 0.95) !important;
    }

    /* Cards */
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      transition: all 0.3s;
      margin-bottom: 1.5rem;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      background: white;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      font-weight: 600;
    }

    /* Buttons */
    .btn {
      border-radius: 8px;
      padding: 8px 16px;
      font-weight: 500;
      transition: all 0.3s;
    }

    .sidebar-divider {
      height: 2px;
      background-color: rgba(255, 255, 255, 0.2);
      margin-top: -14px;
    }

    /* Sidebar Menu */
    .sidebar-menu {
      padding: 0;
      list-style: none;
    }

    .sidebar-item {
      margin-bottom: 5px;
    }

    .sidebar-link {
      display: flex;
      align-items: center;
      padding: 12px 15px;
      color: rgba(255, 255, 255, 0.6);
      text-decoration: none;
      border-radius: 0 50px 50px 0;
      margin-right: 10px;
      transition: all 0.3s;
      position: relative;
    }

    .sidebar-link:hover,
    .sidebar-link.active {
      background: rgba(255, 255, 255, 0.1);
      color: white;
    }

    .sidebar-link.active::before {
      content: "";
      position: absolute;
      left: 0;
      top: 15%;
      bottom: 15%;
      width: 4px;
      background: #fff;
      border-radius: 0 4px 4px 0;
      box-shadow: 2px 0 10px rgba(255, 255, 255, 0.5);
    }

    .sidebar-icon {
      width: 24px;
      text-align: center;
      margin-right: 10px;
      font-size: 18px;
    }

    .sidebar-text {
      flex-grow: 1;
    }

    .sidebar-badge {
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50px;
      padding: 2px 8px;
      font-size: 12px;
    }

    .sidebar-submenu {
      padding-left: 0;
    }

    .sidebar-submenu .sidebar-link {
      padding: 8px 15px 8px 40px;
      font-size: 14px;
    }

    #nprogress .bar {
      background: var(--primary) !important;
      height: 3px !important;
    }

    #nprogress .peg {
      box-shadow: 0 0 10px var(--primary), 0 0 5px var(--primary) !important;
    }

    /* Responsive */
    @media (max-width: 992px) {
      .sidebar {
        left: calc(-1 * var(--sidebar-width));
      }

      .sidebar.show {
        left: 0;
      }

      .main-content {
        margin-left: 0 !important;
        width: 100% !important;
      }

      .navbar {
        left: 0 !important;
        width: 100% !important;
      }
    }

    @media (max-width: 768px) {
      .content {
        padding: 15px;
      }

      .sidebar {
        width: 220px;
      }
    }

    @media (max-width: 576px) {
      .content {
        padding: 10px;
      }

      .navbar-brand {
        font-size: 1rem;
      }

      .search-form {
        display: none;
      }
    }

    /* Animations */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateX(-30px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .sidebar.show .sidebar-item {
      animation: slideIn 0.4s ease forwards;
      opacity: 0;
    }

    /* Sequential delays for first 10 items */
    .sidebar.show .sidebar-item:nth-child(1) { animation-delay: 0.1s; }
    .sidebar.show .sidebar-item:nth-child(2) { animation-delay: 0.15s; }
    .sidebar.show .sidebar-item:nth-child(3) { animation-delay: 0.2s; }
    .sidebar.show .sidebar-item:nth-child(4) { animation-delay: 0.25s; }
    .sidebar.show .sidebar-item:nth-child(5) { animation-delay: 0.3s; }
    .sidebar.show .sidebar-item:nth-child(6) { animation-delay: 0.35s; }
    .sidebar.show .sidebar-item:nth-child(7) { animation-delay: 0.4s; }
    .sidebar.show .sidebar-item:nth-child(8) { animation-delay: 0.45s; }
    .sidebar.show .sidebar-item:nth-child(9) { animation-delay: 0.5s; }
    .sidebar.show .sidebar-item:nth-child(10) { animation-delay: 0.55s; }

    .animate-fade {
      animation: fadeIn 0.5s ease forwards;
    }

    /* Utility */
    .hover-scale {
      transition: transform 0.3s;
    }

    .hover-scale:hover {
      transform: scale(1.03);
    }

    .text-gradient {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }

    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
      background: #c1c1c1;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #a8a8a8;
    }

    /* Loading Overlay */
    #loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.9);
      z-index: 9999;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    .spinner {
      width: 50px;
      height: 50px;
      border: 5px solid #f3f3f3;
      border-top: 5px solid var(--primary);
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    /* Backdrop for mobile sidebar */
    .sidebar-backdrop {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      z-index: 1040;
      display: none;
      transition: opacity 0.4s ease;
    }
    /* --- MOBILE CARD VIEW (Premium Responsive) --- */
    @media (max-width: 768px) {
      .table-responsive-stack .thead-dark {
        display: none;
      }
      .table-responsive-stack tr {
        display: block;
        border: 1px solid #dee2e6;
        margin-bottom: 1rem;
        border-radius: 10px;
        background: white;
        padding: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
      }
      .table-responsive-stack td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: none;
        padding: 8px 5px;
        border-bottom: 1px dashed #eee;
        text-align: right;
      }
      .table-responsive-stack td:last-child {
        border-bottom: none;
      }
      .table-responsive-stack td::before {
        content: attr(data-label);
        font-weight: 700;
        text-align: left;
        color: var(--primary);
        font-size: 0.7rem;
        flex: 1;
        margin-right: 15px;
        text-transform: uppercase;
        opacity: 0.8;
      }
      .table-responsive-stack td {
        text-align: right;
        font-size: 0.85rem;
        min-height: 45px;
      }
      .mobile-stack {
        flex-direction: column !important;
      }
      .mobile-stack > * {
        width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-bottom: 0.5rem;
      }
      .mobile-hide { display: none !important; }
      .mobile-text-start { text-align: left !important; }
    }

    /* --- GLASSMORPHISM & PREMIUM BLURS --- */
    .glass-card {
      background: rgba(255, 255, 255, 0.7) !important;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3) !important;
    }

    .glass-sidebar {
      background: linear-gradient(165deg, var(--primary) 0%, #03416b 100%) !important;
      backdrop-filter: blur(25px);
      -webkit-backdrop-filter: blur(25px);
      border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    .bg-soft-primary { background-color: rgba(6, 96, 156, 0.1); }
    .bg-soft-success { background-color: rgba(39, 174, 96, 0.1); }
    .bg-soft-danger { background-color: rgba(231, 76, 60, 0.1); }
    .bg-soft-info { background-color: rgba(41, 128, 185, 0.1); }
    
    .fsmall { font-size: 0.75rem; }
    
    /* Stats Widgets */
    .stat-widget .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 1rem;
    }
    /* --- MODAL GLASSMORPHISM --- */
    .modal-content.glass-modal {
        background: rgba(255, 255, 255, 0.85) !important;
        backdrop-filter: blur(15px) saturate(180%);
        -webkit-backdrop-filter: blur(15px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
        border-radius: 15px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
    }
    .modal-header { border-bottom: 1px solid rgba(0,0,0,0.05); }
    .modal-footer { border-top: 1px solid rgba(0,0,0,0.05); }

    /* --- PREMIUM ACTION BUTTONS --- */
    .btn-action {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-action:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    
    .btn-soft-primary { background: rgba(6, 96, 156, 0.1); color: var(--primary); border: none; }
    .btn-soft-warning { background: rgba(243, 156, 18, 0.1); color: var(--warning); border: none; }
    .btn-soft-danger { background: rgba(231, 76, 60, 0.1); color: var(--danger); border: none; }
    .btn-soft-info { background: rgba(41, 128, 185, 0.1); color: var(--info); border: none; }
    
    .btn-soft-primary:hover { background: var(--primary); color: white; }
    .btn-soft-warning:hover { background: var(--warning); color: white; }
    .btn-soft-danger:hover { background: var(--danger); color: white; }
    .btn-soft-info:hover { background: var(--info); color: white; }
  </style>

  @stack('styles')
</head>

<body class="bg-light">
  <!-- Backdrop for mobile sidebar -->
  <div class="sidebar-backdrop"></div>

  <!-- Wrapper -->
  <div class="wrapper">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="main-content">
      <!-- Navbar -->
      @include('layouts.navbar')

      <!-- Content -->
      <main class="content">
        <div class="container-fluid">
          @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
              <i class="fas fa-check-circle me-2 fs-5"></i>
              <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif

          @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
              <i class="fas fa-exclamation-triangle me-2 fs-5"></i>
              <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif

          @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
              <i class="fas fa-exclamation-circle me-2 fs-5"></i>
              <ul class="mb-0 ps-2">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif

          @yield('content')
        </div>
      </main>

      <!-- Footer -->
      @include('layouts.footer')
    </div>
  </div>
  {{-- Library JavaScript Pihak Ketiga --}}
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    // Semua skrip dijalankan setelah DOM siap menggunakan jQuery.
    $(document).ready(function () {

      NProgress.configure({ showSpinner: false });

      // Mulai loading bar saat halaman mulai dimuat
      NProgress.start();

      // Selesaikan loading bar setelah semua elemen halaman (termasuk gambar) selesai dimuat
      $(window).on('load', function () {
        NProgress.done();
      });
      $(document).on('click', 'a[href]:not([href^="#"]):not([target="_blank"])', function (e) {
        // Jika user menekan Ctrl atau Cmd (untuk membuka di tab baru), jangan tampilkan bar
        if (e.ctrlKey || e.metaKey) {
          return;
        }
        NProgress.start();
      });

      // Tampilkan loading bar setiap kali form di-submit
      $(document).on('submit', 'form', function () {
        NProgress.start();
      });
      // --- AUTO-CLOSE SUCCESS ALERT ---
      const successAlert = document.querySelector('.alert-success');
      if (successAlert) {
        setTimeout(() => {
          const bsAlert = new bootstrap.Alert(successAlert);
          bsAlert.close();
        }, 3000);
      }


      // --- GLOBAL AJAX ERROR HANDLING ---
      $(document).ajaxError(function (event, jqxhr, settings, thrownError) {
        if (jqxhr.status === 419) { // CSRF token mismatch
          Swal.fire({
            title: 'Sesi Habis',
            text: 'Sesi Anda telah berakhir. Harap segarkan halaman.',
            icon: 'warning',
            confirmButtonText: 'Segarkan Halaman'
          }).then(() => {
            window.location.reload();
          });
        } else if (jqxhr.status >= 500) { // Server Error
          Swal.fire({
            title: 'Kesalahan Server',
            text: 'Terjadi kesalahan tak terduga di server. Silakan coba lagi nanti.',
            icon: 'error'
          });
        }
      });


      // --- SIDEBAR LOGIC ---
      const sidebar = $('.sidebar');
      const sidebarBackdrop = $('.sidebar-backdrop');
      let touchStartX = 0;
      let touchEndX = 0;

      // Tampilkan sidebar
      $('#sidebarToggle').on('click', function () {
        sidebar.addClass('show');
        sidebarBackdrop.fadeIn(300);
        $('body').css('overflow', 'hidden');
      });

      // Fungsi untuk menyembunyikan sidebar
      function hideSidebar() {
        sidebar.removeClass('show');
        sidebarBackdrop.fadeOut(300);
        $('body').css('overflow', '');
      }

      // Sembunyikan sidebar saat klik tombol close atau backdrop
      $('#sidebarClose, .sidebar-backdrop').on('click', hideSidebar);

      // --- SWIPE TO CLOSE GESTURE ---
      document.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
      }, {passive: true});

      document.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
      }, {passive: true});

      function handleSwipe() {
        // Jika sidebar terbuka dan swipe ke kiri (minimal 50px)
        if (sidebar.hasClass('show') && touchEndX < touchStartX - 50) {
          hideSidebar();
        }
      }


      // --- SIDEBAR ACTIVE LINK ---
      const currentPath = window.location.pathname;
      $('.sidebar-link').each(function () {
        const link = $(this);
        if (link.attr('href') === currentPath) {
          link.addClass('active');
          const parentCollapse = link.closest('.collapse');
          if (parentCollapse.length) {
            parentCollapse.addClass('show');
            // Tandai juga link parent-nya sebagai aktif
            parentCollapse.prev('.sidebar-link').addClass('active');
          }
        }
      });

      // Menutup submenu lain saat satu submenu dibuka
      $('.sidebar-link[data-bs-toggle="collapse"]').on('click', function () {
        const targetCollapse = $($(this).attr('href'));
        $('.collapse.show').not(targetCollapse).each(function () {
          const bsCollapse = new bootstrap.Collapse(this, { toggle: false });
          bsCollapse.hide();
        });
      });

    });
  </script>
  @stack('scripts')
</body>

</html>