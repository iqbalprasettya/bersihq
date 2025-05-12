<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'nama_layanan' => 'Cuci Kiloan Regular',
                'deskripsi' => 'Layanan cuci regular dengan durasi 2-3 hari',
                'harga' => 7000,
                'is_active' => true,
            ],
            [
                'nama_layanan' => 'Cuci Kiloan Express',
                'deskripsi' => 'Layanan cuci express selesai dalam 24 jam',
                'harga' => 10000,
                'is_active' => true,
            ],
            [
                'nama_layanan' => 'Cuci Satuan',
                'deskripsi' => 'Layanan cuci untuk pakaian khusus (jas, gaun, dll)',
                'harga' => 25000,
                'is_active' => true,
            ],
            [
                'nama_layanan' => 'Setrika Saja',
                'deskripsi' => 'Layanan setrika untuk pakaian yang sudah bersih',
                'harga' => 5000,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
