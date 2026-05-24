<?php

namespace Database\Seeders;

use App\Models\Penjualan;
use App\Models\DataBarang;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $barangs = DataBarang::all();
        $pelanggans = Pelanggan::all();

        foreach ($barangs as $i => $barang) {
            $qty = rand(1, 5);
            $total_harga_barang = $barang->Harga_Jual * $qty;
            $ongkir = 0;

            Penjualan::create([
                'ID_Penjualan' => Penjualan::generateId('PJ'),
                'user_id' => $admin->id,
                'ID_Barang' => $barang->ID_Barang,
                'ID_Pelanggan' => $pelanggans->random()->ID_Pelanggan,
                'Tanggal_Penjualan' => Carbon::now()->subDays(rand(1, 10)),
                'Kuantitas' => $qty,
                'jenis_pembayaran' => 'Tunai',
                'Total_Harga_Barang' => $total_harga_barang,
                'Ongkir' => $ongkir,
                'Total_Harga' => $total_harga_barang + $ongkir,
            ]);
        }
    }
}
