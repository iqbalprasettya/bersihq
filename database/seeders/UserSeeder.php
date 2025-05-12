<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat akun admin
        User::create([
            'username' => 'admin',
            'nama' => 'Administrator',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Buat akun kasir
        User::create([
            'username' => 'kasir',
            'nama' => 'Kasir Laundry',
            'password' => Hash::make('kasir123'),
            'role' => 'kasir',
        ]);
    }
}
