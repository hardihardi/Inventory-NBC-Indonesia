<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'PT Garmen Jaya Makmur',
                'email' => 'info@garmenjaya.com',
                'phone' => '021-5551234',
                'address' => 'Jl. Industri No. 12, Kawasan Industri Jababeka, Bekasi',
                'category' => 'Factory',
            ],
            [
                'name' => 'Toko Tekstil Abadi Sentosa',
                'email' => 'sales@tekstilabadi.com',
                'phone' => '022-4445678',
                'address' => 'Pasar Baru Trade Center Lt. 1 No. 45, Bandung',
                'category' => 'Distributor',
            ],
            [
                'name' => 'CV Busana Muslimah Sejahtera',
                'email' => 'admin@busanamuslim.co.id',
                'phone' => '021-3337890',
                'address' => 'Jl. Raya Ciputat No. 88, Tangerang Selatan',
                'category' => 'Small Business',
            ],
            [
                'name' => 'Fashion Wear Inc.',
                'email' => 'procurement@fashionwear.com',
                'phone' => '021-2224321',
                'address' => 'SCBD Tower A Lt. 10, Jakarta Selatan',
                'category' => 'Brand',
            ],
            [
                'name' => 'PT Seragam Sekolah Indonesia',
                'email' => 'kontak@seragamsekolah.id',
                'phone' => '024-6669876',
                'address' => 'Jl. Pahlawan No. 5, Semarang',
                'category' => 'Factory',
            ],
            [
                'name' => 'Butik Cantik Menawan',
                'email' => 'hello@butikcantik.com',
                'phone' => '0812-3456-7890',
                'address' => 'Jl. Merdeka No. 10, Surabaya',
                'category' => 'Butik',
            ],
            [
                'name' => 'Konveksi Berkah Ramadhan',
                'email' => 'berkahkonveksi@gmail.com',
                'phone' => '0878-9900-1122',
                'address' => 'Jl. Kebon Jeruk No. 22, Jakarta Barat',
                'category' => 'Small Business',
            ],
            [
                'name' => 'PT Tekstil Ekspor Mandiri',
                'email' => 'export@tekstilekspor.com',
                'phone' => '021-1112233',
                'address' => 'Kawasan Berikat Nusantara, Cakung, Jakarta Utara',
                'category' => 'Exporter',
            ],
            [
                'name' => 'Distributor Benang Nusantara',
                'email' => 'yarn@benangnusantara.net',
                'phone' => '022-7778899',
                'address' => 'Kopo Indah Business Park, Bandung',
                'category' => 'Distributor',
            ],
            [
                'name' => 'Designer Studio Annisa',
                'email' => 'annisa@designer.id',
                'phone' => '0811-2233-4455',
                'address' => 'Kemang Raya No. 15, Jakarta Selatan',
                'category' => 'Designer',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::updateOrCreate(
                ['email' => $customer['email']],
                $customer
            );
        }
    }
}
