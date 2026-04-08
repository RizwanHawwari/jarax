```markdown
# JaRax - E-Commerce Modern

![JaRax Banner](https://via.placeholder.com/1200x400/FF6B35/ffffff?text=JaRax+E-Commerce)

JaRax adalah platform **e-commerce modern** yang dibangun dengan Laravel 12, Tailwind CSS, dan Vite. Dirancang dengan antarmuka yang clean, cepat, dan user-friendly, cocok untuk bisnis fashion, elektronik, serta berbagai kategori produk lainnya.

## ✨ Fitur Utama

### Untuk Pengguna (User)
- **Dashboard & Landing Page** yang menarik dengan animasi
- **Katalog Produk** lengkap dengan filter kategori, pencarian, dan sorting
- **Detail Produk** dengan quantity selector dan rekomendasi
- **Keranjang Belanja** dengan fitur pilih item
- **Checkout** cepat (Buy Now + Cart Checkout)
- **Payment Method** (Transfer Bank, E-Wallet, COD, QRIS)
- **Upload Bukti Pembayaran**
- **Riwayat Pesanan** dan status tracking
- **Live Search** dengan suggestion
- **Responsive Design** (Mobile Friendly)

### Untuk Admin & Petugas
- **Admin Dashboard** dengan statistik penjualan
- **Manajemen Produk** (CRUD lengkap)
- **Manajemen Transaksi** (verifikasi, proses pengiriman, selesai)
- **Manajemen User** (ban/unban user)
- **Laporan Penjualan & Stok**
- **Backup Database**
- **Kelola Petugas** (hanya Admin)

### Role Sistem
- **Admin** → Akses penuh (termasuk kelola petugas)
- **Petugas** → Akses ke dashboard, produk, transaksi, users, reports, backup
- **User Biasa** → Hanya fitur belanja

---

## 🚀 Cara Instalasi

### Persyaratan Sistem
- **PHP** ≥ 8.2 (direkomendasikan 8.2 atau 8.3)
- **Composer**
- **Node.js** & NPM
- Database (MySQL / MariaDB / PostgreSQL)

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/username/jarax.git
   cd jarax
   ```

2. **Install Dependencies PHP**
   ```bash
   composer install
   ```

3. **Setup Environment**
   ```bash
   cp .env.example .env
   ```

   Edit file `.env` sesuai konfigurasi database kamu.

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Migrate Database + Seed**
   ```bash
   php artisan migrate --seed
   ```

6. **Install Dependencies Frontend**
   ```bash
   npm install
   ```

7. **Build Assets**
   ```bash
   npm run dev
   ```
   Untuk production gunakan:
   ```bash
   npm run build
   ```

8. **Jalankan Server**
   ```bash
   php artisan serve
   ```

---

## 📋 Akun Default

### Admin
- **Email**    : `admin@jarax.com`
- **Password** : `password`

### Petugas
- **Email**    : `budi@jarax.com`
- **Password** : `password`

### User Biasa
- **Email**    : `budi@jarax.com`
- **Password** : `password`

> **Catatan**: Password default untuk semua akun adalah `password`

---

## 🛠️ Teknologi yang Digunakan

- **Backend**     : Laravel 12
- **Frontend**    : Tailwind CSS + Alpine.js
- **Build Tool**  : Vite
- **Database**    : MySQL / MariaDB
- **Authentication** : Laravel Fortify / Breeze
- **Icons**       : Heroicons & SVG

---

## 📁 Struktur Folder Penting

```
jarax/
├── app/Models/           → Model (User, Product, Transaction, dll)
├── app/Http/Controllers/ → Controller Admin & User
├── resources/views/      → Blade Templates
├── public/storage/       → Upload gambar produk & bukti bayar
├── routes/web.php        → Semua route aplikasi
└── bootstrap/app.php     → Konfigurasi middleware Laravel 12
```

---

## 🤝 Kontribusi

Kontribusi sangat dihargai! Silakan fork repository ini dan buat Pull Request.

---

## 📄 Lisensi

Project ini dibuat untuk keperluan pribadi / pembelajaran.

---