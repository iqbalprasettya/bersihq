<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua ID yang diperlukan
        $customerIds = Customer::pluck('id')->toArray();
        $serviceIds = Service::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        // Buat 100 pesanan dummy
        for ($i = 0; $i < 100; $i++) {
            $tanggalPesan = $faker->dateTimeBetween('-3 months', 'now');
            $status = $faker->randomElement(['diterima', 'diproses', 'siap_diambil', 'selesai']);

            // Jika status selesai, tambahkan tanggal selesai
            $tanggalSelesai = null;
            if ($status === 'selesai') {
                $tanggalSelesai = $faker->dateTimeBetween($tanggalPesan, 'now');
            }

            Order::create([
                'customer_id' => $faker->randomElement($customerIds),
                'service_id' => $faker->randomElement($serviceIds),
                'berat' => $faker->randomFloat(2, 1, 10),
                'total_harga' => $faker->numberBetween(10000, 100000),
                'status' => $status,
                'tanggal_pesan' => $tanggalPesan,
                'tanggal_selesai' => $tanggalSelesai,
                'catatan' => $faker->optional(0.7)->sentence(),
                'user_id' => $faker->randomElement($userIds),
            ]);
        }
    }
}
