<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StokBarang; // Import the StokBarang model
use App\Models\Admin; // Import the Admin model
use App\Models\Pemasok; // Import the Pemasok model
use App\Models\DataBarang; // Import the DataBarang model
use App\Models\Pembelian; // Import Pembelian for stock calculation
use App\Models\Penjualan; // Import Penjualan for stock calculation
use Illuminate\Support\Str; // Import Str for UUID

class StokBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::first();
        $pemasok1 = Pemasok::first();
        $barang1 = DataBarang::first(); // Kaos Polos
        $barang2 = DataBarang::skip(1)->first(); // Celana Jeans

        // Calculate current stock based on Pembelian and Penjualan
        $stokAwalBarang1 = Pembelian::where('ID_Barang', $barang1->ID_Barang)->sum('Kuantitas');
        $stokAwalBarang1 -= Penjualan::where('ID_Barang', $barang1->ID_Barang)->sum('Kuantitas');

        $stokAwalBarang2 = Pembelian::where('ID_Barang', $barang2->ID_Barang)->sum('Kuantitas');
        $stokAwalBarang2 -= Penjualan::where('ID_Barang', $barang2->ID_Barang)->sum('Kuantitas');


        StokBarang::create([
            'ID_Stok' => (string) Str::uuid(),
            'ID_Admin' => $admin->ID_Admin,
            'ID_Pemasok' => $pemasok1->ID_Pemasok,
            'ID_Barang' => $barang1->ID_Barang,
            'Stok_Awal' => $stokAwalBarang1,
            'Stok_Akhir' => $stokAwalBarang1, // Assuming no further transactions after seeding
            'Keterangan' => 'Initial stock after purchases and sales',
        ]);

        StokBarang::create([
            'ID_Stok' => (string) Str::uuid(),
            'ID_Admin' => $admin->ID_Admin,
            'ID_Pemasok' => $pemasok1->ID_Pemasok,
            'ID_Barang' => $barang2->ID_Barang,
            'Stok_Awal' => $stokAwalBarang2,
            'Stok_Akhir' => $stokAwalBarang2, // Assuming no further transactions after seeding
            'Keterangan' => 'Initial stock after purchases and sales',
        ]);
    }
}
