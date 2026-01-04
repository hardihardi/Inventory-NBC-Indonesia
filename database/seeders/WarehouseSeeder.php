<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warehouses = [
            [
                'code' => 'WH-MAIN',
                'name' => 'Gudang Utama',
                'address' => 'Jl. Industri Utama No. 1, Bandung',
                'is_default' => true
            ],
            [
                'code' => 'WH-RAW',
                'name' => 'Gudang Bahan Baku',
                'address' => 'Gedung A, Area Timur',
                'is_default' => false
            ],
            [
                'code' => 'WH-CHEM',
                'name' => 'Gudang Chemical & Dyestuff',
                'address' => 'Gedung B (Ventilasi Khusus)',
                'is_default' => false
            ],
            [
                'code' => 'WH-FIN',
                'name' => 'Gudang Kain Jadi',
                'address' => 'Gedung C, Area Pengiriman',
                'is_default' => false
            ],
            [
                'code' => 'WH-PROD',
                'name' => 'Gudang Lantai Produksi',
                'address' => 'Area Workshop Utama',
                'is_default' => false
            ],
        ];

        foreach ($warehouses as $whData) {
            $wh = \App\Models\Warehouse::updateOrCreate(
                ['code' => $whData['code']],
                $whData
            );

            // Jika ini gudang utama, sync semua stok item ke sini (sebagai saldo awal)
            if ($wh->is_default) {
                $items = \App\Models\Item::all();
                foreach ($items as $item) {
                    if ($item->stock > 0) {
                        \App\Models\WarehouseStock::updateOrCreate(
                            ['warehouse_id' => $wh->id, 'item_id' => $item->id],
                            ['stock' => $item->stock]
                        );

                        // Log ke Stock Ledger
                        \App\Models\StockLedger::log(
                            $item->id,
                            $wh->id,
                            $item->stock,
                            $item->stock,
                            'in',
                            $item->id,
                            'Item',
                            'Saldo awal (Seeding Master Data)'
                        );
                    }
                }
            }
        }
    }
}
