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
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('expense_categories');

        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('expense_categories')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who created the expense
            $table->date('expense_date');
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->string('proof_image')->nullable();
            $table->timestamps();
        });

        // Seed initial categories
        DB::table('expense_categories')->insert([
            ['name' => 'Operasional', 'description' => 'Biaya operasional sehari-hari', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gaji Karyawan', 'description' => 'Pembayaran gaji staff', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Listrik & Air', 'description' => 'Tagihan utilitas bulanan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Perawatan & Perbaikan', 'description' => 'Maintenance mesin dan gedung', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ATK & Keperluan Kantor', 'description' => 'Alat tuli kantor dan kebutuhan admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Transportasi', 'description' => 'Bensin, tol, dan biaya kirim', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Konsumsi', 'description' => 'Makan minum karyawan/tamu', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lain-lain', 'description' => 'Biaya tak terduga', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        // Add permissions for expenses if they don't exist
        $perms = [
            ['name' => 'expense.view', 'description' => 'Melihat Pengeluaran', 'group' => 'Finance'],
            ['name' => 'expense.create', 'description' => 'Input Pengeluaran', 'group' => 'Finance'],
            ['name' => 'expense.edit', 'description' => 'Edit Pengeluaran', 'group' => 'Finance'],
            ['name' => 'expense.delete', 'description' => 'Hapus Pengeluaran', 'group' => 'Finance'],
        ];

        foreach ($perms as $p) {
            if (!DB::table('permissions')->where('name', $p['name'])->exists()) {
                 DB::table('permissions')->insert(array_merge($p, ['created_at' => now(), 'updated_at' => now()]));
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('expense_categories');
    }
};
