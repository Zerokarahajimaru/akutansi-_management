<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pembelian; // Import the Pembelian model
use App\Models\Pemasok; // Import the Pemasok model
use App\Models\DataBarang; // Import the DataBarang model
use Illuminate\Support\Str; // Import Str for UUID
use Carbon\Carbon; // Import Carbon for dates

class PembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pemasok1 = Pemasok::first();
        $barang1 = DataBarang::first(); // Kaos Polos
        $barang2 = DataBarang::skip(1)->first(); // Celana Jeans

        Pembelian::create([
            'ID_Pembelian' => (string) Str::uuid(),
            'ID_Pemasok' => $pemasok1->ID_Pemasok,
            'ID_Barang' => $barang1->ID_Barang,
            'Tgl_Pembelian' => Carbon::now()->subDays(10),
            'Kuantitas' => 100,
            'Jenis_Pembayaran' => 'Transfer Bank',
            'Total_Harga' => 25000 * 100, // Harga Beli * Kuantitas
        ]);

        Pembelian::create([
            'ID_Pembelian' => (string) Str::uuid(),
            'ID_Pemasok' => $pemasok1->ID_Pemasok,
            'ID_Barang' => $barang2->ID_Barang,
            'Tgl_Pembelian' => Carbon::now()->subDays(5),
            'Kuantitas' => 50,
            'Jenis_Pembayaran' => 'Cash',
            'Total_Harga' => 80000 * 50, // Harga Beli * Kuantitas
        ]);
    }
}
