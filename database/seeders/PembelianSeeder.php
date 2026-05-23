<?php

namespace Database\Seeders;

use App\Models\DataBarang;
use App\Models\Pembelian;
use App\Models\StokBarang;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PembelianSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['ID_Barang' => 'BRG-0001', 'ID_Pemasok' => 'PMS-0007', 'Qty' => 50, 'DaysAgo' => 30],
            ['ID_Barang' => 'BRG-0002', 'ID_Pemasok' => 'PMS-0007', 'Qty' => 40, 'DaysAgo' => 28],
            ['ID_Barang' => 'BRG-0003', 'ID_Pemasok' => 'PMS-0001', 'Qty' => 20, 'DaysAgo' => 25],
            ['ID_Barang' => 'BRG-0004', 'ID_Pemasok' => 'PMS-0002', 'Qty' => 15, 'DaysAgo' => 20],
            ['ID_Barang' => 'BRG-0005', 'ID_Pemasok' => 'PMS-0003', 'Qty' => 30, 'DaysAgo' => 15],
            ['ID_Barang' => 'BRG-0006', 'ID_Pemasok' => 'PMS-0001', 'Qty' => 10, 'DaysAgo' => 10],
            ['ID_Barang' => 'BRG-0007', 'ID_Pemasok' => 'PMS-0005', 'Qty' => 25, 'DaysAgo' => 5],
            ['ID_Barang' => 'BRG-0008', 'ID_Pemasok' => 'PMS-0006', 'Qty' => 5, 'DaysAgo' => 2],
        ];

        foreach ($data as $i => $item) {
            $id = 'PB-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT);
            $tgl = Carbon::now()->subDays($item['DaysAgo']);
            $barang = DataBarang::find($item['ID_Barang']);
            
            $totalHargaBarang = $barang->Harga_Beli * $item['Qty'];
            $ongkir = 15000;
            $totalHarga = $totalHargaBarang + $ongkir;

            Pembelian::create([
                'ID_Pembelian' => $id,
                'ID_Barang' => $item['ID_Barang'],
                'ID_Pemasok' => $item['ID_Pemasok'],
                'Tgl_Pembelian' => $tgl,
                'Kuantitas' => $item['Qty'],
                'Jenis_Pembayaran' => 'Transfer',
                'Total_Harga_Barang' => $totalHargaBarang,
                'Ongkir' => $ongkir,
                'Total_Harga' => $totalHarga,
                'ID_Admin' => 'ADM-001'
            ]);

            // Update Stock
            StokBarang::updateOrCreate(
                ['ID_Barang' => $item['ID_Barang']],
                [
                    'ID_Stok' => 'STK-' . $item['ID_Barang'],
                    'ID_Pemasok' => $item['ID_Pemasok'],
                    'Stok_Awal' => 0,
                    'Stok_Akhir' => $item['Qty'],
                    'ID_Admin' => 'ADM-001'
                ]
            );
        }
    }
}
