# Xyra.id - Dokumentasi Teknis (Internal V1.0)

## 1. Ringkasan Eksekutif
Xyra.id adalah aplikasi manajemen inventaris pakaian berperforma tinggi berbasis **Single Page Application (SPA)** yang dibangun di atas framework **Laravel 12**. Sistem ini memprioritaskan kecepatan, keamanan, dan integritas data, menggunakan backend **Supabase (PostgreSQL)** dengan lapisan *Caching* canggih untuk mengatasi latensi geografis antara server database (Tokyo) dan pengguna (Indonesia).

---

## 2. Stack Teknologi
- **Framework:** Laravel 12.x (PHP 8.2+)
- **Database:** PostgreSQL (Supabase Tokyo ap-northeast-1)
- **Frontend:** Tailwind CSS (Modern UI), Alpine.js (Interactivity)
- **Engine:** Livewire v3 (SPA Engine melalui `wire:navigate`)
- **Containerization:** Docker (Alpine-based, Nginx + PHP-FPM)
- **Caching:** Hybrid Local Storage (Berbasis File/RAM)

---

## 3. Arsitektur Database
Sistem menggunakan skema relasional yang disederhanakan dengan *Indexing* yang dioptimasi untuk transaksi volume tinggi.

### 3.1 Konsolidasi Skema
Tabel `admins` yang sebelumnya terpisah telah digabungkan (*Merged*) ke dalam tabel `users`. Hal ini mengurangi beban *JOIN* database dan meningkatkan performa query secara signifikan.

### 3.2 Definisi Tabel Utama
#### users
- `id` (UUID, Primary Key) - Identitas unik yang aman dan tidak dapat ditebak.
- `role` (Enum: admin, pegawai) - Digunakan untuk kontrol akses (*Access Control*).
- `NoTelp_User`, `Alamat_User` - Data profil yang sudah dikonsolidasi.

#### penjualans (Sales)
- Mencatat transaksi keluar ke pelanggan. Terhubung ke `user_id` untuk mencatat staf mana yang melakukan penjualan.
- **Indexes:** `Tanggal_Penjualan`, `user_id`, `ID_Barang`.

---

## 4. Optimasi Performa (Senior Architect Level)

### 4.1 Strategi Hybrid Caching
Untuk melawan latensi fisik 60-90ms ke Tokyo, aplikasi menerapkan sistem *Caching* multi-layer:

1. **Auth Caching (`CachedUserProvider`):** 
   Secara default, Laravel melakukan query user pada SETIAP request. Kami melakukan *bypass* dengan membuat *Custom User Provider* yang menyimpan profil user di memori lokal selama 3600 detik. Ini menghilangkan *delay* database ~1 detik per request.
   
2. **Dashboard Aggregation:** 
   Operasi berat seperti `SUM()` dan `COUNT()` pada dashboard di-cache secara global. Cache akan otomatis dihapus (*Invalidated*) melalui **Model Observers** setiap kali ada perubahan data pada transaksi atau stok.

3. **Resource List Caching:**
   Data statis untuk dropdown (Produk, Supplier, Pelanggan) di-cache selamanya (*Forever*) di lokal.
   - **Hasil:** Waktu muat form turun dari ~800ms menjadi kurang dari 10ms.

### 4.2 Implementasi SPA
Sistem menggunakan fitur `wire:navigate` dari Livewire untuk mengubah tampilan Blade standar menjadi aplikasi yang terasa instan.
- **DOM Diet:** Dropdown dan submenu sidebar menggunakan `<template x-if="...">` untuk mencegah penumpukan memori di browser.
- **Progress Bar:** Indikator loading berwarna teal (`bg-teal-600`) memberikan umpan balik visual selama transisi SPA.

---

## 5. Keamanan & Penguatan (Hardening)

### 5.1 Perlindungan SQL Injection
Aplikasi secara ketat menggunakan **Eloquent ORM** dan **Query Builder**. Tidak diperbolehkan menggunakan *Raw SQL string*. Hal ini menjamin semua input disanitasi melalui *PDO Parameter Binding* di tingkat framework.

### 5.2 Server-Side Sorting (Sargable Queries)
Untuk memastikan index PostgreSQL digunakan dengan benar:
- Menghindari `whereDate()` yang memaksa *Type-Casting*.
- Menggunakan `whereBetween()` untuk pencarian rentang, memungkinkan database menggunakan *B-Tree Index* pada kolom tanggal secara optimal.

---

## 6. Deployment & Docker
Sistem dirancang untuk berjalan di **Render.com** menggunakan Docker Image berbasis Alpine Linux yang sangat ringan.
- **Web Server:** Nginx (mendengarkan port dinamis `$PORT`).
- **Frontend Build:** `npm run build` dijalankan saat proses *build* Docker untuk memastikan aset sudah terkompresi dan memiliki *fingerprint* versi terbaru.

---
*EOF (Technical Documentation)*
