<?php

namespace Database\Seeders;

use App\Models\Pembelian;
use App\Models\DataBarang;
use App\Models\Pemasok;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PembelianSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $barangs = DataBarang::all();
        
        foreach ($barangs as $i => $barang) {
            $qty = 20;
            $total_harga_barang = $barang->Harga_Beli * $qty;
            $ongkir = 15000;

            Pembelian::create([
                'ID_Pembelian' => Pembelian::generateId('PB'),
                'ID_Pemasok' => $barang->ID_Pemasok,
                'ID_Barang' => $barang->ID_Barang,
                'user_id' => $admin->id,
                'Tgl_Pembelian' => Carbon::now()->subDays(rand(1, 30)),
                'Kuantitas' => $qty,
                'jenis_pembayaran' => 'Transfer',
                'Total_Harga_Barang' => $total_harga_barang,
                'Ongkir' => $ongkir,
                'Total_Harga' => $total_harga_barang + $ongkir,
            ]);
        }
    }
}
