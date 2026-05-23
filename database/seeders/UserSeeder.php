<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admins first
        $admins = [
            ['ID_Admin' => 'ADM-001', 'Nama_Admin' => 'Ezara Aristo', 'Alamat_Admin' => 'Kantor Xyra.id', 'NoTelp_Admin' => '081234567890'],
            ['ID_Admin' => 'ADM-002', 'Nama_Admin' => 'Super Admin', 'Alamat_Admin' => 'Kantor Xyra.id', 'NoTelp_Admin' => '081111111111'],
            ['ID_Admin' => 'ADM-003', 'Nama_Admin' => 'Budi Santoso', 'Alamat_Admin' => 'Gudang Xyra.id', 'NoTelp_Admin' => '082222222222'],
        ];

        foreach ($admins as $admin) {
            Admin::updateOrCreate(['ID_Admin' => $admin['ID_Admin']], $admin);
        }

        // 2. Create Users (Linked to Admins for 'admin' role)
        
        // Main Admin (You)
        User::create([
            'username' => 'admin',
            'name' => 'Ezara Aristo',
            'password' => 'admin', // Will be hashed by model cast
            'role' => 'admin',
            'ID_Admin' => 'ADM-001'
        ]);

        // Second Admin
        User::create([
            'username' => 'superadmin',
            'name' => 'Super Admin',
            'password' => 'password',
            'role' => 'admin',
            'ID_Admin' => 'ADM-002'
        ]);

        // Pegawai (Employees) - High volume realistic data
        $employees = [
            ['name' => 'Siti Aminah', 'username' => 'siti'],
            ['name' => 'Andi Wijaya', 'username' => 'andi'],
            ['name' => 'Rina Pratama', 'username' => 'rina'],
            ['name' => 'Fajar Hidayat', 'username' => 'fajar'],
            ['name' => 'Dewi Lestari', 'username' => 'dewi'],
            ['name' => 'Bambang Kusuma', 'username' => 'bambang'],
            ['name' => 'Maya Saputri', 'username' => 'maya'],
            ['name' => 'Rizky Ramadhan', 'username' => 'rizky'],
            ['name' => 'Eka Wahyuni', 'username' => 'eka'],
            ['name' => 'Hendra Putra', 'username' => 'hendra'],
        ];

        foreach ($employees as $emp) {
            User::create([
                'name' => $emp['name'],
                'username' => $emp['username'],
                'password' => 'pegawai123',
                'role' => 'pegawai',
            ]);
        }
    }
}
