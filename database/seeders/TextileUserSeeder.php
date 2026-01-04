<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TextileUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Adam Miftah (Admin)',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '081234567890',
                'status' => 'active',
            ],
            [
                'name' => 'Hendra Procurement',
                'email' => 'procurement@gudang.com',
                'password' => Hash::make('password'),
                'role' => 'procurement',
                'phone' => '081234567891',
                'status' => 'active',
            ],
            [
                'name' => 'Siti Finance',
                'email' => 'finance@gudang.com',
                'password' => Hash::make('password'),
                'role' => 'finance',
                'phone' => '081234567892',
                'status' => 'active',
            ],
            [
                'name' => 'Budi Gudang',
                'email' => 'staff@gudang.com',
                'password' => Hash::make('password'),
                'role' => 'staff_gudang',
                'phone' => '081234567893',
                'status' => 'active',
            ],
            [
                'name' => 'Dedi Supervisor',
                'email' => 'supervisor@gudang.com',
                'password' => Hash::make('password'),
                'role' => 'kepala_gudang',
                'phone' => '081234567895',
                'status' => 'active',
            ],
            [
                'name' => 'Agus Produksi / PPIC',
                'email' => 'produksi@gudang.com',
                'password' => Hash::make('password'),
                'role' => 'produksi',
                'phone' => '081234567894',
                'status' => 'active',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
