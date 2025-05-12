
# 📘 Catatan Struktur Data & SQL Aplikasi Laundry "BersihQ"

## 🧠 Konsep Aplikasi

Aplikasi "BersihQ" adalah sistem web kasir untuk UMKM laundry. Fokusnya adalah mencatat pesanan pelanggan, menyimpan nomor WhatsApp untuk kebutuhan promosi (blast via fonnte.com), serta menampilkan layanan laundry yang tersedia.

Aplikasi hanya digunakan oleh kasir/pemilik (bukan pelanggan), dan dirancang agar hemat, responsif di HP, serta mudah dipakai.

---

## 📂 Entitas & Data Model

### 1. `users` (Pengguna / Kasir)

- `id`: ID unik
- `username`: Nama pengguna unik
- `password`: Password terenkripsi
- `nama`: Nama lengkap pengguna
- `role`: admin / kasir

### 2. `customers` (Pelanggan)

- `id`: ID unik pelanggan
- `nama`: Nama pelanggan
- `no_wa`: Nomor WhatsApp pelanggan
- `alamat`: Alamat (opsional)
- `email`: Email (opsional)

### 3. `services` (Layanan Laundry)

- `id`: ID unik layanan
- `nama_layanan`: Nama layanan (misal: Cuci Kiloan)
- `deskripsi`: Penjelasan (opsional)
- `harga`: Harga per kg/satuan
- `is_active`: Status aktif layanan

### 4. `orders` (Pesanan Laundry)

- `id`: ID unik pesanan
- `customer_id`: Relasi ke `customers`
- `service_id`: Relasi ke `services`
- `berat`: Jumlah kg (opsional)
- `total_harga`: Harga total pesanan
- `status`: Status pesanan (`diterima`, `diproses`, `selesai`, `diambil`)
- `tanggal_pesan`: Tanggal dibuat
- `tanggal_selesai`: Tanggal selesai
- `catatan`: Keterangan tambahan

---

## 🛠️ SQL Schema (Raw SQL MySQL)

### Tabel `users`

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    role ENUM('admin', 'kasir') DEFAULT 'kasir',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Tabel `customers`

```sql
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    no_wa VARCHAR(20) NOT NULL,
    alamat TEXT,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Tabel `services`

```sql
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_layanan VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    harga DECIMAL(10,2) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Tabel `orders`

```sql
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    service_id INT NOT NULL,
    berat DECIMAL(5,2),
    total_harga DECIMAL(10,2) NOT NULL,
    status ENUM('diterima', 'diproses', 'selesai', 'diambil') DEFAULT 'diterima',
    tanggal_pesan DATETIME DEFAULT CURRENT_TIMESTAMP,
    tanggal_selesai DATETIME,
    catatan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_customer FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    CONSTRAINT fk_service FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE SET NULL
);
```

---

## 🚀 Catatan Tambahan

- Seluruh tabel menggunakan `created_at` dan `updated_at`.
- Data pelanggan bisa diekspor untuk keperluan promosi ke WhatsApp.
- Bisa ditambahkan `user_id` di orders jika ingin tahu siapa yang input data.
- Struktur ringan dan cocok untuk skala UMKM.

---

Siap digunakan sebagai basis pengembangan Laravel tanpa Filament. Untuk proyek frontend, disarankan menggunakan Blade + Tailwind agar ringan dan fleksibel.

> Next step: Buat Laravel migration dan UI dashboard kasir sederhana (mobile first).
