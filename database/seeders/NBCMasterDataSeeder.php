<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NBCMasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0. Cleanup for a fresh expert-state
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Item::truncate();
        \App\Models\Category::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Units
        $unitsArr = [
            ['name' => 'Kilogram', 'short_name' => 'Kg'],
            ['name' => 'Meter', 'short_name' => 'Mtr'],
            ['name' => 'Yard', 'short_name' => 'Yd'],
            ['name' => 'Roll', 'short_name' => 'Roll'],
            ['name' => 'Pcs', 'short_name' => 'Pcs'],
            ['name' => 'Cone', 'short_name' => 'Cone'],
            ['name' => 'Drum', 'short_name' => 'Drm'],
            ['name' => 'Pail', 'short_name' => 'Pail'],
            ['name' => 'Sak', 'short_name' => 'Sak'],
            ['name' => 'Box', 'short_name' => 'Box'],
            ['name' => 'Liter', 'short_name' => 'L'],
            ['name' => 'Set', 'short_name' => 'Set'],
            ['name' => 'Pallet', 'short_name' => 'Pallet'],
        ];
        $units = [];
        foreach ($unitsArr as $u) {
            $units[$u['short_name']] = \App\Models\Unit::updateOrCreate(['name' => $u['name']], $u);
        }

        // 2. Categories
        $categoriesArr = [
            ['name' => 'Benang (Yarn)', 'type' => 'yarn'],
            ['name' => 'Bahan Kimia (Chemical)', 'type' => 'chemical'],
            ['name' => 'Zat Warna (Dyestuff)', 'type' => 'dyestuff'],
            ['name' => 'Kain Greige (Kain Mentah)', 'type' => 'fabric'],
            ['name' => 'Kain Jadi (Finished Fabric)', 'type' => 'fabric'],
            ['name' => 'Sparepart Mesin Rajut', 'type' => 'sparepart'],
            ['name' => 'Sparepart Mesin Dyeing', 'type' => 'sparepart'],
            ['name' => 'Alat Tulis & Umum', 'type' => 'general'],
            ['name' => 'Bahan Laboratorium', 'type' => 'chemical'],
            ['name' => 'Cat & Pelapis (Paint)', 'type' => 'cat'],
        ];
        $cats = [];
        foreach ($categoriesArr as $c) {
            $cat = \App\Models\Category::create($c);
            $cats[$c['name']] = $cat;
        }

        // 3. Colors List (Hardcoded since master colors module is removed)
        $colors = [
            'Super Black', 'Optical White', 'Navy Blue', 'Maroon', 'Red', 'Royal Blue', 'Dark Grey',
            'Light Grey', 'Turkish Blue', 'Emerald Green', 'Yellow', 'Pink', 'Purple'
        ];

        // 4. ITEMS MASTER DATA
        $items = [];

        // --- YARNS (25 Items) ---
        $yarnTypes = ['CC' => 'Cotton Combed', 'CD' => 'Cotton Carded', 'CVC' => 'Chief Value Cotton', 'TC' => 'Tetoron Cotton', 'PE' => 'Polyester DTY', 'RAY' => 'Rayon Viscose', 'BAM' => 'Cotton Bamboo', 'MOD' => 'Cotton Modal', 'PC' => 'Polyester Cotton'];
        $yarnCounts = ['20s', '24s', '30s', '40s'];
        foreach($yarnTypes as $code => $name) {
            foreach($yarnCounts as $count) {
                $items[] = [
                    'n' => "Benang $name $count",
                    't' => 'Benang (Yarn)',
                    'u' => 'Kg',
                    'sku' => "YRN-$code-$count",
                    'b' => rand(25000, 45000),
                    'j' => rand(40000, 60000),
                    's' => rand(500, 5000),
                    'comp' => $name == 'Cotton Combed' || $name == 'Cotton Carded' ? '100% Cotton' : ($name == 'Polyester DTY' ? '100% PE' : 'Blended'),
                    'spec' => "Ne $count/1",
                    'brnd' => 'NBC Indonesia'
                ];
            }
        }
        $items[] = ['n' => 'Spandex Lycra 20D', 't' => 'Benang (Yarn)', 'u' => 'Kg', 'sku' => 'YRN-SP-20D', 'b' => 125000, 'j' => 160000, 's' => 300, 'spec' => '20 Denier', 'brnd' => 'Inviya'];
        $items[] = ['n' => 'Spandex Lycra 40D', 't' => 'Benang (Yarn)', 'u' => 'Kg', 'sku' => 'YRN-SP-40D', 'b' => 110000, 'j' => 145000, 's' => 450, 'spec' => '40 Denier', 'brnd' => 'Inviya'];

        // --- CHEMICALS (30 Items) ---
        $chems = [
            ['Soda Ash Light', 'Fixing agent', 'Sak', 'ANSAC'], ['Caustic Soda Flake', 'NaOH 98%', 'Sak', 'Asahi'],
            ['Hydrogen Peroxide 50%', 'Bleaching', 'Drm', 'Evonik'], ['Acetic Acid 99%', 'Neutralizer', 'Drm', 'Local'],
            ['Sodium Silicate', 'Stabilizer', 'Drm', 'PG'], ['Gluber Salt', 'Electrolyte', 'Sak', 'China'],
            ['Wetting Agent L-01', 'Surfactant', 'Drm', 'BASF'], ['Sequestering Agent', 'Chelating', 'Drm', 'Huntsman'],
            ['Softener Cationic', 'Pelembut', 'Sak', 'Local'], ['Silicone Emulsion', 'Silky finish', 'Drm', 'Wacker'],
            ['Enzyme Biopolish', 'Bulu cleaner', 'Drm', 'Novozymes'], ['Anti Foam', 'Defoamer', 'Drm', 'Dow'],
            ['Fixing Agent DF', 'Color fix', 'Drm', 'Nicca'], ['Levelling Agent', 'Leveling', 'Drm', 'DyStar'],
            ['Scouring Agent', 'Pemasakan', 'Drm', 'Bozzetto'], ['Soap-L', 'Washing', 'Drm', 'Local'],
            ['Anti Creasing', 'Pelumas kain', 'Drm', 'Tanatex'], ['De-Aerating', 'Penghilang udara', 'Drm', 'Clariant'],
            ['Anti Migrating', 'Pencegah migrasi', 'Drm', 'Archroma'], ['Fire Retardant', 'Tahan api', 'Drm', 'Specialty'],
            ['Hydrophilic Agent', 'Penyerap', 'Drm', 'Rudolf'], ['Anti-Static', 'Anti statis', 'Drm', 'CHT']
        ];
        foreach($chems as $ch) {
            $items[] = [
                'n' => $ch[0], 't' => 'Bahan Kimia (Chemical)', 'u' => $ch[2], 'sku' => "CHM-".strtoupper(substr($ch[0], 0, 4))."-".rand(10,99),
                'b' => rand(100000, 2000000), 'j' => rand(250000, 2800000), 's' => rand(5, 50),
                'comp' => $ch[1], 'brnd' => 'NBC Indonesia'
            ];
        }

        // --- DYESTUFF (20 Items) ---
        $dyes = ['Reactive Red', 'Reactive Blue', 'Reactive Yellow', 'Reactive Black', 'Disperse Blue', 'Disperse Red', 'Acid Orange', 'Cationic Pink'];
        foreach($dyes as $dy) {
            for($v=1; $v<=3; $v++) {
                $items[] = [
                    'n' => "$dy Grade $v", 't' => 'Zat Warna (Dyestuff)', 'u' => 'Kg', 'sku' => "DYE-".strtoupper(substr($dy,0,3))."-0$v",
                    'b' => rand(80000, 250000), 'j' => rand(120000, 350000), 's' => rand(10, 200),
                    'brnd' => 'NBC Indonesia'
                ];
            }
        }

        // --- FINISHED FABRICS (50 Items - All Colors) ---
        $fabTypes = ['S/J 30s Combed' => '140-150', 'Pique 24s Combed' => '200-210', 'Baby Terry 20s' => '240-260', 'Fleece 30s' => '280-300'];
        $ci = 0;
        foreach($fabTypes as $fName => $gsm) {
            foreach($colors as $color) {
                $items[] = [
                    'n' => "Kain $fName - $color", 't' => 'Kain Jadi (Finished Fabric)', 'u' => 'Kg', 'sku' => "FAB-".strtoupper(substr($fName,0,2))."-".strtoupper(substr($color,0,3))."-".rand(10,99),
                    'b' => rand(95000, 115000), 'j' => rand(120000, 145000), 's' => rand(100, 1000),
                    'comp' => '100% Cotton', 'gsm' => $gsm, 'w' => rand(36, 45).'" Tubular', 'clr' => $color
                ];
                $ci++;
                if($ci > 50) break; // Limit to 50 for kain jadi
            }
            if($ci > 50) break;
        }

        // --- GREIGE (10 Items) ---
        foreach(array_keys($fabTypes) as $fName) {
            $items[] = [
                'n' => "Greige $fName", 't' => 'Kain Greige (Kain Mentah)', 'u' => 'Kg', 'sku' => "GRG-".strtoupper(substr($fName,0,3))."-".rand(10,99),
                'b' => rand(75000, 85000), 'j' => rand(90000, 100000), 's' => rand(1000, 5000),
                'comp' => '100% Cotton', 'gsm' => rand(140, 300), 'w' => '42"'
            ];
        }

        // --- SPAREPARTS (20 Items) ---
        $machines = ['Knitting', 'Dyeing'];
        $parts = ['Jarum', 'Sinker', 'Belt', 'Bearing', 'Seal', 'Inverter', 'Sensor', 'Motor', 'Pump', 'Oil'];
        foreach($machines as $m) {
            foreach($parts as $p) {
                $items[] = [
                    'n' => "$p Mesin $m ".rand(100,999), 't' => "Sparepart Mesin $m", 'u' => rand(0,1) ? 'Pcs' : 'Box', 'sku' => "SPA-".strtoupper(substr($m,0,1))."-".strtoupper(substr($p,0,3))."-".rand(10,99),
                    'b' => rand(50000, 5000000), 'j' => rand(75000, 6500000), 's' => rand(1, 50),
                    'brnd' => 'NBC Indonesia'
                ];
            }
        }

        // --- PAINTS (NEW - 10 Items) ---
        $paints = [
            ['Jotun Majestic True Beauty', 'Matt', 'Putih Salju', 'JS-101', '2.5L'],
            ['Dulux Weathershield', 'Exterior', 'Brilliant White', 'DX-99', '5L'],
            ['Nippon Paint Weatherbond', 'Exterior', 'Sky Blue', 'NP-40', '20L'],
            ['Avitex Cat Tembok', 'Interior', 'Broken White', 'AV-12', '5kg'],
            ['Mowilex Weathercoat', 'Exterior', 'Stone Grey', 'MW-88', '2.5L'],
            ['Aquaproof', 'Waterproof', 'Abu-Abu', 'AQ-01', '4kg'],
            ['Propan Decorshield', 'Exterior', 'Light Beige', 'PP-55', '5L'],
            ['Epoxy Floor Paint', 'Industrial', 'Green Gloss', 'EP-10', '20kg'],
            ['Wood Stain P-01', 'Finish', 'Clear Gloss', 'WD-01', '1L'],
            ['Thinner High Gloss', 'Solvent', 'Clear', 'TH-HG', '5L'],
        ];
        foreach($paints as $p) {
            $items[] = [
                'n' => $p[0], 't' => 'Cat & Pelapis (Paint)', 'u' => rand(0,1) ? 'Pail' : 'Liter', 'sku' => "PNT-".strtoupper(substr($p[0], 0, 3))."-".rand(10,99),
                'b' => rand(150000, 2500000), 'j' => rand(180000, 3000000), 's' => rand(10, 100),
                'ptype' => $p[1], 'cname' => $p[2], 'ccode' => $p[3], 'vol' => $p[4]
            ];
        }

        // 5. SEED EXECUTION
        foreach ($items as $i) {
            $cat = $cats[$i['t']] ?? \App\Models\Category::first();
            $unit = $units[$i['u']] ?? \App\Models\Unit::first();

            \App\Models\Item::updateOrCreate(
                ['sku' => $i['sku']],
                [
                    'name' => $i['n'],
                    'category_id' => $cat->id,
                    'unit_id' => $unit->id,
                    'purchase_price' => $i['b'] ?? 0,
                    'price' => $i['j'] ?? 0,
                    'stock' => $i['s'] ?? 0,
                    'composition' => $i['comp'] ?? null,
                    'technical_spec' => $i['spec'] ?? null,
                    'gsm' => $i['gsm'] ?? null,
                    'width' => $i['w'] ?? null,
                    'brand' => $i['brnd'] ?? null,
                    'barcode' => rand(1000000000000, 9999999999999),
                    'paint_type' => $i['ptype'] ?? null,
                    'color_name' => $i['cname'] ?? null,
                    'color_code' => $i['ccode'] ?? null,
                    'volume' => $i['vol'] ?? null,
                    'description' => ($i['n'] ?? '') . ' ' . ($i['comp'] ?? '') . ' ' . ($i['brnd'] ?? ''),
                    'product_code' => \Illuminate\Support\Str::upper(\Illuminate\Support\Str::random(10)),
                    'image' => match($cat->type) {
                        'yarn' => 'items/yarn_sample.png',
                        'chemical' => 'items/chemical_sample.png',
                        'dyestuff' => 'items/chemical_sample.png', // Fallback
                        'fabric' => 'items/fabric_sample.png',
                        'sparepart' => 'items/sparepart_sample.png',
                        'cat' => 'items/paint_sample.png',
                        default => null
                    },
                ]
            );
        }
    }
}
