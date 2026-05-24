<?php

namespace Database\Seeders;

use App\Models\Penjualan;
use App\Models\StokBarang;
use App\Models\User;
use App\Models\DataBarang;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('username', 'admin')->first();

        $data = [
            ['ID_Barang' => 'BRG-0001', 'ID_Pelanggan' => 'PLG-0001', 'Qty' => 2, 'DaysAgo' => 10],
            ['ID_Barang' => 'BRG-0001', 'ID_Pelanggan' => 'PLG-0005', 'Qty' => 1, 'DaysAgo' => 8],
            ['ID_Barang' => 'BRG-0003', 'ID_Pelanggan' => 'PLG-0002', 'Qty' => 3, 'DaysAgo' => 7],
        ];

        foreach ($data as $i => $item) {
            $id = 'PJ-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT);
            $tgl = Carbon::now()->subDays($item['DaysAgo']);
            $barang = DataBarang::find($item['ID_Barang']);
            
            $totalHargaBarang = $barang->Harga_Jual * $item['Qty'];
            $ongkir = 0;
            $totalHarga = $totalHargaBarang + $ongkir;

            Penjualan::create([
                'ID_Penjualan' => $id,
                'ID_Barang' => $item['ID_Barang'],
                'ID_Pelanggan' => $item['ID_Pelanggan'],
                'Tanggal_Penjualan' => $tgl,
                'Kuantitas' => $item['Qty'],
                'Jenis_Pembayaran' => 'Tunai',
                'Total_Harga_Barang' => $totalHargaBarang,
                'Ongkir' => $ongkir,
                'Total_Harga' => $totalHarga,
                'user_id' => $admin->id
            ]);

            // Update Stock
            $stok = StokBarang::where('ID_Barang', $item['ID_Barang'])->first();
            if ($stok) {
                $stok->Stok_Akhir -= $item['Qty'];
                $stok->save();
            }
        }
    }
}
