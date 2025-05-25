<?php

namespace Database\Seeders;

use App\Models\WhatsAppTemplate;
use Illuminate\Database\Seeder;

class WhatsAppTemplateSeeder extends Seeder
{
    public function run()
    {
        // Template untuk notifikasi pesanan siap diambil
        WhatsAppTemplate::create([
            'nama' => 'Notifikasi Pesanan Siap',
            'kode' => 'siap_diambil',
            'konten' => "Halo *{nama}*!\n\n"
                . "Cucian Anda dengan nomor order *#{nomor_order}* sudah selesai dan siap untuk diambil.\n\n"
                . "Detail Pesanan:\n"
                . "- Layanan: {layanan}\n"
                . "- Berat: {berat} kg\n"
                . "- Total: Rp {total}\n\n"
                . "Silakan datang ke outlet kami untuk mengambil cucian Anda.\n\n"
                . "Terima kasih telah menggunakan jasa *BersihQ Laundry* 🙏",
            'variabel' => ['nama', 'nomor_order', 'layanan', 'berat', 'total'],
            'is_active' => true
        ]);

        // Template untuk notifikasi pesanan diterima
        WhatsAppTemplate::create([
            'nama' => 'Notifikasi Pesanan Diterima',
            'kode' => 'diterima',
            'konten' => "Halo *{nama}*!\n\n"
                . "Terima kasih telah mempercayakan cucian Anda kepada *BersihQ Laundry*.\n\n"
                . "Detail Pesanan:\n"
                . "- No. Order: *#{nomor_order}*\n"
                . "- Layanan: {layanan}\n"
                . "- Berat: {berat} kg\n"
                . "- Total: Rp {total}\n\n"
                . "Kami akan memberitahu Anda ketika cucian sudah selesai dan siap diambil.\n\n"
                . "Terima kasih! 🙏",
            'variabel' => ['nama', 'nomor_order', 'layanan', 'berat', 'total'],
            'is_active' => true
        ]);

        // Template untuk notifikasi pesanan sedang diproses
        WhatsAppTemplate::create([
            'nama' => 'Notifikasi Pesanan Diproses',
            'kode' => 'diproses',
            'konten' => "Halo *{nama}*!\n\n"
                . "Cucian Anda dengan nomor order *#{nomor_order}* sedang dalam proses pengerjaan.\n\n"
                . "Kami akan memberitahu Anda ketika cucian sudah selesai dan siap diambil.\n\n"
                . "Terima kasih atas kesabarannya! 🙏",
            'variabel' => ['nama', 'nomor_order'],
            'is_active' => true
        ]);
    }
}
