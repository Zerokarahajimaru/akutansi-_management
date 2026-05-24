<?php

namespace Database\Seeders;

use App\Models\DataBarang;
use App\Models\Pemasok;
use App\Models\StokBarang;
use App\Models\User;
use Illuminate\Database\Seeder;

class DataBarangSeeder extends Seeder
{
    public function run(): void
    {
        $pemasoks = Pemasok::all();
        $admin = User::first();

        $data = [
            ['Nama_Barang' => 'Gamis Syari Alya', 'Jenis_Barang' => 'Gamis', 'Warna_Barang' => 'Dusty Pink', 'Ukuran_Barang' => 'M', 'Harga_Beli' => 150000, 'Harga_Jual' => 225000],
            ['Nama_Barang' => 'Koko Modern Al-Fatih', 'Jenis_Barang' => 'Baju', 'Warna_Barang' => 'Navy Blue', 'Ukuran_Barang' => 'L', 'Harga_Beli' => 120000, 'Harga_Jual' => 185000],
            ['Nama_Barang' => 'Hijab Bergo Instan', 'Jenis_Barang' => 'Aksesoris', 'Warna_Barang' => 'Hitam', 'Ukuran_Barang' => 'All Size', 'Harga_Beli' => 35000, 'Harga_Jual' => 55000],
            ['Nama_Barang' => 'Celana Chino Slim', 'Jenis_Barang' => 'Celana', 'Warna_Barang' => 'Khaki', 'Ukuran_Barang' => 'XL', 'Harga_Beli' => 140000, 'Harga_Jual' => 210000],
            ['Nama_Barang' => 'Tunik Batik Cantika', 'Jenis_Barang' => 'Baju', 'Warna_Barang' => 'Maroon', 'Ukuran_Barang' => 'L', 'Harga_Beli' => 110000, 'Harga_Jual' => 175000],
        ];

        foreach ($data as $i => $item) {
            $pemasok = $pemasoks->random();
            $id_barang = DataBarang::generateId('BRG');
            
            DataBarang::create(array_merge($item, [
                'ID_Barang' => $id_barang,
                'ID_Pemasok' => $pemasok->ID_Pemasok
            ]));

            StokBarang::create([
                'ID_Stok' => 'STK-' . substr($id_barang, 4),
                'user_id' => $admin->id,
                'ID_Pemasok' => $pemasok->ID_Pemasok,
                'ID_Barang' => $id_barang,
                'Stok_Awal' => 50,
                'Stok_Akhir' => 50,
            ]);
        }
    }
}
