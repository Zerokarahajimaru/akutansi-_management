# Xyra.id - Dokumentasi Alur Akuntansi & Operasional

## 1. Pendahuluan
Selamat datang di Sistem Manajemen Inventaris Xyra.id. Dokumen ini menjelaskan logika finansial dan operasional aplikasi untuk memastikan data akuntansi tetap akurat, dapat diaudit (*auditable*), dan konsisten.

---

## 2. Struktur Organisasi (Roles)

### 2.1 Administrator (Pemilik/Manajer)
- **Izin:** Akses penuh ke seluruh sistem.
- **Tugas Utama:** 
  - Manajemen Pengguna (Membuat akun pegawai).
  - Manajemen Data Master (Mengatur harga dasar produk).
  - Audit akhir laporan keuangan.
  - Mengoreksi transaksi yang salah.

### 2.2 Pegawai (Staf Operasional)
- **Izin:** Terbatas pada operasional harian.
- **Tugas Utama:**
  - Mencatat penjualan harian.
  - Mencatat stok masuk (Pembelian).
  - Mengelola data kontak pelanggan dan supplier.
- **Batasan:** Tidak dapat menghapus user, tidak dapat mengubah hak akses sendiri, dan tidak dapat melihat log administratif sensitif.

---

## 3. Siklus Inventaris (Alur Akuntansi)

### 3.1 Tahap 1: Pengadaan (Pembelian)
Saat stok baru datang dari Supplier:
1. Staf membuka menu **"Tambah Data > Pembelian"**.
2. Memilih **Supplier** dan **Produk**.
3. Memasukkan **Kuantitas** dan **Harga Beli**.
4. **Logika Akuntansi:** 
   - Sistem otomatis menambah `Stok_Akhir` di tabel inventaris.
   - Catatan transaksi dibuat untuk laporan pengeluaran modal (*Capital Expenditure*).
   - Biaya kirim (*Ongkir*) dicatat terpisah untuk memungkinkan perhitungan harga pokok penjualan.

### 3.2 Tahap 2: Penjualan
Saat pelanggan melakukan pembelian:
1. Staf membuka menu **"Tambah Data > Penjualan"**.
2. **Verifikasi Stok:** Sistem mengecek apakah `Stok_Akhir` mencukupi. Jika stok terlalu rendah, transaksi akan **diblokir** otomatis.
3. **Input Transaksi:** Staf mencatat jumlah dan metode pembayaran (Tunai, Transfer, atau QRIS).
4. **Logika Akuntansi:**
   - Sistem otomatis mengurangi `Stok_Akhir`.
   - `Total_Harga` dihitung berdasarkan harga jual aktif di Data Master.

---

## 4. Integritas Data & Audit

### 4.1 Keamanan UUID
Setiap pengguna memiliki ID unik berupa rangkaian kode acak panjang (UUID). Hal ini memastikan log transaksi tidak dapat dimanipulasi atau ditebak, memberikan jejak audit (*Audit Trail*) yang aman mengenai siapa yang melakukan setiap penjualan dan pembelian.

### 4.2 Sinkronisasi Stok Otomatis
Anda tidak perlu memperbarui jumlah stok secara manual. Setiap kali "Penjualan" atau "Pembelian" disimpan, sistem menggunakan **Database Transactions**.
- **Prinsip "Semua atau Tidak Sama Sekali":** Jika penyimpanan data penjualan gagal karena alasan apapun, stok TIDAK akan berkurang. Ini menjamin buku besar selalu seimbang dengan jumlah fisik di gudang.

---

## 5. Prosedur Harian untuk Staf

### 5.1 Pembukaan Shift
- Login dengan *username* unik Anda.
- Cek Dashboard untuk melihat peringatan "Stok Kritis" yang butuh pemesanan ulang segera.

### 5.2 Penutupan Shift
- Buka menu **"Laporan > Penjualan"**.
- Atur filter ke tanggal hari ini.
- Verifikasi bahwa "Total Harga" cocok dengan saldo tunai/transfer yang diterima seharian.
- Gunakan fitur **"Export CSV"** untuk mengirim salinan laporan harian ke bagian keuangan.

---
*EOF (Accounting Flow Documentation)*
