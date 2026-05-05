<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pemasok; // Import the Pemasok model
use Illuminate\Support\Str; // Import Str for UUID

class PemasokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pemasok::create([
            'ID_Pemasok' => (string) Str::uuid(),
            'Nama_Pemasok' => 'PT. Sandang Jaya',
            'Alamat_Pemasok' => 'Jl. Industri No. 50',
            'NoTelp_Pemasok' => '021123456',
        ]);

        Pemasok::create([
            'ID_Pemasok' => (string) Str::uuid(),
            'Nama_Pemasok' => 'CV. Textile Makmur',
            'Alamat_Pemasok' => 'Jl. Pahlawan No. 100',
            'NoTelp_Pemasok' => '022987654',
        ]);
    }
}
