# Sistem Manajemen BersihQ

## Deskripsi
Sistem Manajemen BersihQ adalah aplikasi web yang dibangun dengan Laravel untuk mengelola pesanan layanan kebersihan, pelanggan, layanan, dan integrasi WhatsApp untuk notifikasi.

## Fitur
- Manajemen Pelanggan
- Manajemen Layanan
- Manajemen Pesanan
- Laporan Transaksi
- Integrasi WhatsApp untuk notifikasi
- Manajemen Pengguna dengan perbedaan peran (Admin, Kasir)

## Instalasi
1. Clone repositori: `git clone https://github.com/username-anda/bersihq.git`
2. Masuk ke direktori proyek: `cd bersihq`
3. Instal dependensi PHP: `composer install`
4. Instal dependensi JavaScript: `npm install`
5. Salin file environment: `cp .env.example .env`
6. Buat kunci aplikasi: `php artisan key:generate`
7. Konfigurasikan database Anda di file `.env`.
8. Jalankan migrasi database: `php artisan migrate --seed` (flag `--seed` akan menjalankan seeder untuk mengisi data awal)
9. Jalankan server pengembangan: `php artisan serve`
10. Jika Anda menggunakan `npm run dev` untuk kompilasi aset, jalankan di terminal terpisah: `npm run dev`

## Penggunaan
- Akses aplikasi di browser web Anda pada alamat yang disediakan oleh `php artisan serve` (biasanya `http://127.0.0.1:8000`).
- Masuk dengan kredensial yang sesuai:
    - **Admin**: Akses ke semua fitur termasuk manajemen pengguna dan konfigurasi WhatsApp.
    - **Kasir**: Akses ke manajemen pesanan, manajemen pelanggan, dan manajemen layanan.

## Integrasi WhatsApp
- Konfigurasikan pengaturan API WhatsApp melalui dasbor Admin.
- Template untuk pesan WhatsApp dapat dikelola di dalam aplikasi.
- Pastikan layanan/API WhatsApp Anda (misalnya Fonnte) aktif dan terkonfigurasi dengan benar.

## Berkontribusi
Kontribusi sangat diharapkan! Silakan ikuti langkah-langkah berikut:
1. Fork repositori.
2. Buat branch baru (`git checkout -b feature/nama-fitur-anda`).
3. Lakukan perubahan Anda.
4. Commit perubahan Anda (`git commit -m 'Menambahkan beberapa fitur'`).
5. Push ke branch (`git push origin feature/nama-fitur-anda`).
6. Buka Pull Request.
