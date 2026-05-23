<?php

namespace Database\Seeders;

use App\Models\Pemasok;
use Illuminate\Database\Seeder;

class PemasokSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['ID_Pemasok' => 'PMS-0001', 'Nama_Pemasok' => 'PT. Garmen Indonesia', 'Alamat_Pemasok' => 'Kawasan Industri Jababeka, Bekasi', 'NoTelp_Pemasok' => '021-8901234'],
            ['ID_Pemasok' => 'PMS-0002', 'Nama_Pemasok' => 'CV. Tekstil Jaya', 'Alamat_Pemasok' => 'Jl. Cigondewah No. 56, Bandung', 'NoTelp_Pemasok' => '022-7801122'],
            ['ID_Pemasok' => 'PMS-0003', 'Nama_Pemasok' => 'UD. Sumber Makmur', 'Alamat_Pemasok' => 'Pasar Tanah Abang Blok A, Jakarta', 'NoTelp_Pemasok' => '021-3344556'],
            ['ID_Pemasok' => 'PMS-0004', 'Nama_Pemasok' => 'PT. Benang Mas', 'Alamat_Pemasok' => 'Jl. Solo-Semarang KM 12, Boyolali', 'NoTelp_Pemasok' => '0271-445566'],
            ['ID_Pemasok' => 'PMS-0005', 'Nama_Pemasok' => 'Grosir Pakaian Murah', 'Alamat_Pemasok' => 'Mangga Dua Square, Jakarta Utara', 'NoTelp_Pemasok' => '021-9988776'],
            ['ID_Pemasok' => 'PMS-0006', 'Nama_Pemasok' => 'Distributor Hijab Sabyan', 'Alamat_Pemasok' => 'Kawasan Cipadu, Tangerang', 'NoTelp_Pemasok' => '021-5566778'],
            ['ID_Pemasok' => 'PMS-0007', 'Nama_Pemasok' => 'Sentra Kaos Polos', 'Alamat_Pemasok' => 'Jl. Suci No. 123, Bandung', 'NoTelp_Pemasok' => '022-990011'],
            ['ID_Pemasok' => 'PMS-0008', 'Nama_Pemasok' => 'Butik Import Thailand', 'Alamat_Pemasok' => 'Kelapa Gading, Jakarta Utara', 'NoTelp_Pemasok' => '021-223344'],
            ['ID_Pemasok' => 'PMS-0009', 'Nama_Pemasok' => 'Rumah Batik Solo', 'Alamat_Pemasok' => 'Pasar Klewer Blok B, Solo', 'NoTelp_Pemasok' => '0271-778899'],
            ['ID_Pemasok' => 'PMS-0010', 'Nama_Pemasok' => 'PT. Global Fashion', 'Alamat_Pemasok' => 'Jl. Gatot Subroto, Jakarta', 'NoTelp_Pemasok' => '021-111222'],
        ];

        foreach ($data as $item) {
            Pemasok::updateOrCreate(['ID_Pemasok' => $item['ID_Pemasok']], $item);
        }
    }
}
