<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pelanggan; // Import the Pelanggan model
use Illuminate\Support\Str; // Import Str for UUID

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelanggan::create([
            'ID_Pelanggan' => (string) Str::uuid(),
            'Nama_Pelanggan' => 'Budi Santoso',
            'Alamat_Pelanggan' => 'Jl. Merdeka No. 10',
            'NoTelp_Pelanggan' => '081212345678',
        ]);

        Pelanggan::create([
            'ID_Pelanggan' => (string) Str::uuid(),
            'Nama_Pelanggan' => 'Siti Aminah',
            'Alamat_Pelanggan' => 'Jl. Diponegoro No. 25',
            'NoTelp_Pelanggan' => '081387654321',
        ]);
    }
}
