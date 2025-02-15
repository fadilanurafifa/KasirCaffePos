<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@kasir.com',
            'password' => Hash::make('password'),
        ]);

        // User::create([
        //     'username' => 'kasir01',
        //     'password' => Hash::make('password123'),
        //     'role' => 'kasir',
        //     'nama_lengkap' => 'Kasir Toko',
        //     'email' => 'kasir@example.com'
        // ]);

        // User::create([
        //     'username' => 'manajer01',
        //     'password' => Hash::make('password123'),
        //     'role' => 'manajer',
        //     'nama_lengkap' => 'Manajer Bisnis',
        //     'email' => 'manajer@example.com'
        // ]);
    }
}
