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
        Schema::table('items', function (Blueprint $table) {
            $table->after('color_code', function ($table) {
                $table->string('composition')->nullable(); // e.g. 100% Cotton
                $table->string('technical_spec')->nullable(); // e.g. Ne 30/1
                $table->string('gsm')->nullable(); // e.g. 140-150
                $table->string('width')->nullable(); // e.g. 36", 42"
                $table->string('brand')->nullable(); // e.g. PT. Sritex, ABC
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['composition', 'gsm', 'width', 'brand']);
        });
    }
};
