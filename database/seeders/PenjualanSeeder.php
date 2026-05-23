<?php

namespace Database\Seeders;

use App\Models\DataBarang;
use App\Models\Penjualan;
use App\Models\StokBarang;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['ID_Barang' => 'BRG-0001', 'ID_Pelanggan' => 'PLG-0001', 'Qty' => 2, 'DaysAgo' => 10],
            ['ID_Barang' => 'BRG-0001', 'ID_Pelanggan' => 'PLG-0005', 'Qty' => 1, 'DaysAgo' => 8],
            ['ID_Barang' => 'BRG-0003', 'ID_Pelanggan' => 'PLG-0002', 'Qty' => 3, 'DaysAgo' => 7],
            ['ID_Barang' => 'BRG-0005', 'ID_Pelanggan' => 'PLG-0003', 'Qty' => 1, 'DaysAgo' => 5],
            ['ID_Barang' => 'BRG-0006', 'ID_Pelanggan' => 'PLG-0010', 'Qty' => 2, 'DaysAgo' => 3],
            ['ID_Barang' => 'BRG-0002', 'ID_Pelanggan' => 'PLG-0008', 'Qty' => 5, 'DaysAgo' => 1],
            ['ID_Barang' => 'BRG-0008', 'ID_Pelanggan' => 'PLG-0013', 'Qty' => 1, 'DaysAgo' => 0],
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
                'ID_Admin' => 'ADM-001'
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
