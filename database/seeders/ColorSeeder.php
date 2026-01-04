<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => 'Super Black', 'hex_code' => '#000000', 'description' => 'Deep Black Reactive'],
            ['name' => 'Optical White', 'hex_code' => '#FFFFFF', 'description' => 'Bleached White OBA'],
            ['name' => 'Broken White', 'hex_code' => '#F5F5DC', 'description' => 'Natural White'],
            ['name' => 'Navy Blue 01', 'hex_code' => '#000040', 'description' => 'Dark Navy'],
            ['name' => 'Navy Blue 02', 'hex_code' => '#000080', 'description' => 'Medium Navy'],
            ['name' => 'Royal Blue (Benhur)', 'hex_code' => '#002366', 'description' => 'Bright Royal Blue'],
            ['name' => 'Turquoise Blue', 'hex_code' => '#00CED1', 'description' => 'Turkis Blue'],
            ['name' => 'Military Green', 'hex_code' => '#4B5320', 'description' => 'Army Green'],
            ['name' => 'Forest Green', 'hex_code' => '#013220', 'description' => 'Dark Green'],
            ['name' => 'Lemon Yellow', 'hex_code' => '#FFF700', 'description' => 'Bright Yellow'],
            ['name' => 'Golden Yellow', 'hex_code' => '#FFC000', 'description' => 'Reddish Yellow'],
            ['name' => 'Maroon Red', 'hex_code' => '#800000', 'description' => 'Deep Maroon'],
            ['name' => 'Crimson Red', 'hex_code' => '#DC143C', 'description' => 'Bright Red'],
            ['name' => 'Fuchsia Pink', 'hex_code' => '#FF00FF', 'description' => 'Shocking Pink'],
            ['name' => 'Dark Grey (M71)', 'hex_code' => '#333333', 'description' => 'Misty Grey Dark'],
            ['name' => 'Light Grey (M81)', 'hex_code' => '#CCCCCC', 'description' => 'Misty Grey Light'],
            ['name' => 'Terracotta', 'hex_code' => '#E2725B', 'description' => 'Brick Red'],
            ['name' => 'Khaki', 'hex_code' => '#C3B091', 'description' => 'Tan / Brownish Khaki'],
            ['name' => 'Purple Heart', 'hex_code' => '#69359C', 'description' => 'Deep Purple'],
            ['name' => 'Salmon Pink', 'hex_code' => '#FF8C69', 'description' => 'Light Peach'],
        ];

        foreach ($colors as $color) {
            \App\Models\Color::updateOrCreate(['name' => $color['name']], $color);
        }
    }
}
