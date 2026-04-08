# 🛍️ JaRax — Modern E-Commerce Platform

<p>
  <img src="https://iili.io/BYZiGf9.png" alt="JaRax Banner 1" width="45%" style="display:inline-block; margin-right:5%;" />
  <img src="https://iili.io/BYZDqRn.png" alt="JaRax Banner 2" width="45%" style="display:inline-block;" />
</p>

> 🚀 Platform **e-commerce modern** berbasis Laravel 12 dengan tampilan clean, performa cepat, dan pengalaman pengguna yang optimal.

JaRax dirancang untuk berbagai kebutuhan bisnis seperti **fashion, elektronik, hingga produk umum**, dengan sistem yang scalable dan mudah dikembangkan.

---

## ✨ Highlights

- ⚡ Fast & Modern UI (Tailwind + Vite)
- 📱 Fully Responsive (Mobile First)
- 🛒 Complete E-Commerce Flow
- 🔐 Multi Role System (Admin, Petugas, User)
- 📊 Dashboard & Analytics
- 🤖 Siap dikembangkan ke AI Chat / Automation

---

## 👤 Fitur Pengguna (User)

- 🏠 Landing page modern & interaktif  
- 🔍 Pencarian produk + live search suggestion  
- 🛍️ Katalog produk dengan filter & sorting  
- 📦 Detail produk + rekomendasi  
- 🛒 Keranjang belanja (multi select item)  
- ⚡ Checkout cepat (Buy Now / Cart)  
- 💳 Multi metode pembayaran:
  - Transfer Bank  
  - E-Wallet  
  - COD  
  - QRIS  
- 📤 Upload bukti pembayaran  
- 📜 Riwayat pesanan + tracking status  
- 📱 Tampilan responsif (mobile friendly)  

---

## 🛠️ Fitur Admin & Petugas

- 📊 Dashboard statistik penjualan  
- 📦 Manajemen produk (CRUD lengkap)  
- 💰 Manajemen transaksi & verifikasi pembayaran  
- 🚚 Update status pengiriman  
- 👥 Manajemen user (ban / unban)  
- 🧾 Laporan penjualan & stok  
- 💾 Backup database  
- 🧑‍💼 Manajemen petugas *(khusus admin)*  

---

## 🔐 Role System

| Role     | Akses |
|----------|------|
| 👑 Admin | Full access |
| 🧑‍💼 Petugas | Kelola transaksi & operasional |
| 👤 User  | Belanja & transaksi |

---

## 🚀 Instalasi

### ⚙️ Persyaratan
- PHP ≥ 8.2
- Composer
- Node.js & NPM
- MySQL / MariaDB / PostgreSQL

---

### 📥 Langkah Setup

```bash
# Clone repo
git clone https://github.com/username/jarax.git
cd jarax

# Install backend
composer install

# Setup environment
cp .env.example .env

# Generate key
php artisan key:generate

# Migrate & seed database
php artisan migrate --seed

# Install frontend
npm install

# Run development
npm run dev

# Jalankan server
php artisan serve
````

🔗 Akses: `http://127.0.0.1:8000`

---

## 🔑 Akun Default

### 👑 Admin

* Email: `admin@jarax.com`
* Password: `password`

### 👤 User

* Email: `budi@jarax.com`
* Password: `password`

> ⚠️ Segera ganti password setelah login untuk keamanan.

---

## 🧰 Tech Stack

| Layer      | Teknologi                |
| ---------- | ------------------------ |
| Backend    | Laravel 12               |
| Frontend   | Tailwind CSS, Alpine.js  |
| Build Tool | Vite                     |
| Database   | MySQL / MariaDB          |
| Auth       | Laravel Breeze / Fortify |
| Icons      | Heroicons                |

---

## 📂 Struktur Project

```
jarax/
├── app/
│   ├── Models/
│   └── Http/Controllers/
├── resources/views/
├── routes/web.php
├── public/storage/
└── bootstrap/app.php
```

---

## 📸 Preview (Opsional)

Tambahkan screenshot biar makin menarik:

```
/public/images/preview-1.png
/public/images/preview-2.png
```

Lalu tampilkan di README:

```markdown
![Preview](public/images/preview-1.png)
```

---

## 🤝 Kontribusi

Kontribusi terbuka untuk siapa saja!

1. Fork repository
2. Buat branch baru
3. Commit perubahan
4. Submit Pull Request

---

## 📄 Lisensi

Project ini dibuat untuk:

* 📚 Pembelajaran
* 💼 Portfolio
* 🚀 Pengembangan lebih lanjut

---

## 💡 Future Improvement

* 🤖 AI Customer Service (ChatBot)
* 🔔 Notifikasi real-time
* 💳 Payment gateway integration (Midtrans / Xendit)
* 📦 Sistem tracking otomatis
* 📊 Advanced analytics dashboard

---

## ⭐ Support

Kalau project ini membantu kamu, jangan lupa:

👉 **Star repo ini di GitHub!**

---
