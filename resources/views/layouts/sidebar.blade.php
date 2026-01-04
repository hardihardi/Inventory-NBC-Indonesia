<div class="sidebar glass-sidebar">
  {{-- ========== HEADER ========== --}}
  <div class="sidebar-header p-3 d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center">
      <div class="p-2 bg-white rounded-circle me-2 shadow-sm" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
        <img src="{{ $company->logo ? asset('storage/' . $company->logo) : asset('logo.png') }}" alt="Logo" style="width: 35px; height: 35px; object-fit: contain;">
      </div>
      <div class="d-flex flex-column">
        <span class="fw-bold text-white text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px;">{{ $company->name }}</span>
        <small class="text-white-50" style="font-size: 0.65rem;">System Inventory</small>
      </div>
    </div>
    <button class="btn btn-sm btn-close-white d-lg-none" id="sidebarClose">
      <i class="fas fa-times"></i>
    </button>
  </div>
  <div class="sidebar-divider"></div>

  <div class="sidebar-menu p-1">
    
    {{-- ========================================== --}}
    {{-- SECTION: UTAMA --}}
    {{-- ========================================== --}}
    
    {{-- Dashboard --}}
    <div class="sidebar-item">
      <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <span class="sidebar-icon"><i class="fas fa-home"></i></span>
        <span class="sidebar-text">Dashboard</span>
      </a>
    </div>

    {{-- Quick Scanner (Mobile Feature) --}}
    @if(Auth::user()->hasPermission('inventory.scanner'))
    <div class="sidebar-item">
      <a href="{{ route('inventory.scanner') }}" class="sidebar-link {{ request()->routeIs('inventory.scanner') ? 'active' : '' }}">
        <span class="sidebar-icon"><i class="fas fa-qrcode"></i></span>
        <span class="sidebar-text">Quick Scan</span>
        <span class="badge bg-success ms-auto" style="font-size: 0.55rem;">MOBILE</span>
      </a>
    </div>
    @endif


    {{-- ========================================== --}}
    {{-- SECTION: INVENTORY --}}
    {{-- ========================================== --}}
    @if(Auth::user()->hasPermission('inventory.view') || Auth::user()->hasPermission('production.view'))
    <div class="sidebar-section-title">
      <span>INVENTORY</span>
    </div>
    @endif

    {{-- Master Data --}}
    @if(Auth::user()->hasPermission('inventory.view'))
    <div class="sidebar-item">
      <a href="#inventoryMenu" class="sidebar-link {{ request()->is('inventory/items*', 'inventory/categories*', 'inventory/units*', 'inventory/customers*', 'inventory/suppliers*') ? '' : 'collapsed' }}" data-bs-toggle="collapse">
        <span class="sidebar-icon"><i class="fas fa-database"></i></span>
        <span class="sidebar-text">Master Data</span>
        <span class="ms-auto"><i class="fas fa-chevron-down sidebar-chevron"></i></span>
      </a>
      <div class="collapse {{ request()->is('inventory/items*', 'inventory/categories*', 'inventory/units*', 'inventory/customers*', 'inventory/suppliers*') ? 'show' : '' }}" id="inventoryMenu">
        <div class="sidebar-submenu">
          <a href="{{ route('inventory.items.index') }}" class="sidebar-link {{ request()->routeIs('inventory.items.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-box"></i></span>
            <span class="sidebar-text">Produk</span>
          </a>
          @if(Auth::user()->hasPermission('master.categories') || Auth::user()->hasPermission('inventory.view'))
          <a href="{{ route('inventory.categories.index') }}" class="sidebar-link {{ request()->routeIs('inventory.categories.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-tags"></i></span>
            <span class="sidebar-text">Kategori</span>
          </a>
          @endif
          @if(Auth::user()->hasPermission('master.units') || Auth::user()->hasPermission('inventory.view'))
          <a href="{{ route('inventory.units.index') }}" class="sidebar-link {{ request()->routeIs('inventory.units.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-ruler"></i></span>
            <span class="sidebar-text">Satuan</span>
          </a>
          @endif
          @if(Auth::user()->hasPermission('master.suppliers') || Auth::user()->hasPermission('purchase.view'))
          <a href="{{ route('inventory.suppliers.index') }}" class="sidebar-link {{ request()->routeIs('inventory.suppliers.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-truck"></i></span>
            <span class="sidebar-text">Supplier</span>
          </a>
          @endif
          @if(Auth::user()->hasPermission('master.customers') || Auth::user()->hasPermission('sales.view'))
          <a href="{{ route('inventory.customers.index') }}" class="sidebar-link {{ request()->routeIs('inventory.customers.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-users"></i></span>
            <span class="sidebar-text">Customer</span>
          </a>
          @endif
        </div>

      </div>
    </div>
    @endif

    {{-- Gudang & Stok --}}
    @if(Auth::user()->hasPermission('warehouse.manage') || Auth::user()->hasPermission('adjustment.create') || Auth::user()->hasPermission('transfer.create') || Auth::user()->hasPermission('inventory.view'))
    <div class="sidebar-item">
      <a href="#warehouseMenu" class="sidebar-link {{ request()->is('inventory/warehouses*', 'inventory/adjustments*', 'inventory/transfers*', 'inventory/stock-ledger*') ? '' : 'collapsed' }}" data-bs-toggle="collapse">
        <span class="sidebar-icon"><i class="fas fa-warehouse"></i></span>
        <span class="sidebar-text">Gudang & Stok</span>
        <span class="ms-auto"><i class="fas fa-chevron-down sidebar-chevron"></i></span>
      </a>
      <div class="collapse {{ request()->is('inventory/warehouses*', 'inventory/adjustments*', 'inventory/transfers*', 'inventory/stock-ledger*') ? 'show' : '' }}" id="warehouseMenu">
        <div class="sidebar-submenu">
          @if(Auth::user()->hasPermission('warehouse.manage') || Auth::user()->hasPermission('master.warehouses'))
          <a href="{{ route('inventory.warehouses.index') }}" class="sidebar-link {{ request()->routeIs('inventory.warehouses.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-building"></i></span>
            <span class="sidebar-text">Daftar Gudang</span>
          </a>
          @endif
          @if(Auth::user()->hasPermission('adjustment.create') || Auth::user()->hasPermission('adjustment.approve') || Auth::user()->hasPermission('warehouse.manage'))
          <a href="{{ route('inventory.adjustments.index') }}" class="sidebar-link {{ request()->routeIs('inventory.adjustments.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-sliders-h"></i></span>
            <span class="sidebar-text">Penyesuaian Stok</span>
          </a>
          @endif
          @if(Auth::user()->hasPermission('transfer.create') || Auth::user()->hasPermission('transfer.approve') || Auth::user()->hasPermission('warehouse.manage'))
          <a href="{{ route('inventory.transfers.index') }}" class="sidebar-link {{ request()->routeIs('inventory.transfers.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-exchange-alt"></i></span>
            <span class="sidebar-text">Transfer Stok</span>
          </a>
          @endif
          {{-- Laporan Stok Moved to Reports Section --}}
        </div>
      </div>
    </div>
    @endif

    {{-- Permintaan Material (PPIC) --}}
    @if(Auth::user()->hasPermission('production.view'))
    <div class="sidebar-item">
      <a href="{{ route('inventory.production.index') }}" class="sidebar-link {{ request()->routeIs('inventory.production.*') ? 'active' : '' }}">
        <span class="sidebar-icon"><i class="fas fa-file-signature"></i></span>
        <span class="sidebar-text">Permintaan Material</span>
      </a>
    </div>
    @endif

    {{-- ========================================== --}}
    {{-- SECTION: TRANSAKSI --}}
    {{-- ========================================== --}}
    @if(Auth::user()->hasPermission('sales.view') || Auth::user()->hasPermission('purchase.view'))
    <div class="sidebar-section-title">
      <span>TRANSAKSI</span>
    </div>
    @endif

    {{-- Penjualan --}}
    @if(Auth::user()->hasPermission('sales.view'))
    <div class="sidebar-item">
      <a href="#salesMenu" class="sidebar-link {{ request()->is('penjualan*') ? '' : 'collapsed' }}" data-bs-toggle="collapse">
        <span class="sidebar-icon"><i class="fas fa-cash-register"></i></span>
        <span class="sidebar-text">Penjualan</span>
        <span class="ms-auto"><i class="fas fa-chevron-down sidebar-chevron"></i></span>
      </a>
      <div class="collapse {{ request()->is('penjualan*') ? 'show' : '' }}" id="salesMenu">
        <div class="sidebar-submenu">
          @if(Auth::user()->hasPermission('sales.create'))
          <a href="{{ route('penjualan.transaksi.create') }}" class="sidebar-link {{ request()->routeIs('penjualan.transaksi.create') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-plus-circle"></i></span>
            <span class="sidebar-text">Transaksi Baru</span>
          </a>
          @endif
          <a href="{{ route('penjualan.transaksi.index') }}" class="sidebar-link {{ request()->routeIs('penjualan.transaksi.index') || request()->routeIs('penjualan.transaksi.show') || request()->routeIs('penjualan.transaksi.edit') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-receipt"></i></span>
            <span class="sidebar-text">Daftar Penjualan</span>
          </a>
          @if(Auth::user()->hasPermission('sales.return'))
          <a href="{{ route('penjualan.retur.index') }}" class="sidebar-link {{ request()->routeIs('penjualan.retur.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-undo-alt"></i></span>
            <span class="sidebar-text">Retur Penjualan</span>
          </a>
          @endif
        </div>
      </div>
    </div>
    @endif

    {{-- Pembelian --}}
    @if(Auth::user()->hasPermission('purchase.view'))
    <div class="sidebar-item">
      <a href="#purchaseMenu" class="sidebar-link {{ request()->is('pembelian*', 'retur-pembelian*') ? '' : 'collapsed' }}" data-bs-toggle="collapse">
        <span class="sidebar-icon"><i class="fas fa-shopping-basket"></i></span>
        <span class="sidebar-text">Pembelian</span>
        <span class="ms-auto"><i class="fas fa-chevron-down sidebar-chevron"></i></span>
      </a>
      <div class="collapse {{ request()->is('pembelian*', 'retur-pembelian*') ? 'show' : '' }}" id="purchaseMenu">
        <div class="sidebar-submenu">
          @if(Auth::user()->hasPermission('purchase.create'))
          <a href="{{ route('pembelian.create') }}" class="sidebar-link {{ request()->routeIs('pembelian.create') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-plus-circle"></i></span>
            <span class="sidebar-text">Pembelian Baru</span>
          </a>
          @endif
          <a href="{{ route('pembelian.index') }}" class="sidebar-link {{ request()->routeIs('pembelian.index') || request()->routeIs('pembelian.show') || request()->routeIs('pembelian.edit') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-file-invoice"></i></span>
            <span class="sidebar-text">Daftar Pembelian</span>
          </a>
          @if(Auth::user()->hasPermission('purchase.return'))
          <a href="{{ route('retur-pembelian.index') }}" class="sidebar-link {{ request()->routeIs('retur-pembelian.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-undo-alt"></i></span>
            <span class="sidebar-text">Retur Pembelian</span>
          </a>
          @endif
        </div>
      </div>
    </div>
    @endif

    {{-- ========================================== --}}
    {{-- SECTION: KEUANGAN & LAPORAN --}}
    {{-- ========================================== --}}
    @if(Auth::user()->hasPermission('finance.view') || Auth::user()->hasPermission('reports.view'))
    <div class="sidebar-section-title">
      <span>KEUANGAN</span>
    </div>
    @endif

    {{-- Keuangan --}}
    @if(Auth::user()->hasPermission('finance.view'))
    <div class="sidebar-item">
      <a href="#financeMenu" class="sidebar-link {{ request()->is('finance*') ? '' : 'collapsed' }}" data-bs-toggle="collapse">
        <span class="sidebar-icon"><i class="fas fa-wallet"></i></span>
        <span class="sidebar-text">Keuangan</span>
        <span class="ms-auto"><i class="fas fa-chevron-down sidebar-chevron"></i></span>
      </a>
      <div class="collapse {{ request()->is('finance*') ? 'show' : '' }}" id="financeMenu">
        <div class="sidebar-submenu">
          <a href="{{ route('finance.dashboard') }}" class="sidebar-link {{ request()->routeIs('finance.dashboard') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-chart-pie"></i></span>
            <span class="sidebar-text">Ringkasan</span>
          </a>
          @if(Auth::user()->hasPermission('finance.cashflow'))
          <a href="{{ route('finance.cash-flow') }}" class="sidebar-link {{ request()->routeIs('finance.cash-flow') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-money-bill-wave"></i></span>
            <span class="sidebar-text">Arus Kas</span>
          </a>
          @endif
          @if(Auth::user()->hasPermission('finance.receivable'))
          <a href="{{ route('finance.receivables') }}" class="sidebar-link {{ request()->routeIs('finance.receivables') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-hand-holding-usd"></i></span>
            <span class="sidebar-text">Piutang</span>
          </a>
          @endif
          @if(Auth::user()->hasPermission('finance.payable'))
          <a href="{{ route('finance.payables') }}" class="sidebar-link {{ request()->routeIs('finance.payables') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-file-invoice-dollar"></i></span>
            <span class="sidebar-text">Hutang</span>
          </a>
          @endif
          @if(Auth::user()->hasPermission('expense.manage'))
          <a href="{{ route('finance.expenses.index') }}" class="sidebar-link {{ request()->routeIs('finance.expenses.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-receipt"></i></span>
            <span class="sidebar-text">Pengeluaran</span>
          </a>
          @endif
        </div>
      </div>
    </div>
    @endif

    {{-- Laporan --}}
    @if(Auth::user()->hasPermission('reports.view'))
    <div class="sidebar-item">
      <a href="#reportsMenu" class="sidebar-link {{ request()->is('reports*', 'inventory/stock-ledger*') ? '' : 'collapsed' }}" data-bs-toggle="collapse">
        <span class="sidebar-icon"><i class="fas fa-chart-bar"></i></span>
        <span class="sidebar-text">Laporan</span>
        <span class="ms-auto"><i class="fas fa-chevron-down sidebar-chevron"></i></span>
      </a>
      <div class="collapse {{ request()->is('reports*', 'inventory/stock-ledger*') ? 'show' : '' }}" id="reportsMenu">
        <div class="sidebar-submenu">
          @if(Auth::user()->hasPermission('stock.ledger'))
          <a href="{{ route('inventory.stock_ledger.summary') }}" class="sidebar-link {{ request()->is('inventory/stock-ledger*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-file-invoice"></i></span>
            <span class="sidebar-text">Laporan Stok</span>
          </a>
          @endif
          @if(Auth::user()->hasPermission('sales.report'))
          <a href="{{ route('reports.daily_sales') }}" class="sidebar-link {{ request()->routeIs('reports.daily_sales') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-calendar-day"></i></span>
            <span class="sidebar-text">Penjualan Harian</span>
          </a>
          <a href="{{ route('reports.monthly_sales') }}" class="sidebar-link {{ request()->routeIs('reports.monthly_sales') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-calendar-alt"></i></span>
            <span class="sidebar-text">Penjualan Bulanan</span>
          </a>
          @endif
          @if(Auth::user()->hasPermission('reports.profit_loss'))
          <a href="{{ route('reports.profit_loss') }}" class="sidebar-link {{ request()->routeIs('reports.profit_loss') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-balance-scale"></i></span>
            <span class="sidebar-text">Laba Rugi</span>
          </a>
          @endif
          @if(Auth::user()->hasPermission('reports.valuation'))
          <a href="{{ route('reports.valuation.index') }}" class="sidebar-link {{ request()->routeIs('reports.valuation.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-coins"></i></span>
            <span class="sidebar-text">Valuasi Stok</span>
          </a>
          @endif
          @if(Auth::user()->hasPermission('reports.turnover'))
          <a href="{{ route('reports.turnover') }}" class="sidebar-link {{ request()->routeIs('reports.turnover') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-sync-alt"></i></span>
            <span class="sidebar-text">Analisis Turnover</span>
          </a>
          @endif
        </div>

      </div>
    </div>
    @endif

    {{-- ========================================== --}}
    {{-- SECTION: PENGATURAN --}}
    {{-- ========================================== --}}
    @if(Auth::user()->role === 'admin' || Auth::user()->hasPermission('settings.users') || Auth::user()->hasPermission('settings.rbac') || Auth::user()->hasPermission('settings.company') || Auth::user()->hasPermission('settings.logs'))
    <div class="sidebar-section-title">
      <span>SISTEM</span>
    </div>

    <div class="sidebar-item">
      <a href="#settingsMenu" class="sidebar-link {{ request()->is('settings*') ? '' : 'collapsed' }}" data-bs-toggle="collapse">
        <span class="sidebar-icon"><i class="fas fa-cog"></i></span>
        <span class="sidebar-text">Pengaturan</span>
        <span class="ms-auto"><i class="fas fa-chevron-down sidebar-chevron"></i></span>
      </a>
      <div class="collapse {{ request()->is('settings*') ? 'show' : '' }}" id="settingsMenu">
        <div class="sidebar-submenu">
          @if(Auth::user()->hasPermission('settings.users'))
          <a href="{{ route('settings.users.index') }}" class="sidebar-link {{ request()->routeIs('settings.users.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-user-cog"></i></span>
            <span class="sidebar-text">Pengguna</span>
          </a>
          @endif
          @if(Auth::user()->hasPermission('settings.rbac'))
          <a href="{{ route('settings.roles.index') }}" class="sidebar-link {{ request()->routeIs('settings.roles.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-user-shield"></i></span>
            <span class="sidebar-text">Hak Akses</span>
          </a>
          @endif
          @if(Auth::user()->hasPermission('settings.company'))
          <a href="{{ route('settings.company.index') }}" class="sidebar-link {{ request()->routeIs('settings.company.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-building"></i></span>
            <span class="sidebar-text">Perusahaan</span>
          </a>
          @endif
          @if(Auth::user()->hasPermission('settings.logs'))
          <a href="{{ route('settings.activity-logs.index') }}" class="sidebar-link {{ request()->routeIs('settings.activity-logs.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-history"></i></span>
            <span class="sidebar-text">Log Aktivitas</span>
          </a>
          @endif
          @if(Auth::user()->hasPermission('system.tools'))
          <a href="{{ route('settings.system.index') }}" class="sidebar-link {{ request()->routeIs('settings.system.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-tools"></i></span>
            <span class="sidebar-text">Sistem & Database</span>
          </a>
          @endif
          @if(Auth::user()->hasPermission('settings.trash'))
          <a href="{{ route('settings.trash.index') }}" class="sidebar-link {{ request()->routeIs('settings.trash.*') ? 'active' : '' }}">
            <span class="sidebar-icon"><i class="fas fa-trash-restore"></i></span>
            <span class="sidebar-text">Pusat Pemulihan</span>
          </a>
          @endif
        </div>
      </div>
    </div>
    @endif

    {{-- ========================================== --}}
    {{-- SECTION: PORTAL MITRA --}}
    {{-- ========================================== --}}
    @if(Auth::user()->role === 'supplier')
    <div class="sidebar-section-title">
      <span>PORTAL</span>
    </div>
    <div class="sidebar-item">
      <a href="{{ route('portal.supplier.dashboard') }}" class="sidebar-link {{ request()->routeIs('portal.supplier.*') ? 'active' : '' }}">
        <span class="sidebar-icon"><i class="fas fa-store"></i></span>
        <span class="sidebar-text">Portal Supplier</span>
      </a>
    </div>
    @endif

    @if(Auth::user()->role === 'customer')
    <div class="sidebar-section-title">
      <span>PORTAL</span>
    </div>
    <div class="sidebar-item">
      <a href="{{ route('portal.customer.dashboard') }}" class="sidebar-link {{ request()->routeIs('portal.customer.*') ? 'active' : '' }}">
        <span class="sidebar-icon"><i class="fas fa-user-circle"></i></span>
        <span class="sidebar-text">Portal Pelanggan</span>
      </a>
    </div>
    @endif

    </div>

    {{-- PUSAT BANTUAN --}}
    <div class="mt-auto px-3 py-4">
        <hr class="border-white opacity-10 mb-4">
        <a href="{{ route('help.index') }}" class="btn btn-outline-light w-100 text-start border-0 py-2 rounded-3 mb-2 help-link">
            <i class="fas fa-question-circle me-3 text-info"></i>
            <span class="small fw-bold">Pusat Bantuan</span>
        </a>
    </div>
</div>

{{-- Sidebar Section Title Styles --}}
<style>
.sidebar-section-title {
  padding: 12px 16px 6px 16px;
  margin-top: 8px;
}
.sidebar-section-title span {
  font-size: 0.65rem;
  font-weight: 700;
  letter-spacing: 1.5px;
  color: rgba(255, 255, 255, 0.4);
  text-transform: uppercase;
}
.sidebar-chevron {
  font-size: 0.7rem;
  transition: transform 0.2s ease;
}
.sidebar-link.collapsed .sidebar-chevron {
  transform: rotate(-90deg);
}
.sidebar-link:not(.collapsed) .sidebar-chevron {
  transform: rotate(0deg);
}
</style>