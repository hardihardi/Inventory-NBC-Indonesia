<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Item;
use Illuminate\Support\Str;

class TextileDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Units (Satuan)
        $unitsObj = [];
        $units = [
            ['name' => 'Kg', 'short_name' => 'kg'],
            ['name' => 'Meter', 'short_name' => 'm'],
            ['name' => 'Yard', 'short_name' => 'yd'],
            ['name' => 'Roll', 'short_name' => 'roll'],
            ['name' => 'Pcs', 'short_name' => 'pcs'],
            ['name' => 'Drum', 'short_name' => 'drm'],
            ['name' => 'Pail', 'short_name' => 'pail'],
            ['name' => 'Sak', 'short_name' => 'sak'],
            ['name' => 'Box', 'short_name' => 'box'],
            ['name' => 'Liter', 'short_name' => 'L'],
        ];

        foreach ($units as $u) {
            $unitsObj[$u['name']] = Unit::firstOrCreate(
                ['name' => $u['name']], 
                ['short_name' => $u['short_name']]
            );
        }

        // 2. Create Categories (Jenis Barang)
        $catsObj = [];
        $categories = [
            ['name' => 'Bahan Baku Benang', 'code' => 'YARN', 'description' => 'Segala jenis benang untuk rajut dan tenun'],
            ['name' => 'Bahan Kimia', 'code' => 'CHEM', 'description' => 'Chemicals untuk proses dyeing dan finishing'],
            ['name' => 'Zat Warna (Dyestuff)', 'code' => 'DYE', 'description' => 'Pewarna tekstil Reactive, Disperse, dll'],
            ['name' => 'Kain Greige', 'code' => 'GRG', 'description' => 'Kain mentah belum diproses'],
            ['name' => 'Kain Jadi', 'code' => 'FIN', 'description' => 'Finished Fabric siap jual'],
            ['name' => 'Sparepart Mesin', 'code' => 'PART', 'description' => 'Suku cadang mesin Circular Knitting & Dyeing'],
        ];

        foreach ($categories as $c) {
            $catsObj[$c['code']] = Category::firstOrCreate(['name' => $c['name']]);
        }

        // 3. Create Items (Data Barang - Expanded)
        $items = [
            // --- YARN (BENANG) ---
            ['name' => 'Benang Cotton Combed 20s', 'category_code' => 'YARN', 'unit_name' => 'Kg', 'purchase_price' => 33000, 'price' => 43000, 'stock' => 2000, 'sku' => 'YARN-CC20S', 'description' => 'Benang Cotton Combed 20s untuk kain tebal/heavyweight.'],
            ['name' => 'Benang Cotton Combed 24s', 'category_code' => 'YARN', 'unit_name' => 'Kg', 'purchase_price' => 34000, 'price' => 44000, 'stock' => 3000, 'sku' => 'YARN-CC24S', 'description' => 'Benang Cotton Combed 24s standard distro.'],
            ['name' => 'Benang Cotton Combed 30s', 'category_code' => 'YARN', 'unit_name' => 'Kg', 'purchase_price' => 35000, 'price' => 45000, 'stock' => 5000, 'sku' => 'YARN-CC30S', 'description' => 'Benang katun combed 30s kualitas premium untuk Rajut.'],
            ['name' => 'Benang Cotton Combed 40s', 'category_code' => 'YARN', 'unit_name' => 'Kg', 'purchase_price' => 37000, 'price' => 48000, 'stock' => 1000, 'sku' => 'YARN-CC40S', 'description' => 'Benang Cotton Combed 40s untuk kain tipis/adem.'],
            ['name' => 'Benang Cotton Bamboo 30s', 'category_code' => 'YARN', 'unit_name' => 'Kg', 'purchase_price' => 45000, 'price' => 58000, 'stock' => 1500, 'sku' => 'YARN-BAM30S', 'description' => 'Benang campuran Kapas dan Serat Bambu anti-bakteri.'],
            ['name' => 'Benang Cotton Modal 30s', 'category_code' => 'YARN', 'unit_name' => 'Kg', 'purchase_price' => 50000, 'price' => 65000, 'stock' => 1000, 'sku' => 'YARN-MOD30S', 'description' => 'Benang campuran Kapas dan Serat Kayu (Modal) sangat lembut.'],
            ['name' => 'Benang CVC 30s (Chief Value Cotton)', 'category_code' => 'YARN', 'unit_name' => 'Kg', 'purchase_price' => 30000, 'price' => 38000, 'stock' => 4000, 'sku' => 'YARN-CVC30S', 'description' => 'Campuran Cotton 60% + Polyester 40%.'],
            ['name' => 'Benang TC 30s (Tetoron Cotton)', 'category_code' => 'YARN', 'unit_name' => 'Kg', 'purchase_price' => 25000, 'price' => 32000, 'stock' => 4000, 'sku' => 'YARN-TC30S', 'description' => 'Campuran Polyester 65% + Cotton 35%.'],
            ['name' => 'Benang Polyester 150D/48F', 'category_code' => 'YARN', 'unit_name' => 'Kg', 'purchase_price' => 22000, 'price' => 28000, 'stock' => 3000, 'sku' => 'YARN-PE150D', 'description' => 'Benang Polyester Filament DTY 150D.'],
            ['name' => 'Benang Polyester 75D/36F', 'category_code' => 'YARN', 'unit_name' => 'Kg', 'purchase_price' => 23000, 'price' => 29000, 'stock' => 2000, 'sku' => 'YARN-PE75D', 'description' => 'Benang Polyester Filament halus.'],
            ['name' => 'Benang Spandex 20D', 'category_code' => 'YARN', 'unit_name' => 'Kg', 'purchase_price' => 120000, 'price' => 150000, 'stock' => 500, 'sku' => 'YARN-SPX20D', 'description' => 'Benang elastis Spandex / Lycra 20 Denier.'],
            ['name' => 'Benang Spandex 40D', 'category_code' => 'YARN', 'unit_name' => 'Kg', 'purchase_price' => 110000, 'price' => 140000, 'stock' => 600, 'sku' => 'YARN-SPX40D', 'description' => 'Benang elastis Spandex / Lycra 40 Denier.'],

            // --- CHEMICALS (KIMIA) ---
            ['name' => 'Soda Ash Light (Na2CO3)', 'category_code' => 'CHEM', 'unit_name' => 'Sak', 'purchase_price' => 250000, 'price' => 300000, 'stock' => 100, 'sku' => 'CHEM-SODA', 'description' => 'Fixing agent untuk reaktif. Kemasan 50kg.'],
            ['name' => 'Caustic Soda Flake 98% (NaOH)', 'category_code' => 'CHEM', 'unit_name' => 'Sak', 'purchase_price' => 350000, 'price' => 420000, 'stock' => 80, 'sku' => 'CHEM-CAUSTIC', 'description' => 'Untuk proses Scouring, Bleaching, Mercerizing. Kemasan 25kg.'],
            ['name' => 'Hydrogen Peroxide 50% (H2O2)', 'category_code' => 'CHEM', 'unit_name' => 'Drum', 'purchase_price' => 450000, 'price' => 550000, 'stock' => 40, 'sku' => 'CHEM-H2O2', 'description' => 'Bleaching agent oksidator kuat. Jerrycan 30kg.'],
            ['name' => 'Glauber Salt (Na2SO4)', 'category_code' => 'CHEM', 'unit_name' => 'Sak', 'purchase_price' => 120000, 'price' => 160000, 'stock' => 200, 'sku' => 'CHEM-GLAUB', 'description' => 'Elektrolit untuk meratakan penyerapan warna.'],
            ['name' => 'Acetic Acid 99% (CH3COOH)', 'category_code' => 'CHEM', 'unit_name' => 'Drum', 'purchase_price' => 600000, 'price' => 750000, 'stock' => 20, 'sku' => 'CHEM-ACID', 'description' => 'Asam Asetat Glasial untuk netralisasi. Drum 30kg.'],
            ['name' => 'Stabilizer H2O2', 'category_code' => 'CHEM', 'unit_name' => 'Drum', 'purchase_price' => 800000, 'price' => 950000, 'stock' => 15, 'sku' => 'CHEM-STAB', 'description' => 'Menstabilkan reaksi bleaching peroxide.'],
            ['name' => 'Sequestering Agent (Anti Sadah)', 'category_code' => 'CHEM', 'unit_name' => 'Drum', 'purchase_price' => 750000, 'price' => 900000, 'stock' => 25, 'sku' => 'CHEM-SEQ', 'description' => 'Mengikat logam berat dalam air.'],
            ['name' => 'Wetting Agent (Pembasah)', 'category_code' => 'CHEM', 'unit_name' => 'Drum', 'purchase_price' => 650000, 'price' => 800000, 'stock' => 30, 'sku' => 'CHEM-WET', 'description' => 'Mempercepat pembasahan kain.'],
            ['name' => 'Soaping Agent', 'category_code' => 'CHEM', 'unit_name' => 'Drum', 'purchase_price' => 700000, 'price' => 850000, 'stock' => 35, 'sku' => 'CHEM-SOAP', 'description' => 'Pencucian warna luntur setelah dyeing.'],
            ['name' => 'Softener Flake (Pelembut)', 'category_code' => 'CHEM', 'unit_name' => 'Sak', 'purchase_price' => 500000, 'price' => 650000, 'stock' => 60, 'sku' => 'CHEM-SOFT', 'description' => 'Pelembut kain handfeel silky.'],
            ['name' => 'Silicone Oil Emulsion', 'category_code' => 'CHEM', 'unit_name' => 'Drum', 'purchase_price' => 1200000, 'price' => 1500000, 'stock' => 10, 'sku' => 'CHEM-SIL', 'description' => 'Finishing agent untuk efek licin/bouncy.'],
            ['name' => 'Enzyme Cellulase (Biopolish)', 'category_code' => 'CHEM', 'unit_name' => 'Drum', 'purchase_price' => 1500000, 'price' => 1800000, 'stock' => 8, 'sku' => 'CHEM-ENZ', 'description' => 'Makan bulu kain (Biopolishing).'],

            // --- DYESTUFF (ZAT WARNA) ---
            ['name' => 'Novacron Red FN-R', 'category_code' => 'DYE', 'unit_name' => 'Kg', 'purchase_price' => 150000, 'price' => 200000, 'stock' => 50, 'sku' => 'DYE-RED-FNR', 'description' => 'Reactive Red. High Fastness.'],
            ['name' => 'Novacron Blue FN-R', 'category_code' => 'DYE', 'unit_name' => 'Kg', 'purchase_price' => 180000, 'price' => 240000, 'stock' => 45, 'sku' => 'DYE-BLU-FNR', 'description' => 'Reactive Blue.'],
            ['name' => 'Novacron Yellow FN-2R', 'category_code' => 'DYE', 'unit_name' => 'Kg', 'purchase_price' => 160000, 'price' => 210000, 'stock' => 40, 'sku' => 'DYE-YEL-FN2R', 'description' => 'Reactive Yellow reddish.'],
            ['name' => 'Sumifix Black B 150%', 'category_code' => 'DYE', 'unit_name' => 'Kg', 'purchase_price' => 85000, 'price' => 120000, 'stock' => 200, 'sku' => 'DYE-BLK-B', 'description' => 'Reactive Black Deep.'],
            ['name' => 'Sumifix Supra Red 3BF', 'category_code' => 'DYE', 'unit_name' => 'Kg', 'purchase_price' => 140000, 'price' => 180000, 'stock' => 30, 'sku' => 'DYE-RED-3BF', 'description' => 'Reactive Red bluish.'],
            ['name' => 'Disp. Red 60 (Polyester)', 'category_code' => 'DYE', 'unit_name' => 'Kg', 'purchase_price' => 110000, 'price' => 140000, 'stock' => 25, 'sku' => 'DYE-PE-RED60', 'description' => 'Disperse Red untuk Polyester.'],
            ['name' => 'Disp. Blue 56 (Polyester)', 'category_code' => 'DYE', 'unit_name' => 'Kg', 'purchase_price' => 115000, 'price' => 150000, 'stock' => 25, 'sku' => 'DYE-PE-BLU56', 'description' => 'Disperse Blue untuk Polyester.'],

            // --- FABRICS (KAIN JADI) ---
            ['name' => 'Kain Cotton Combed 30s Hitam Reaktif', 'category_code' => 'FIN', 'unit_name' => 'Kg', 'purchase_price' => 98000, 'price' => 115000, 'stock' => 500, 'sku' => 'FIN-CC30-BLK-R', 'description' => 'Single Jersey 30s Black Reactive High Grade.'],
            ['name' => 'Kain Cotton Combed 30s Putih', 'category_code' => 'FIN', 'unit_name' => 'Kg', 'purchase_price' => 90000, 'price' => 105000, 'stock' => 300, 'sku' => 'FIN-CC30-WHT', 'description' => 'Single Jersey 30s White Bluish.'],
            ['name' => 'Kain Cotton Combed 30s Merah Cabe', 'category_code' => 'FIN', 'unit_name' => 'Kg', 'purchase_price' => 105000, 'price' => 125000, 'stock' => 200, 'sku' => 'FIN-CC30-RED', 'description' => 'Single Jersey 30s Red.'],
            ['name' => 'Kain Cotton Combed 30s Navy', 'category_code' => 'FIN', 'unit_name' => 'Kg', 'purchase_price' => 105000, 'price' => 125000, 'stock' => 250, 'sku' => 'FIN-CC30-NAV', 'description' => 'Single Jersey 30s Navy Blue.'],
            ['name' => 'Kain Cotton Combed 24s Hitam Reaktif', 'category_code' => 'FIN', 'unit_name' => 'Kg', 'purchase_price' => 100000, 'price' => 118000, 'stock' => 300, 'sku' => 'FIN-CC24-BLK', 'description' => 'Single Jersey 24s lebih tebal.'],
            ['name' => 'Kain Pique Combed 24s/30s (Lacoste)', 'category_code' => 'FIN', 'unit_name' => 'Kg', 'purchase_price' => 110000, 'price' => 135000, 'stock' => 150, 'sku' => 'FIN-PIQUE-WHT', 'description' => 'Kain wangki/polo corak hexagon.'],
            ['name' => 'Kain Baby Terry C20s Misty M71', 'category_code' => 'FIN', 'unit_name' => 'Kg', 'purchase_price' => 95000, 'price' => 115000, 'stock' => 250, 'sku' => 'FIN-BTER-M71', 'description' => 'Untuk Hoodie/Sweater ringan.'],
            ['name' => 'Kain Cotton Fleece C30s Hitam', 'category_code' => 'FIN', 'unit_name' => 'Kg', 'purchase_price' => 115000, 'price' => 140000, 'stock' => 100, 'sku' => 'FIN-FLE-BLK', 'description' => 'Fleece tebal berbulu untuk jaket.'],
            ['name' => 'Rib Cotton Combed 30s Hitam', 'category_code' => 'FIN', 'unit_name' => 'Kg', 'purchase_price' => 105000, 'price' => 125000, 'stock' => 50, 'sku' => 'FIN-RIB-30-BLK', 'description' => 'Aksesoris kerah/lengan 1x1.'],
            ['name' => 'Bur Cotton Combed 30s Hitam', 'category_code' => 'FIN', 'unit_name' => 'Kg', 'purchase_price' => 105000, 'price' => 125000, 'stock' => 50, 'sku' => 'FIN-BUR-30-BLK', 'description' => 'Untuk variasi (Rib tebal).'],

            // --- SPAREPARTS (SUKU CADANG) ---
            ['name' => 'Jarum Rajut Groz-Beckert VO 71.50', 'category_code' => 'PART', 'unit_name' => 'Box', 'purchase_price' => 1500000, 'price' => 1800000, 'stock' => 10, 'sku' => 'PART-NDL-VO', 'description' => 'Jarum mesin circular 24G.'],
            ['name' => 'Sinker Kern-Liebers', 'category_code' => 'PART', 'unit_name' => 'Box', 'purchase_price' => 1200000, 'price' => 1400000, 'stock' => 10, 'sku' => 'PART-SINK', 'description' => 'Plat sinker mesin rajut.'],
            ['name' => 'V-Belt B-52 Mitsubishi', 'category_code' => 'PART', 'unit_name' => 'Pcs', 'purchase_price' => 45000, 'price' => 65000, 'stock' => 20, 'sku' => 'PART-BELT-B52', 'description' => 'V-Belt karet hitam B-52.'],
            ['name' => 'Oli Mesin Rajut (Knitting Oil) ISO 32', 'category_code' => 'PART', 'unit_name' => 'drum', 'purchase_price' => 500000, 'price' => 700000, 'stock' => 5, 'sku' => 'PART-OIL-32', 'description' => 'Pelumas jarum mesin rajut, washable.'],
            ['name' => 'Inverter Delta 5.5 KW', 'category_code' => 'PART', 'unit_name' => 'Pcs', 'purchase_price' => 3500000, 'price' => 4500000, 'stock' => 2, 'sku' => 'PART-INV-55', 'description' => 'Pengatur kecepatan motor mesin.'],
            ['name' => 'Seal Mechanical Pump 2"', 'category_code' => 'PART', 'unit_name' => 'Pcs', 'purchase_price' => 250000, 'price' => 350000, 'stock' => 15, 'sku' => 'PART-SEAL-2', 'description' => 'Seal pompa celup dyeing.'],
        ];

        foreach ($items as $i) {
            $cat = $catsObj[$i['category_code']] ?? Category::first();
            $unit = $unitsObj[$i['unit_name']] ?? Unit::first();

            Item::updateOrCreate(
                ['sku' => $i['sku']],
                [
                    'name' => $i['name'],
                    'category_id' => $cat->id,
                    'unit_id' => $unit->id,
                    'price' => $i['price'],
                    'purchase_price' => $i['purchase_price'],
                    'stock' => $i['stock'],
                    'description' => $i['description'],
                    'product_code' => Str::upper(Str::random(10)),
                    'barcode' => rand(1000000000000, 9999999999999), // Simple fake EAN
                    'color_name' => $i['color_name'] ?? null,
                    'color_code' => $i['color_code'] ?? null,
                ]
            );
        }
    }
}
