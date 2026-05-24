<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Primary Admin
        User::create([
            'id' => User::generateId('usr-xyra'),
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'NoTelp_User' => '081122334455',
            'Alamat_User' => 'Kantor Utama Xyra.id, Jakarta',
        ]);

        // Secondary Admin
        User::create([
            'id' => User::generateId('usr-xyra'),
            'name' => 'Owner Xyra',
            'username' => 'owner',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'NoTelp_User' => '089988776655',
            'Alamat_User' => 'Surabaya, Jawa Timur',
        ]);
    }
}
