<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin; // Make sure to import the Admin model
use Illuminate\Support\Str; // Import Str for UUID

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'ID_Admin' => (string) Str::uuid(), // Generate a UUID for ID_Admin
            'Nama_Admin' => 'Super Admin',
            'Alamat_Admin' => 'Jl. Admin Raya No. 123',
            'NoTelp_Admin' => '081234567890',
        ]);
    }
}
