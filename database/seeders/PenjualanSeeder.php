<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Penjualan; // Import the Penjualan model
use App\Models\Admin; // Import the Admin model
use App\Models\DataBarang; // Import the DataBarang model
use App\Models\Pelanggan; // Import the Pelanggan model
use Illuminate\Support\Str; // Import Str for UUID
use Carbon\Carbon; // Import Carbon for dates

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::first();
        $barang1 = DataBarang::first(); // Kaos Polos
        $barang2 = DataBarang::skip(1)->first(); // Celana Jeans
        $pelanggan1 = Pelanggan::first();

        Penjualan::create([
            'ID_Penjualan' => (string) Str::uuid(),
            'ID_Admin' => $admin->ID_Admin,
            'ID_Barang' => $barang1->ID_Barang,
            'ID_Pelanggan' => $pelanggan1->ID_Pelanggan,
            'Tanggal_Penjualan' => Carbon::now()->subDays(7),
            'Jenis_Pembayaran' => 'Cash',
            'Total_Harga_Barang' => $barang1->Harga_Jual * 2,
            'Ongkir' => 10000.00,
            'Kuantitas' => 2,
        ]);

        Penjualan::create([
            'ID_Penjualan' => (string) Str::uuid(),
            'ID_Admin' => $admin->ID_Admin,
            'ID_Barang' => $barang2->ID_Barang,
            'ID_Pelanggan' => $pelanggan1->ID_Pelanggan,
            'Tanggal_Penjualan' => Carbon::now()->subDays(3),
            'Jenis_Pembayaran' => 'Debit Card',
            'Total_Harga_Barang' => $barang2->Harga_Jual * 1,
            'Ongkir' => 15000.00,
            'Kuantitas' => 1,
        ]);
    }
}
