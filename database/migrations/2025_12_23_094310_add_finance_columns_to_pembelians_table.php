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
        Schema::table('pembelians', function (Blueprint $table) {
            $table->string('payment_method')->default('cash')->after('total_amount');
            $table->decimal('paid_amount', 15, 2)->default(0)->after('payment_method');
            $table->string('payment_status')->default('paid')->after('paid_amount'); // paid, partial, credit
            $table->date('due_date')->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembelians', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'paid_amount', 'payment_status', 'due_date']);
        });
    }
};
