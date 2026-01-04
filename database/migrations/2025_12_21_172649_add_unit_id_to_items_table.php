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
            $table->foreignId('unit_id')->nullable()->after('category_id')->constrained('units')->onDelete('set null');
        });

        // Migrasi data dari kolom 'unit' lama ke tabel 'units' dan update 'unit_id'
        $items = DB::table('items')->get();
        foreach ($items as $item) {
            if ($item->unit) {
                $unit = DB::table('units')->where('name', $item->unit)->first();
                if (!$unit) {
                    $unitId = DB::table('units')->insertGetId([
                        'name' => $item->unit,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $unitId = $unit->id;
                }
                
                DB::table('items')->where('id', $item->id)->update(['unit_id' => $unitId]);
            }
        }

        // Hapus kolom unit lama jika migrasi data selesai
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('unit')->nullable()->after('volume');
            // Catatan: Re-populate data unit dari unit_id di sini jika perlu, 
            // tapi biasanya down() hanya mengembalikan struktur.
            $table->dropForeign(['unit_id']);
            $table->dropColumn('unit_id');
        });
    }
};
