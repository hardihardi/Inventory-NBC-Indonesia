<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('product_code', 50)->nullable()->unique()->after('id');
            $table->string('barcode', 50)->nullable()->unique()->after('product_code');
            $table->string('sku', 100)->nullable()->unique()->after('barcode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['product_code', 'barcode', 'sku']);
        });
    }
};
