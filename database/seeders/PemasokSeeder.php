<?php

namespace Database\Seeders;

use App\Models\Pemasok;
use Illuminate\Database\Seeder;

class PemasokSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Nama_Pemasok' => 'PT. Tekstil Jaya', 'Alamat_Pemasok' => 'Kawasan Industri Jababeka, Bekasi', 'NoTelp_Pemasok' => '0218901234'],
            ['Nama_Pemasok' => 'CV. Busana Muslimah', 'Alamat_Pemasok' => 'Pusat Grosir Tanah Abang, Jakarta', 'NoTelp_Pemasok' => '0213190887'],
            ['Nama_Pemasok' => 'Distributor Hijab Syari', 'Alamat_Pemasok' => 'Jl. Soreang No. 45, Bandung', 'NoTelp_Pemasok' => '0226677889'],
            ['Nama_Pemasok' => 'Konveksi Berkah', 'Alamat_Pemasok' => 'Jl. Solo-Semarang KM 12', 'NoTelp_Pemasok' => '0271554433'],
            ['Nama_Pemasok' => 'Supplier Kain Premium', 'Alamat_Pemasok' => 'Ruko Mangga Dua, Jakarta', 'NoTelp_Pemasok' => '0216123456'],
        ];

        foreach ($data as $item) {
            Pemasok::create(array_merge($item, [
                'ID_Pemasok' => Pemasok::generateId('PMS')
            ]));
        }
    }
}
