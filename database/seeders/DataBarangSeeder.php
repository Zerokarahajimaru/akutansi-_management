<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DataBarang; // Import the DataBarang model
use App\Models\Pemasok; // Import the Pemasok model
use Illuminate\Support\Str; // Import Str for UUID

class DataBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first Pemasok record to link the products
        $pemasok1 = Pemasok::first();
        $pemasok2 = Pemasok::skip(1)->first(); // Get the second pemasok

        DataBarang::create([
            'ID_Barang' => (string) Str::uuid(),
            'ID_Pemasok' => $pemasok1->ID_Pemasok,
            'Jenis_Barang' => 'Atasan',
            'Nama_Barang' => 'Kaos Polos',
            'Warna_Barang' => 'Putih',
            'Ukuran_Barang' => 'M',
            'Harga_Beli' => 25000.00,
            'Harga_Jual' => 45000.00,
        ]);

        DataBarang::create([
            'ID_Barang' => (string) Str::uuid(),
            'ID_Pemasok' => $pemasok1->ID_Pemasok,
            'Jenis_Barang' => 'Bawahan',
            'Nama_Barang' => 'Celana Jeans',
            'Warna_Barang' => 'Biru',
            'Ukuran_Barang' => '30',
            'Harga_Beli' => 80000.00,
            'Harga_Jual' => 150000.00,
        ]);

        DataBarang::create([
            'ID_Barang' => (string) Str::uuid(),
            'ID_Pemasok' => $pemasok2->ID_Pemasok,
            'Jenis_Barang' => 'Aksesoris',
            'Nama_Barang' => 'Topi Baseball',
            'Warna_Barang' => 'Hitam',
            'Ukuran_Barang' => 'All Size',
            'Harga_Beli' => 15000.00,
            'Harga_Jual' => 30000.00,
        ]);
    }
}
