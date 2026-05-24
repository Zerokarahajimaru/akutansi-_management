<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Main Admin (You)
        User::create([
            'username' => 'admin',
            'name' => 'Ezara Aristo',
            'password' => 'admin',
            'role' => 'admin',
            'NoTelp_User' => '081234567890',
            'Alamat_User' => 'Kantor Pusat Xyra.id, Jakarta',
        ]);

        // Second Admin
        User::create([
            'username' => 'superadmin',
            'name' => 'Super Admin',
            'password' => 'password',
            'role' => 'admin',
            'NoTelp_User' => '081111111111',
            'Alamat_User' => 'Kantor Cabang Xyra.id, Bandung',
        ]);

        // Pegawai (Employees)
        $employees = [
            ['name' => 'Siti Aminah', 'username' => 'siti', 'telp' => '081234567001'],
            ['name' => 'Andi Wijaya', 'username' => 'andi', 'telp' => '081234567002'],
            ['name' => 'Rina Pratama', 'username' => 'rina', 'telp' => '081234567003'],
            ['name' => 'Fajar Hidayat', 'username' => 'fajar', 'telp' => '081234567004'],
            ['name' => 'Dewi Lestari', 'username' => 'dewi', 'telp' => '081234567005'],
        ];

        foreach ($employees as $emp) {
            User::create([
                'name' => $emp['name'],
                'username' => $emp['username'],
                'password' => 'pegawai123',
                'role' => 'pegawai',
                'NoTelp_User' => $emp['telp'],
                'Alamat_User' => 'Gudang Xyra.id, Jakarta Timur',
            ]);
        }
    }
}
