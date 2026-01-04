<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StockTransfer;
use App\Models\Item;
use App\Models\Warehouse;
use App\Models\User;

class StockTransferSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $items = Item::limit(5)->get();
        $warehouses = Warehouse::all();

        if ($warehouses->count() < 2) {
            return;
        }

        $w1 = $warehouses[0];
        $w2 = $warehouses[1];

        foreach ($items as $item) {
            StockTransfer::create([
                'transfer_no' => 'TRF-' . strtoupper(bin2hex(random_bytes(4))),
                'from_warehouse_id' => $w1->id,
                'to_warehouse_id' => $w2->id,
                'item_id' => $item->id,
                'qty' => rand(1, 50),
                'status' => 'pending',
                'created_by' => $user->id,
                'notes' => 'Generated sample transfer data.',
            ]);
        }
    }
}
