<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['ID_Pelanggan' => 'PLG-0001', 'Nama_Pelanggan' => 'Ahmad Subardjo', 'Alamat_Pelanggan' => 'Jl. Merdeka No. 10, Jakarta', 'NoTelp_Pelanggan' => '081234567001'],
            ['ID_Pelanggan' => 'PLG-0002', 'Nama_Pelanggan' => 'Lani Wijaya', 'Alamat_Pelanggan' => 'Perum Indah Blok B2, Bandung', 'NoTelp_Pelanggan' => '081234567002'],
            ['ID_Pelanggan' => 'PLG-0003', 'Nama_Pelanggan' => 'Robertus Kristi', 'Alamat_Pelanggan' => 'Jl. Sudirman Gg. 5, Surabaya', 'NoTelp_Pelanggan' => '081234567003'],
            ['ID_Pelanggan' => 'PLG-0004', 'Nama_Pelanggan' => 'Siska Amelia', 'Alamat_Pelanggan' => 'Apartemen Gading Lt. 12, Jakarta', 'NoTelp_Pelanggan' => '081234567004'],
            ['ID_Pelanggan' => 'PLG-0005', 'Nama_Pelanggan' => 'Taufik Hidayat', 'Alamat_Pelanggan' => 'Jl. Raya Bogor No. 45, Depok', 'NoTelp_Pelanggan' => '081234567005'],
            ['ID_Pelanggan' => 'PLG-0006', 'Nama_Pelanggan' => 'Maria Ulfa', 'Alamat_Pelanggan' => 'Jl. Gajah Mada No. 8, Semarang', 'NoTelp_Pelanggan' => '081234567006'],
            ['ID_Pelanggan' => 'PLG-0007', 'Nama_Pelanggan' => 'Kevin Sanjaya', 'Alamat_Pelanggan' => 'Komp. Atlet No. 1, Jakarta', 'NoTelp_Pelanggan' => '081234567007'],
            ['ID_Pelanggan' => 'PLG-0008', 'Nama_Pelanggan' => 'Indah Permata', 'Alamat_Pelanggan' => 'Jl. Melati No. 22, Yogyakarta', 'NoTelp_Pelanggan' => '081234567008'],
            ['ID_Pelanggan' => 'PLG-0009', 'Nama_Pelanggan' => 'Bambang Pamungkas', 'Alamat_Pelanggan' => 'Jl. Bambu Apus, Jakarta Timur', 'NoTelp_Pelanggan' => '081234567009'],
            ['ID_Pelanggan' => 'PLG-0010', 'Nama_Pelanggan' => 'Santi Kurnia', 'Alamat_Pelanggan' => 'Jl. Pahlawan No. 3, Malang', 'NoTelp_Pelanggan' => '081234567010'],
            ['ID_Pelanggan' => 'PLG-0011', 'Nama_Pelanggan' => 'Dedi Mulyadi', 'Alamat_Pelanggan' => 'Purwakarta Istimewa No. 1', 'NoTelp_Pelanggan' => '081234567011'],
            ['ID_Pelanggan' => 'PLG-0012', 'Nama_Pelanggan' => 'Ani Yudhoyono', 'Alamat_Pelanggan' => 'Cikeas Permai, Bogor', 'NoTelp_Pelanggan' => '081234567012'],
            ['ID_Pelanggan' => 'PLG-0013', 'Nama_Pelanggan' => 'Joko Widodo', 'Alamat_Pelanggan' => 'Istana Negara, Jakarta', 'NoTelp_Pelanggan' => '081234567013'],
            ['ID_Pelanggan' => 'PLG-0014', 'Nama_Pelanggan' => 'Prabowo Subianto', 'Alamat_Pelanggan' => 'Hambalang, Bogor', 'NoTelp_Pelanggan' => '081234567014'],
            ['ID_Pelanggan' => 'PLG-0015', 'Nama_Pelanggan' => 'Ganjar Pranowo', 'Alamat_Pelanggan' => 'Semarang Tengah No. 5', 'NoTelp_Pelanggan' => '081234567015'],
        ];

        foreach ($data as $item) {
            Pelanggan::updateOrCreate(['ID_Pelanggan' => $item['ID_Pelanggan']], $item);
        }
    }
}
