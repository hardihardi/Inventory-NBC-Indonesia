<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'PT Indorama Synthetics Tbk',
                'contact_person' => 'Bpk. Hendra Gunawan',
                'email' => 'sales@indorama.com',
                'phone' => '021-3922333',
                'address' => 'Gedung Graha Irama, Jl. HR Rasuna Said, Jakarta',
            ],
            [
                'name' => 'PT Argo Pantes Tbk',
                'contact_person' => 'Ibu Maria Ulfa',
                'email' => 'procurement@argopantes.com',
                'phone' => '021-5501463',
                'address' => 'Jl. MH Thamrin No. 1, Cikokol, Tangerang',
            ],
            [
                'name' => 'BASF Indonesia',
                'contact_person' => 'Mr. Simon Tan',
                'email' => 'info.indonesia@basf.com',
                'phone' => '021-5262481',
                'address' => 'DBS Bank Tower Lt. 27, Ciputra World 1, Jakarta',
            ],
            [
                'name' => 'Huntsman Indonesia',
                'contact_person' => 'Bpk. Agus Salim',
                'email' => 'contact_us@huntsman.com',
                'phone' => '021-8234567',
                'address' => 'Jl. Raya Bogor Km 27, Ciracas, Jakarta',
            ],
            [
                'name' => 'Archroma Indonesia',
                'contact_person' => 'Ibu Siti Aminah',
                'email' => 'sales.id@archroma.com',
                'phone' => '021-8672233',
                'address' => 'Jl. Jababeka II Blok C, Cikarang, Bekasi',
            ],
            [
                'name' => 'PT Sri Rejeki Isman Tbk (Sritex)',
                'contact_person' => 'Bpk. Iwan Kurniawan',
                'email' => 'marketing@sritex.co.id',
                'phone' => '0271-593188',
                'address' => 'Jl. KH Samanhudi 88, Jetis, Sukoharjo, Solo',
            ],
            [
                'name' => 'DyStar Indonesia',
                'contact_person' => 'Ms. Linda Wong',
                'email' => 'dyestuff@dystar.com',
                'phone' => '021-5270550',
                'address' => 'Menara Global Lt. 20, Jl. Jend Gatot Subroto, Jakarta',
            ],
            [
                'name' => 'PT Lucky Textile',
                'contact_person' => 'Bpk. Bambang Sujatmiko',
                'email' => 'lucky@luckytextile.id',
                'phone' => '021-5918888',
                'address' => 'Jl. Raya Serang Km 12, Cikupa, Tangerang',
            ],
            [
                'name' => 'Groz-Beckert Indonesia',
                'contact_person' => 'Bpk. Rudi Hartono',
                'email' => 'sales.id@groz-beckert.com',
                'phone' => '022-7798899',
                'address' => 'Kawasan Industri Batujajar, Bandung',
            ],
            [
                'name' => 'PT Asahi Kasei Indonesia',
                'contact_person' => 'Mr. Tanaka',
                'email' => 'procurement@asahi-kasei.co.jp',
                'phone' => '021-5201111',
                'address' => 'Wisma Keiai Lt. 10, Jl. Jend Sudirman, Jakarta',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::updateOrCreate(
                ['name' => $supplier['name']],
                $supplier
            );
        }
    }
}
