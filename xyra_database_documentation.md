# Dokumentasi Database Xyra.id (PostgreSQL)

## 1. Arsitektur Umum
Sistem database Xyra.id menggunakan **PostgreSQL** yang di-host melalui **Supabase**. Arsitektur ini dirancang untuk skalabilitas tinggi dengan skema relasional yang dioptimasi menggunakan *Indexing* yang agresif untuk menangani latensi jaringan (network latency) antara Indonesia dan Tokyo.

---

## 2. Standar Identifikasi (Primary Keys)
Sistem ini menggunakan dua jenis *Primary Key* untuk menyeimbangkan antara keamanan dan kemudahan pembacaan (human-readability):

1.  **UUID (Universally Unique Identifier):** Digunakan pada tabel `users`.
    *   **Alasan:** Keamanan tingkat tinggi, ID tidak dapat ditebak (*non-guessable*), mencegah peretasan berbasis *enumeration*.
2.  **Custom String Prefix:** Digunakan pada tabel transaksi dan master.
    *   `BRG-XXXX`: Data Barang
    *   `PLG-XXXX`: Pelanggan
    *   `PMS-XXXX`: Pemasok
    *   `PJ-XXXX`: Penjualan
    *   `PB-XXXX`: Pembelian
    *   `ST-XXXX`: Stok

---

## 3. Kamus Data (Schema)

### 3.1 Tabel: `users`
Tabel utama yang menyimpan identitas pengguna, hak akses, dan data profil yang telah dikonsolidasi.

| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | UUID (PK) | Auto-generated UUID v4 |
| `username` | String (Unique) | Digunakan untuk login |
| `name` | String | Nama lengkap pengguna |
| `password` | String (Hashed) | Menggunakan algoritma Argon2/Bcrypt |
| `role` | Enum | 'admin' atau 'pegawai' (Indexed) |
| `NoTelp_User` | String | Nomor telepon aktif |
| `Alamat_User` | Text | Alamat tempat tinggal |

### 3.2 Tabel: `data_barangs`
Menyimpan metadata produk fashion.

| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `ID_Barang` | String (PK) | ID dengan prefix BRG |
| `ID_Pemasok` | String (FK) | Relasi ke tabel `pemasoks` |
| `Nama_Barang` | String | Nama produk (Indexed) |
| `Jenis_Barang` | String | Kategori: Baju, Celana, dll (Indexed) |
| `Warna_Barang` | String | Varian warna |
| `Ukuran_Barang` | String | S, M, L, XL, All Size |
| `Harga_Beli` | Decimal(15,2) | Harga modal |
| `Harga_Jual` | Decimal(15,2) | Harga ke pelanggan |

### 3.3 Tabel: `penjualans`
Mencatat setiap transaksi keluar.

| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `ID_Penjualan` | String (PK) | ID dengan prefix PJ |
| `user_id` | UUID (FK) | User yang melayani (Indexed) |
| `ID_Barang` | String (FK) | Barang yang terjual (Indexed) |
| `ID_Pelanggan` | String (FK) | Pelanggan pembeli (Indexed) |
| `Tanggal_Penjualan`| Date | Tanggal transaksi (Indexed) |
| `Kuantitas` | Integer | Jumlah barang |
| `Total_Harga` | Decimal(15,2) | Total setelah ongkir |

---

## 4. Strategi Optimasi (Senior Level)

### 4.1 Indexing Strategy
Untuk memastikan aplikasi tetap kencang meskipun data mencapai puluhan ribu baris, kami menerapkan index pada kolom-kolom kritikal:
*   **B-Tree Index:** Diterapkan pada semua *Foreign Keys* (`user_id`, `ID_Barang`, dll).
*   **Date Index:** Diterapkan pada kolom tanggal untuk mempercepat *Reporting*.
*   **Composite/Single Index:** Diterapkan pada kolom pencarian seperti `Nama_Barang` dan `username`.

### 4.2 Database Transactions
Seluruh operasi yang melibatkan lebih dari satu tabel (misal: Simpan Penjualan + Kurangi Stok) dibungkus dalam `DB::beginTransaction()`. Ini menjamin prinsip **Atomicity**: Jika salah satu gagal, maka seluruh operasi dibatalkan (*Rollback*) untuk mencegah ketidaksinkronan data.

### 4.3 Referential Integrity
Menggunakan *Foreign Key Constraints* dengan aturan:
*   `onDelete('cascade')`: Jika data master (Barang) dihapus, riwayat terkait juga ikut bersih.
*   `onDelete('set null')`: Untuk User, jika user dihapus, transaksi tetap ada namun identitas usernya menjadi kosong (anonim) demi kepentingan sejarah akuntansi.

---
*EOF - Database Documentation*
