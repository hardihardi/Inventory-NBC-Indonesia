<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;

class TextileRBACSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Reset existing permissions and assignments
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_permissions')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Define all Permissions
        $permissionGroups = [
            'Inventory' => [
                ['name' => 'inventory.view', 'description' => 'Melihat Data Produk'],
                ['name' => 'inventory.create', 'description' => 'Tambah Produk'],
                ['name' => 'inventory.edit', 'description' => 'Edit Produk'],
                ['name' => 'inventory.delete', 'description' => 'Hapus/Arsip Produk'],
                ['name' => 'inventory.import', 'description' => 'Import Data Produk'],
                ['name' => 'inventory.label', 'description' => 'Cetak Label/Barcode QR'],
                ['name' => 'inventory.scanner', 'description' => 'Akses Mobile Scanner'],
            ],
            'Master Data' => [
                ['name' => 'master.categories', 'description' => 'Kelola Kategori Produk'],
                ['name' => 'master.units', 'description' => 'Kelola Satuan'],
                ['name' => 'master.suppliers', 'description' => 'Kelola Supplier'],
                ['name' => 'master.customers', 'description' => 'Kelola Pelanggan'],
            ],
            'Transaksi Penjualan' => [
                ['name' => 'sales.view', 'description' => 'Melihat Daftar Penjualan'],
                ['name' => 'sales.create', 'description' => 'Input Penjualan/Scan Keluar'],
                ['name' => 'sales.edit', 'description' => 'Edit Data Penjualan'],
                ['name' => 'sales.delete', 'description' => 'Hapus/Arsip Penjualan'],
                ['name' => 'sales.report', 'description' => 'Melihat Laporan Penjualan'],
                ['name' => 'sales.return', 'description' => 'Kelola Retur Penjualan'],
            ],
            'Transaksi Pembelian' => [
                ['name' => 'purchase.view', 'description' => 'Melihat Daftar Pembelian'],
                ['name' => 'purchase.create', 'description' => 'Input Pembelian/Terima Barang'],
                ['name' => 'purchase.edit', 'description' => 'Edit Data Pembelian'],
                ['name' => 'purchase.delete', 'description' => 'Hapus/Arsip Pembelian'],
                ['name' => 'purchase.approve', 'description' => 'Persetujuan Pembelian Besar'],
                ['name' => 'purchase.return', 'description' => 'Kelola Retur Pembelian'],
            ],
            'Produksi / PPIC' => [
                ['name' => 'production.view', 'description' => 'Melihat Rencana & Request Produksi'],
                ['name' => 'production.create', 'description' => 'Buat Rencana & Permintaan Material'],
                ['name' => 'production.edit', 'description' => 'Update Hasil Barang Jadi'],
                ['name' => 'production.delete', 'description' => 'Batalkan Rencana Produksi'],
                ['name' => 'production.status', 'description' => 'Update Status Produksi'],
            ],
            'Gudang & Stok' => [
                ['name' => 'warehouse.manage', 'description' => 'Kelola Gudang & Lokasi'],
                ['name' => 'adjustment.create', 'description' => 'Input Stock Opname'],
                ['name' => 'adjustment.approve', 'description' => 'Persetujuan Penyesuaian Stok'],
                ['name' => 'transfer.create', 'description' => 'Input Transfer Antar Rak/Gudang'],
                ['name' => 'transfer.approve', 'description' => 'Persetujuan Transfer Stok'],
                ['name' => 'stock.ledger', 'description' => 'Melihat Jurnal/Buku Stok'],
            ],
            'Finance' => [
                ['name' => 'finance.view', 'description' => 'Melihat Dashboard Keuangan'],
                ['name' => 'finance.cashflow', 'description' => 'Melihat Arus Kas (Cash Flow)'],
                ['name' => 'finance.payable', 'description' => 'Mengelola Hutang Supplier'],
                ['name' => 'finance.receivable', 'description' => 'Mengelola Piutang Customer'],
                ['name' => 'expense.manage', 'description' => 'Kelola Biaya Operasional'],
                ['name' => 'payment.process', 'description' => 'Proses & Cetak Bukti Bayar'],
            ],
            'Laporan & Analisis' => [
                ['name' => 'reports.view', 'description' => 'Akses Menu Laporan'],
                ['name' => 'reports.profit_loss', 'description' => 'Melihat Laporan Laba Rugi'],
                ['name' => 'reports.valuation', 'description' => 'Melihat Valuasi Inventaris (Aset)'],
                ['name' => 'reports.turnover', 'description' => 'Analisis Slow/Fast Moving'],
                ['name' => 'reports.performance', 'description' => 'Melihat Kinerja Gudang'],
            ],
            'Sistem & Keamanan' => [
                ['name' => 'settings.company', 'description' => 'Konfigurasi Profil & Dokumen'],
                ['name' => 'settings.users', 'description' => 'Manajemen Akun Karyawan'],
                ['name' => 'settings.rbac', 'description' => 'Manajemen Hak Akses (RBAC)'],
                ['name' => 'settings.logs', 'description' => 'Audit Log / History Aktivitas'],
                ['name' => 'settings.trash', 'description' => 'Akses Pusat Pemulihan (Data Restore)'],
                ['name' => 'system.tools', 'description' => 'Backup Database & System Tools'],
            ],
        ];

        $allPermIds = [];
        foreach ($permissionGroups as $group => $perms) {
            foreach ($perms as $p) {
                $permission = Permission::updateOrCreate(
                    ['name' => $p['name']],
                    ['description' => $p['description'], 'group' => $group]
                );
                $allPermIds[$p['name']] = $permission->id;
            }
        }

        // 3. Define Roles and Assign Permissions
        $roles_permissions = [
            'admin' => array_keys($allPermIds), // Administrator - Full Access
            
            'procurement' => [ // Staff Pengadaan (Procurement & Sales)
                'inventory.view', 'inventory.label',
                'master.suppliers', 'master.customers',
                'purchase.view', 'purchase.create', 'purchase.edit', 'purchase.report', 'purchase.return',
                'sales.view', 'sales.create', 'sales.edit', 'sales.return', 'sales.report',
                'payment.process',
                'finance.view', 'finance.payable', 'finance.receivable',
                'reports.view'
            ],
            
            'finance' => [ // Finance
                'inventory.view',
                'sales.view', 'sales.report',
                'purchase.view', 
                'finance.view', 'finance.cashflow', 'finance.payable', 'finance.receivable', 'expense.manage', 'payment.process', 
                'reports.view', 'reports.profit_loss', 'reports.valuation'
            ],
            
            'kepala_gudang' => [ // Kepala Gudang
                'inventory.view', 'inventory.create', 'inventory.edit', 'inventory.label', 'inventory.scanner',
                'warehouse.manage', 'adjustment.create', 'adjustment.approve', 'transfer.create', 'transfer.approve', 'stock.ledger',
                'sales.view', 'sales.return',
                'purchase.view', 'purchase.create', 'purchase.return',
                'production.view',
                'reports.view', 'reports.turnover', 'reports.performance'
            ],

            'staff_gudang' => [ // Staff Gudang
                'inventory.view', 'inventory.create', 'inventory.edit', 'inventory.label', 'inventory.scanner',
                'master.categories', 'master.units',
                'adjustment.create', 'transfer.create', 'stock.ledger',
                'sales.view', 'sales.create',
                'purchase.view', 'purchase.create',
                'production.view', 'production.status'
            ],
            
            'produksi' => [ // Bagian Produksi / PPIC
                'inventory.view',
                'production.view', 'production.create', 'production.edit', 'production.delete', 'production.status'
            ],
        ];

        foreach ($roles_permissions as $role => $perms) {
            foreach ($perms as $permName) {
                if (isset($allPermIds[$permName])) {
                    DB::table('role_permissions')->insert([
                        'role' => $role,
                        'permission_id' => $allPermIds[$permName],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
