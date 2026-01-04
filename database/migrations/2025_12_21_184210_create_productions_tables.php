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
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g. PROD-20231221-001
            
            // Barang yang diproduksi (Finished Good)
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            
            $table->integer('qty_planned');
            $table->integer('qty_actual')->nullable();
            
            // Status Produksi
            $table->enum('status', ['planned', 'in_progress', 'completed', 'cancelled'])->default('planned');
            
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('notes')->nullable();
            
            // User yang membuat rencana
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            
            $table->timestamps();
        });

        Schema::create('production_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_id')->constrained('productions')->onDelete('cascade');
            
            // Bahan Baku (Raw Material)
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            
            $table->integer('qty_needed'); // Rencana kebutuhan
            $table->integer('qty_used')->nullable(); // Realisasi penggunaan
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_materials');
        Schema::dropIfExists('productions');
    }
};
