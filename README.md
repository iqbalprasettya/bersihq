# Sistem Manajemen BersihQ

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

<p align="center">
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework?style=for-the-badge" alt="Versi Laravel"></a>
  <img src="https://img.shields.io/badge/PHP-^8.2-blue?style=for-the-badge" alt="Versi PHP">
  <a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/Lisensi-MIT-green?style=for-the-badge" alt="Lisensi MIT"></a>
  <!-- Anda bisa menambahkan lencana lain di sini jika relevan, misalnya status build, coverage, dll. -->
</p>

## Deskripsi
Sistem Manajemen BersihQ adalah aplikasi web yang dibangun dengan Laravel untuk mengelola pesanan layanan kebersihan, pelanggan, layanan, dan integrasi WhatsApp untuk notifikasi. Aplikasi ini bertujuan untuk memudahkan pengelolaan operasional bisnis kebersihan.

## Fitur Utama
- 🧼 **Manajemen Pelanggan**: Kelola data pelanggan dengan mudah.
- 🧹 **Manajemen Layanan**: Atur jenis-jenis layanan yang ditawarkan.
- 📝 **Manajemen Pesanan**: Catat dan lacak status pesanan layanan.
- 📊 **Laporan Transaksi**: Hasilkan laporan untuk analisis bisnis.
- 📱 **Integrasi WhatsApp**: Kirim notifikasi otomatis kepada pelanggan.
- 👥 **Manajemen Pengguna**: Sistem peran pengguna (Admin, Kasir) untuk keamanan dan kemudahan akses.

---

## Prasyarat
Pastikan lingkungan pengembangan Anda memenuhi persyaratan berikut:
- PHP >= 8.2
- Composer
- Node.js & NPM
- Database (MySQL, PostgreSQL, SQLite, atau SQL Server)

---

## Instalasi
Berikut adalah langkah-langkah untuk menginstal dan menjalankan proyek ini:

1.  **Clone Repositori**
    ```bash
    git clone https://github.com/username-anda/bersihq.git
    cd bersihq
    ```

2.  **Instal Dependensi**
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Environment**
    Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasinya, terutama koneksi database.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    Pastikan Anda telah membuat database dan mengkonfigurasi aksesnya di file `.env`:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=bersihq_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Migrasi dan Seeding Database**
    Jalankan migrasi untuk membuat tabel database dan seeder untuk mengisi data awal (opsional namun direkomendasikan).
    ```bash
    php artisan migrate --seed
    ```

5.  **Jalankan Aplikasi**
    ```bash
    php artisan serve
    ```
    Jika Anda menggunakan Vite untuk kompilasi aset, jalankan juga di terminal terpisah:
    ```bash
    npm run dev
    ```

Aplikasi sekarang seharusnya berjalan di `http://127.0.0.1:8000`.

---

## Penggunaan Aplikasi
Setelah instalasi berhasil, Anda dapat mengakses aplikasi melalui browser.

-   **Halaman Login**: Akses `http://127.0.0.1:8000/login`
-   **Kredensial Default** (jika menggunakan seeder):
    -   **Admin**:
        -   Email: `admin@example.com`
        -   Password: `password`
    -   **Kasir**:
        -   Email: `kasir@example.com`
        -   Password: `password`

### Peran Pengguna:
-   **Admin**: Memiliki akses penuh ke semua fitur, termasuk konfigurasi sistem, manajemen pengguna, dan pengaturan integrasi WhatsApp.
-   **Kasir**: Dapat mengelola pesanan, pelanggan, dan layanan. Tidak memiliki akses ke pengaturan sistem.

---

## Integrasi WhatsApp
Aplikasi ini mendukung pengiriman notifikasi WhatsApp kepada pelanggan.

-   **Konfigurasi**: Pengaturan API WhatsApp (misalnya, token Fonnte) dilakukan melalui dasbor Admin.
-   **Template Pesan**: Admin dapat mengelola template pesan WhatsApp yang akan digunakan untuk notifikasi.
-   Pastikan layanan WhatsApp API pihak ketiga Anda aktif dan terkonfigurasi dengan benar di sistem.

---

## Berkontribusi
Kontribusi Anda sangat kami hargai! Jika Anda ingin berkontribusi pada proyek ini, silakan ikuti langkah-langkah berikut:

1.  **Fork** repositori ini.
2.  Buat **branch** baru untuk fitur Anda (`git checkout -b feature/NamaFiturAnda`).
3.  Lakukan **perubahan** dan **commit** (`git commit -m 'Menambahkan: NamaFiturAnda'`).
4.  **Push** ke branch Anda (`git push origin feature/NamaFiturAnda`).
5.  Buka **Pull Request** ke branch `main` atau `develop` repositori ini.

Pastikan untuk menulis pesan commit yang jelas dan deskriptif.

---

Jika Anda menemukan bug atau memiliki saran, silakan buat *issue* baru di repositori GitHub ini.
