<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Nama_Pelanggan' => 'Siti Aminah', 'Alamat_Pelanggan' => 'Jl. Merdeka No. 10, Jakarta', 'NoTelp_Pelanggan' => '081234567890'],
            ['Nama_Pelanggan' => 'Budi Santoso', 'Alamat_Pelanggan' => 'Jl. Mawar No. 5, Bandung', 'NoTelp_Pelanggan' => '081298765432'],
            ['Nama_Pelanggan' => 'Lani Wijaya', 'Alamat_Pelanggan' => 'Komp. Hijau Permai B/12, Surabaya', 'NoTelp_Pelanggan' => '085611223344'],
            ['Nama_Pelanggan' => 'Andi Pratama', 'Alamat_Pelanggan' => 'Griya Asri Blok C-4, Semarang', 'NoTelp_Pelanggan' => '087755667788'],
            ['Nama_Pelanggan' => 'Dewi Sartika', 'Alamat_Pelanggan' => 'Jl. Melati No. 8, Yogyakarta', 'NoTelp_Pelanggan' => '081344556677'],
        ];

        foreach ($data as $item) {
            Pelanggan::create(array_merge($item, [
                'ID_Pelanggan' => Pelanggan::generateId('PLG')
            ]));
        }
    }
}
