<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'export laporan', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'hapus laporan', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'edit role', 'guard_name' => 'api']);

        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'api']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);
        Role::firstOrCreate(['name' => 'petugas', 'guard_name' => 'api']);
        Role::firstOrCreate(['name' => 'masyarakat', 'guard_name' => 'api']);

        $admin->givePermissionTo([
            'export laporan',
            'hapus laporan',
            'edit role',
        ]);

        $superAdmin->syncPermissions(Permission::all());
    }
}
