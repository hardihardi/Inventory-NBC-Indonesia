<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleReturnController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ReturPembelianController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Settings\UserController;
use App\Http\Controllers\Settings\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PortalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Awal & Rute Otentikasi
Route::get('/', fn() => view('auth.login'))->middleware('guest');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Lupa Password
Route::get('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'reset'])->name('password.update');

// Rute yang Dilindungi Otentikasi
Route::middleware(['auth'])->group(function () {

    // MENJADI INI:
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- USER PROFILE ---
    Route::get('/profile', [App\Http\Controllers\Settings\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\Settings\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\Settings\ProfileController::class, 'updatePassword'])->name('profile.password');

    // --- MODUL INVENTORY (Semua Role kecuali Customer/Supplier) ---
    Route::middleware(['role:admin,manajer,finance,staff_gudang,kepala_gudang,produksi'])->prefix('inventory')->name('inventory.')->group(function () {
        Route::get('items/export', [ItemController::class, 'export'])->name('items.export');
        Route::post('items/import-csv', [ItemController::class, 'importCsv'])->name('items.import_csv');
        Route::post('items/import', [ItemController::class, 'import'])->name('items.import');
        Route::get('items/print-labels', [ItemController::class, 'printLabels'])->name('items.print_labels');
        Route::get('items/generate-codes', [ItemController::class, 'generateCodes'])->name('items.generate_codes');
        Route::get('items/download-template', [ItemController::class, 'downloadTemplate'])->name('items.download_template');

        Route::resource('items', ItemController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('customers', CustomerController::class);
        Route::resource('units', UnitController::class);
        Route::resource('suppliers', SupplierController::class);

        // Warehouses, Adjustments, Transfers (Shared access)
        Route::resource('warehouses', App\Http\Controllers\Inventory\WarehouseController::class);
        
        Route::prefix('adjustments')->name('adjustments.')->group(function () {
            Route::post('{adjustment}/approve-l1', [App\Http\Controllers\Inventory\StockAdjustmentController::class, 'approveLevel1'])->name('approve_l1');
            Route::post('{adjustment}/approve-final', [App\Http\Controllers\Inventory\StockAdjustmentController::class, 'approveFinal'])->name('approve_final');
            Route::post('{adjustment}/reject', [App\Http\Controllers\Inventory\StockAdjustmentController::class, 'reject'])->name('reject');
        });
        Route::resource('adjustments', App\Http\Controllers\Inventory\StockAdjustmentController::class);

        Route::prefix('transfers')->name('transfers.')->group(function () {
            Route::post('{transfer}/approve', [App\Http\Controllers\Inventory\StockTransferController::class, 'approve'])->name('approve');
            Route::post('{transfer}/reject', [App\Http\Controllers\Inventory\StockTransferController::class, 'reject'])->name('reject');
        });
        Route::resource('transfers', App\Http\Controllers\Inventory\StockTransferController::class);

        // --- AUDIT & REPORTING ROUTES ---
        Route::get('stock-ledger', [App\Http\Controllers\Inventory\StockLedgerController::class, 'index'])->name('stock_ledger.index');
        Route::get('stock-ledger/summary', [App\Http\Controllers\Inventory\StockLedgerController::class, 'summary'])->name('stock_ledger.summary');
        Route::get('stock-ledger/item/{item}', [App\Http\Controllers\Inventory\StockLedgerController::class, 'itemCard'])->name('stock_ledger.item_card');
        Route::get('stock-ledger/export-summary', [App\Http\Controllers\Inventory\StockLedgerController::class, 'exportSummary'])->name('stock_ledger.export_summary');
        
        // --- MODUL SCANNER & QR ---
        Route::get('scanner', [App\Http\Controllers\ScannerController::class, 'index'])->name('scanner');
        Route::post('scanner/scan-result', [App\Http\Controllers\ScannerController::class, 'scanResult'])->name('scanner.result');

        // --- PRODUCTION ---
        Route::get('production/stock-check', [App\Http\Controllers\ProductionController::class, 'stockCheck'])->name('production.stock_check');
        Route::post('production/{production}/complete', [App\Http\Controllers\ProductionController::class, 'complete'])->name('production.complete');
        Route::resource('production', App\Http\Controllers\ProductionController::class);
    });

    // --- MODUL PENJUALAN & PEMBELIAN (Admin, Staff Gudang, Finance) ---
    Route::middleware(['role:admin,staff_gudang,finance'])->group(function () {
        Route::prefix('penjualan')->name('penjualan.')->group(function () {
            Route::get('transaksi/export', [SaleController::class, 'export'])->name('transaksi.export');
            Route::post('transaksi/import-csv', [SaleController::class, 'importCsv'])->name('transaksi.import_csv');
            Route::get('transaksi/{transaksi}/print', [SaleController::class, 'printReceipt'])->name('transaksi.print_receipt');
            Route::resource('transaksi', SaleController::class);
            Route::resource('retur', SaleReturnController::class);
        });

        // --- MODUL PEMBELIAN ---
        Route::get('pembelian/export', [PembelianController::class, 'export'])->name('pembelian.export');
        Route::post('pembelian/import-csv', [PembelianController::class, 'importCsv'])->name('pembelian.import_csv');
        Route::get('pembelian/generate-invoice-number', [PembelianController::class, 'generateInvoiceAjax'])->name('pembelian.generate_invoice_number');
        Route::post('pembelian/{pembelian}/generate-invoice', [PembelianController::class, 'saveGeneratedInvoice'])->name('pembelian.save_generated_invoice');
        Route::resource('pembelian', PembelianController::class);
        Route::get('/pembelian/{pembelian}/items', [ReturPembelianController::class, 'getPembelianItems']);
        Route::resource('retur-pembelian', ReturPembelianController::class);
        
        // --- FINANCE & PENGELUARAN ---
        Route::prefix('finance')->name('finance.')->group(function () {
             Route::get('dashboard', [App\Http\Controllers\FinanceController::class, 'dashboard'])->name('dashboard');
             Route::get('cash-flow', [App\Http\Controllers\FinanceController::class, 'cashFlow'])->name('cash-flow');
             Route::get('receivables', [App\Http\Controllers\FinanceController::class, 'receivables'])->name('receivables');
             Route::get('payables', [App\Http\Controllers\FinanceController::class, 'payables'])->name('payables');
             Route::resource('expenses', \App\Http\Controllers\ExpenseController::class);
        });
    });

    // --- MODUL LAPORAN (Admin, Manajer, Finance) ---
    Route::middleware(['role:admin,manajer,finance'])->prefix('reports')->name('reports.')->group(function () {
        Route::get('/daily-sales', [ReportController::class, 'dailySales'])->name('daily_sales');
        Route::get('/monthly-sales', [ReportController::class, 'monthlySales'])->name('monthly_sales');
        Route::get('/profit-loss', [ReportController::class, 'profitLoss'])->name('profit_loss');
        
        // Rute untuk mencetak laporan
        Route::get('/print/daily-sales', [ReportController::class, 'printDailySales'])->name('print_daily_sales');
        Route::get('/print/monthly-sales', [ReportController::class, 'printMonthlySales'])->name('print_monthly_sales');
        Route::get('/print/profit-loss', [ReportController::class, 'printProfitLoss'])->name('print_profit_loss');

        // --- VALUATION REPORT ---
        Route::get('/valuation', [App\Http\Controllers\Report\ValuationController::class, 'index'])->name('valuation.index');
        Route::get('/valuation/print', [App\Http\Controllers\Report\ValuationController::class, 'print'])->name('valuation.print');
        Route::get('/valuation/export', [App\Http\Controllers\Report\ValuationController::class, 'exportExcel'])->name('valuation.export');

        // --- TURNOVER REPORT ---
        Route::get('/turnover', [ReportController::class, 'turnover'])->name('turnover');
    });

    // --- MODUL PENGATURAN ---
    Route::middleware(['role:admin'])->prefix('settings')->name('settings.')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('activity-logs', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-logs.index');
        Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
        Route::get('/company/edit', [CompanyController::class, 'edit'])->name('company.edit');
        Route::put('/company/update', [CompanyController::class, 'update'])->name('company.update');
        
        // --- SYSTEM TOOLS ---
        Route::get('system', [App\Http\Controllers\Settings\SystemController::class, 'index'])->name('system.index');
        Route::post('system/cache', [App\Http\Controllers\Settings\SystemController::class, 'clearCache'])->name('system.cache');
        Route::post('system/backup', [App\Http\Controllers\Settings\SystemController::class, 'backupDatabase'])->name('system.backup');
        
        // --- TRASH / RESTORE CENTER ---
        Route::get('trash', [App\Http\Controllers\Settings\TrashController::class, 'index'])->name('trash.index')->middleware('permission:settings.trash');
        Route::post('trash/{type}/{id}/restore', [App\Http\Controllers\Settings\TrashController::class, 'restore'])->name('trash.restore')->middleware('permission:settings.trash');
        Route::delete('trash/{type}/{id}/force', [App\Http\Controllers\Settings\TrashController::class, 'forceDelete'])->name('trash.force_delete')->middleware('permission:settings.trash');
        
        // --- ROLE & PERMISSIONS ---
        Route::get('roles', [App\Http\Controllers\Settings\RoleController::class, 'index'])->name('roles.index')->middleware('permission:settings.rbac');
        Route::put('roles', [App\Http\Controllers\Settings\RoleController::class, 'update'])->name('roles.update')->middleware('permission:settings.rbac');
    });

    // --- PAYMENTS (Settling Debt/Receivable) ---
    Route::post('payments', [App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store')->middleware('role:admin,staff_gudang,finance');

    // --- GLOBAL SEARCH & HELP ---
    Route::get('/search', [SearchController::class, 'index'])->name('global.search');
    Route::get('/help', [App\Http\Controllers\HelpController::class, 'index'])->name('help.index');

    // --- PORTALS ---
    Route::middleware(['role:supplier'])->prefix('portal/supplier')->name('portal.supplier.')->group(function () {
        Route::get('/dashboard', [PortalController::class, 'supplierDashboard'])->name('dashboard');
    });

    Route::middleware(['role:customer'])->prefix('portal/customer')->name('portal.customer.')->group(function () {
        Route::get('/dashboard', [PortalController::class, 'customerDashboard'])->name('dashboard');
    });
});