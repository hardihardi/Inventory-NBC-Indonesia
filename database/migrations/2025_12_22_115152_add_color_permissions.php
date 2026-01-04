<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $permissions = [
            ['name' => 'inventory.colors.view', 'description' => 'Melihat Master Warna', 'group' => 'Inventory'],
            ['name' => 'inventory.colors.create', 'description' => 'Tambah Warna', 'group' => 'Inventory'],
            ['name' => 'inventory.colors.edit', 'description' => 'Edit Warna', 'group' => 'Inventory'],
            ['name' => 'inventory.colors.delete', 'description' => 'Hapus Warna', 'group' => 'Inventory'],
        ];

        DB::table('permissions')->insert($permissions);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('permissions')->where('name', 'like', 'inventory.colors.%')->delete();
    }
};
