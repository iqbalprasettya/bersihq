<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Buat 50 pelanggan dummy
        for ($i = 0; $i < 50; $i++) {
            Customer::create([
                'nama' => $faker->name,
                'no_wa' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'email' => $faker->optional(0.7)->email,
            ]);
        }
    }
}
