<?php

namespace Database\Seeders;

use App\Models\DataBarang;
use Illuminate\Database\Seeder;

class DataBarangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Baju
            ['ID_Barang' => 'BRG-0001', 'Nama_Barang' => 'Kaos Polos Cotton Combed 30s', 'Jenis_Barang' => 'Baju', 'Warna_Barang' => 'Hitam', 'Ukuran_Barang' => 'L', 'ID_Pemasok' => 'PMS-0007', 'Harga_Beli' => 35000, 'Harga_Jual' => 55000],
            ['ID_Barang' => 'BRG-0002', 'Nama_Barang' => 'Kaos Polos Cotton Combed 30s', 'Jenis_Barang' => 'Baju', 'Warna_Barang' => 'Putih', 'Ukuran_Barang' => 'M', 'ID_Pemasok' => 'PMS-0007', 'Harga_Beli' => 35000, 'Harga_Jual' => 55000],
            ['ID_Barang' => 'BRG-0003', 'Nama_Barang' => 'Kemeja Flannel Premium', 'Jenis_Barang' => 'Baju', 'Warna_Barang' => 'Merah Kotak', 'Ukuran_Barang' => 'XL', 'ID_Pemasok' => 'PMS-0001', 'Harga_Beli' => 120000, 'Harga_Jual' => 185000],
            ['ID_Barang' => 'BRG-0004', 'Nama_Barang' => 'Hoodie Oversize Heavyweight', 'Jenis_Barang' => 'Baju', 'Warna_Barang' => 'Navy', 'Ukuran_Barang' => 'XXL', 'ID_Pemasok' => 'PMS-0002', 'Harga_Beli' => 150000, 'Harga_Jual' => 250000],
            
            // Celana
            ['ID_Barang' => 'BRG-0005', 'Nama_Barang' => 'Celana Chino Slim Fit', 'Jenis_Barang' => 'Celana', 'Warna_Barang' => 'Krem', 'Ukuran_Barang' => 'L', 'ID_Pemasok' => 'PMS-0003', 'Harga_Beli' => 95000, 'Harga_Jual' => 145000],
            ['ID_Barang' => 'BRG-0006', 'Nama_Barang' => 'Celana Jeans Denim 14oz', 'Jenis_Barang' => 'Celana', 'Warna_Barang' => 'Indigo', 'Ukuran_Barang' => 'M', 'ID_Pemasok' => 'PMS-0001', 'Harga_Beli' => 180000, 'Harga_Jual' => 299000],
            ['ID_Barang' => 'BRG-0007', 'Nama_Barang' => 'Celana Cargo Tactical', 'Jenis_Barang' => 'Celana', 'Warna_Barang' => 'Hijau Army', 'Ukuran_Barang' => 'XL', 'ID_Pemasok' => 'PMS-0005', 'Harga_Beli' => 110000, 'Harga_Jual' => 175000],
            
            // Gamis
            ['ID_Barang' => 'BRG-0008', 'Nama_Barang' => 'Gamis Syari Premium Silk', 'Jenis_Barang' => 'Gamis', 'Warna_Barang' => 'Maroon', 'Ukuran_Barang' => 'All Size', 'ID_Pemasok' => 'PMS-0006', 'Harga_Beli' => 250000, 'Harga_Jual' => 450000],
            ['ID_Barang' => 'BRG-0009', 'Nama_Barang' => 'Gamis Katun Jepang Motif', 'Jenis_Barang' => 'Gamis', 'Warna_Barang' => 'Biru Muda', 'Ukuran_Barang' => 'L', 'ID_Pemasok' => 'PMS-0006', 'Harga_Beli' => 130000, 'Harga_Jual' => 210000],
            
            // Aksesoris
            ['ID_Barang' => 'BRG-0010', 'Nama_Barang' => 'Topi Baseball Bordir', 'Jenis_Barang' => 'Aksesoris', 'Warna_Barang' => 'Hitam', 'Ukuran_Barang' => 'All Size', 'ID_Pemasok' => 'PMS-0010', 'Harga_Beli' => 25000, 'Harga_Jual' => 45000],
            ['ID_Barang' => 'BRG-0011', 'Nama_Barang' => 'Ikat Pinggang Kulit Sapi', 'Jenis_Barang' => 'Aksesoris', 'Warna_Barang' => 'Coklat Tua', 'Ukuran_Barang' => 'All Size', 'ID_Pemasok' => 'PMS-0008', 'Harga_Beli' => 75000, 'Harga_Jual' => 125000],
            ['ID_Barang' => 'BRG-0012', 'Nama_Barang' => 'Kaos Kaki Sport Anti-Bakteri', 'Jenis_Barang' => 'Aksesoris', 'Warna_Barang' => 'Abu-abu', 'Ukuran_Barang' => 'All Size', 'ID_Pemasok' => 'PMS-0010', 'Harga_Beli' => 12000, 'Harga_Jual' => 25000],
        ];

        foreach ($data as $item) {
            DataBarang::updateOrCreate(['ID_Barang' => $item['ID_Barang']], $item);
        }
    }
}
