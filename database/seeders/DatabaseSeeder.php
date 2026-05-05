<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            PelangganSeeder::class,
            PemasokSeeder::class,
            DataBarangSeeder::class,
            PembelianSeeder::class,
            PenjualanSeeder::class,
            StokBarangSeeder::class,
        ]);
    }
}
