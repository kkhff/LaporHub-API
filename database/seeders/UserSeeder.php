<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin LaporHub',
            'email' => 'admin@laporhub.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Petugas Gantenk',
            'email' => 'petugas@laporhub.com',
            'password' => bcrypt('password123'),
            'role' => 'petugas',
        ]);

    }
}
