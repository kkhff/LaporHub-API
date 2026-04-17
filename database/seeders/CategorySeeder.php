<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Category::insert([
        ['name' => 'Infrastruktur', 'slug' => 'infrastruktur'],
        ['name' => 'Kebersihan', 'slug' => 'kebersihan'],
        ['name' => 'Keamanan', 'slug' => 'keamanan'],
        ['name' => 'Kesehatan', 'slug' => 'kesehatan'],
        ]);
    }
}
