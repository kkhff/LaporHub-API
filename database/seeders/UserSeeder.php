<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@laporhub.com',
            'password' => bcrypt('password123'),
        ]);
        $superAdmin->assignRole('super-admin');

        $admin = User::create([
            'name' => 'kevin',
            'email' => 'admin@laporhub.com',
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole('admin');

        $petugas = User::create([
            'name' => 'evan',
            'email' => 'petugas@laporhub.com',
            'password' => bcrypt('password123'),
        ]);
        $petugas->assignRole('petugas');

        $masyarakat = User::create([
            'name' => 'john doe',
            'email' => 'masyarakat@laporhub.com',
            'password' => bcrypt('password123'),
        ]);
        $masyarakat->assignRole('masyarakat');

    }
}
