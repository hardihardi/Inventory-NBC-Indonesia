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
        Schema::table('sales', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('pembelians', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('productions', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('sale_returns', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('retur_pembelians', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('expenses', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('stock_adjustments', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('stock_transfers', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('cash_flows', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('payments', function (Blueprint $table) { $table->softDeletes(); });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('pembelians', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('productions', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('sale_returns', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('retur_pembelians', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('expenses', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('stock_adjustments', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('stock_transfers', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('cash_flows', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('payments', function (Blueprint $table) { $table->dropSoftDeletes(); });
    }
};
