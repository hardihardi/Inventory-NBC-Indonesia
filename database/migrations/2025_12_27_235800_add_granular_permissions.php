<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds granular permissions for Sales, Purchases, Payments, Master Data, and Approvals.
     * Also seeds a sensible default role-permission matrix.
     */
    public function up(): void
    {
        // New permissions to add
        $newPermissions = [
            // Sales
            ['name' => 'sales.view', 'description' => 'Melihat Daftar Penjualan', 'group' => 'Sales'],
            ['name' => 'sales.create', 'description' => 'Buat Transaksi Penjualan Baru', 'group' => 'Sales'],
            ['name' => 'sales.edit', 'description' => 'Edit Transaksi Penjualan', 'group' => 'Sales'],
            ['name' => 'sales.delete', 'description' => 'Hapus/Batalkan Transaksi Penjualan', 'group' => 'Sales'],
            ['name' => 'sales.return', 'description' => 'Proses Retur Penjualan', 'group' => 'Sales'],
            
            // Purchases
            ['name' => 'purchase.view', 'description' => 'Melihat Daftar Pembelian', 'group' => 'Purchase'],
            ['name' => 'purchase.create', 'description' => 'Buat Transaksi Pembelian Baru', 'group' => 'Purchase'],
            ['name' => 'purchase.edit', 'description' => 'Edit Transaksi Pembelian', 'group' => 'Purchase'],
            ['name' => 'purchase.delete', 'description' => 'Hapus/Batalkan Transaksi Pembelian', 'group' => 'Purchase'],
            
            // Payment
            ['name' => 'payment.view', 'description' => 'Melihat Daftar Piutang/Hutang', 'group' => 'Payment'],
            ['name' => 'payment.process', 'description' => 'Mencatat Pelunasan Piutang/Hutang', 'group' => 'Payment'],
            
            // Master Data
            ['name' => 'master.categories', 'description' => 'Kelola Kategori Produk', 'group' => 'Master Data'],
            ['name' => 'master.units', 'description' => 'Kelola Satuan', 'group' => 'Master Data'],
            ['name' => 'master.warehouses', 'description' => 'Kelola Gudang', 'group' => 'Master Data'],
            ['name' => 'master.suppliers', 'description' => 'Kelola Supplier', 'group' => 'Master Data'],
            ['name' => 'master.customers', 'description' => 'Kelola Pelanggan', 'group' => 'Master Data'],
            
            // Approvals
            ['name' => 'approval.adjustment', 'description' => 'Approval Penyesuaian Stok', 'group' => 'Approval'],
            ['name' => 'approval.transfer', 'description' => 'Approval Mutasi Antar Gudang', 'group' => 'Approval'],
            ['name' => 'approval.production', 'description' => 'Approval Permintaan Material', 'group' => 'Approval'],
        ];

        // Insert new permissions, ignoring duplicates
        foreach ($newPermissions as $perm) {
            DB::table('permissions')->insertOrIgnore($perm);
        }

        // --- Default Role-Permission Seeding ---
        // Get all permission IDs for easy lookup
        $allPerms = DB::table('permissions')->pluck('id', 'name');

        // Define default assignments for non-admin roles
        $defaultMatrix = [
            'manajer' => [
                'inventory.view', 'inventory.create', 'inventory.edit', 'inventory.delete',
                'sales.view', 'sales.create', 'sales.edit', 'sales.delete', 'sales.return',
                'purchase.view', 'purchase.create', 'purchase.edit', 'purchase.delete',
                'payment.view', 'payment.process',
                'production.view', 'production.create', 'production.edit', 'production.delete',
                'master.categories', 'master.units', 'master.warehouses', 'master.suppliers', 'master.customers',
                'approval.adjustment', 'approval.transfer', 'approval.production',
                'reports.view', 'settings.view', 'finance.view', 'finance.create',
            ],
            'finance' => [
                'inventory.view',
                'sales.view', 'sales.create', 'sales.edit', 'sales.return',
                'purchase.view', 'purchase.create', 'purchase.edit',
                'payment.view', 'payment.process',
                'master.suppliers', 'master.customers',
                'reports.view', 'finance.view', 'finance.create',
            ],
            'kepala_gudang' => [
                'inventory.view', 'inventory.create', 'inventory.edit', 'inventory.delete',
                'purchase.view', 'purchase.create', 'purchase.edit',
                'production.view', 'production.create', 'production.edit',
                'master.categories', 'master.units', 'master.suppliers',
                'approval.adjustment', 'approval.transfer', 'approval.production',
                'reports.view',
            ],
            'staff_gudang' => [
                'inventory.view', 'inventory.create',
                'purchase.view',
                'production.view',
            ],
            'produksi' => [
                'inventory.view',
                'production.view', 'production.create', 'production.edit',
            ],
        ];

        $inserts = [];
        foreach ($defaultMatrix as $role => $permNames) {
            foreach ($permNames as $permName) {
                if (isset($allPerms[$permName])) {
                    $inserts[] = [
                        'role' => $role,
                        'permission_id' => $allPerms[$permName],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }
        
        // Insert, ignoring any duplicate entries (if user already configured some)
        foreach ($inserts as $insert) {
            DB::table('role_permissions')->insertOrIgnore($insert);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $newPermissionNames = [
            'sales.view', 'sales.create', 'sales.edit', 'sales.delete', 'sales.return',
            'purchase.view', 'purchase.create', 'purchase.edit', 'purchase.delete',
            'payment.view', 'payment.process',
            'master.categories', 'master.units', 'master.warehouses', 'master.suppliers', 'master.customers',
            'approval.adjustment', 'approval.transfer', 'approval.production',
        ];

        $permIds = DB::table('permissions')->whereIn('name', $newPermissionNames)->pluck('id');
        
        DB::table('role_permissions')->whereIn('permission_id', $permIds)->delete();
        DB::table('permissions')->whereIn('name', $newPermissionNames)->delete();
    }
};
