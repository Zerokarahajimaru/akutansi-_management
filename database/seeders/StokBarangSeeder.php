<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StokBarang;
use App\Models\User;
use App\Models\Pemasok;
use App\Models\DataBarang;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Support\Str;

class StokBarangSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('username', 'admin')->first();
        
        // Populate initial stock for all products that don't have it yet
        $barangs = DataBarang::all();

        foreach ($barangs as $barang) {
            // Skip if already has stock (e.g. from PembelianSeeder)
            if (StokBarang::where('ID_Barang', $barang->ID_Barang)->exists()) {
                continue;
            }

            $beli = Pembelian::where('ID_Barang', $barang->ID_Barang)->sum('Kuantitas');
            $jual = Penjualan::where('ID_Barang', $barang->ID_Barang)->sum('Kuantitas');
            $akhir = $beli - $jual;

            StokBarang::create([
                'ID_Stok' => 'STK-' . $barang->ID_Barang,
                'user_id' => $user->id,
                'ID_Pemasok' => $barang->ID_Pemasok,
                'ID_Barang' => $barang->ID_Barang,
                'Stok_Awal' => 0,
                'Stok_Akhir' => $akhir > 0 ? $akhir : 0,
                'Keterangan' => 'Generated during seeding',
            ]);
        }
    }
}
