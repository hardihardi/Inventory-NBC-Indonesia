<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g. inventory.view
            $table->string('description'); // e.g. Melihat Data Barang
            $table->string('group'); // e.g. Inventory
            $table->timestamps();
        });

        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('role'); // admin, manajer, staff_gudang, produksi
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['role', 'permission_id']);
        });

        // Seed initial permissions
        $permissions = [
            // Inventory
            ['name' => 'inventory.view', 'description' => 'Melihat Data Barang', 'group' => 'Inventory'],
            ['name' => 'inventory.create', 'description' => 'Tambah Barang', 'group' => 'Inventory'],
            ['name' => 'inventory.edit', 'description' => 'Edit Barang', 'group' => 'Inventory'],
            ['name' => 'inventory.delete', 'description' => 'Hapus Barang', 'group' => 'Inventory'],
            
            // Production
            ['name' => 'production.view', 'description' => 'Melihat Produksi', 'group' => 'Production'],
            ['name' => 'production.create', 'description' => 'Buat Rencana Produksi', 'group' => 'Production'],
            ['name' => 'production.edit', 'description' => 'Update Progress Produksi', 'group' => 'Production'],
            ['name' => 'production.delete', 'description' => 'Batalkan/Hapus Produksi', 'group' => 'Production'],
            
            // Finance (Sales/Purchase)
            ['name' => 'finance.view', 'description' => 'Melihat Transaksi', 'group' => 'Finance'],
            ['name' => 'finance.create', 'description' => 'Input Transaksi', 'group' => 'Finance'],
            
            // Reports
            ['name' => 'reports.view', 'description' => 'Melihat Laporan', 'group' => 'Reports'],
            
            // Settings
            ['name' => 'settings.view', 'description' => 'Mengakses Pengaturan', 'group' => 'Settings'],
             ['name' => 'settings.manage_users', 'description' => 'Kelola User', 'group' => 'Settings'],
        ];

        DB::table('permissions')->insert($permissions);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('permissions');
    }
};
