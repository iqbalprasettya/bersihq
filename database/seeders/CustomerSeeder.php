<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'nama' => 'Budi Santoso',
                'no_wa' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'email' => 'budi@example.com',
            ],
            [
                'nama' => 'Siti Rahayu',
                'no_wa' => '082345678901',
                'alamat' => 'Jl. Pahlawan No. 45, Jakarta',
                'email' => 'siti@example.com',
            ],
            [
                'nama' => 'Ahmad Hidayat',
                'no_wa' => '083456789012',
                'alamat' => 'Jl. Sudirman No. 67, Jakarta',
                'email' => null,
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
