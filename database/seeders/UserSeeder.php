<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Import the User model
use App\Models\Admin; // Import the Admin model
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first Admin record to link the admin user
        $admin = Admin::first();

        // Create an Admin user
        User::create([
            'username' => 'admin',
            'password' => Hash::make('password'), // You should change this in production
            'role' => 'admin',
            'ID_Admin' => $admin ? $admin->ID_Admin : null, // Link to an existing admin
        ]);

        // Create a Pegawai user
        User::create([
            'username' => 'pegawai',
            'password' => Hash::make('password'), // You should change this in production
            'role' => 'pegawai',
            'ID_Admin' => null, // Pegawai users are not linked to a specific admin record
        ]);
    }
}
