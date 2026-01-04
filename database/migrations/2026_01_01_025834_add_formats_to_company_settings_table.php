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
        Schema::table('company_settings', function (Blueprint $table) {
            $table->string('invoice_prefix')->nullable()->default('INV');
            $table->string('invoice_format')->nullable()->default('{PREFIX}/{YEAR}/{MONTH}/{ID}');
            $table->string('sj_prefix')->nullable()->default('SJ');
            $table->string('sj_format')->nullable()->default('{PREFIX}/{YEAR}/{MONTH}/{ID}');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn(['invoice_prefix', 'invoice_format', 'sj_prefix', 'sj_format']);
        });
    }
};
