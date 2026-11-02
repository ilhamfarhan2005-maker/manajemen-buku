<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan cache permission Spatie agar data baru langsung terbaca
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // 1) Permission (kemampuan atomik)
        $permissions = [
            'view books',
            'create books',
            'edit books',
            'delete books',
            'manage roles',
        ];

        foreach ($permissions as $name) {
            Permission::findOrCreate($name, 'web');
        }

        // 2) Role + 3) hubungkan role dengan permission sesuai matriks tugas
        Role::findOrCreate('Admin', 'web')->syncPermissions($permissions);

        Role::findOrCreate('Dosen', 'web')->syncPermissions([
            'view books', 'create books', 'edit books',
        ]);

        Role::findOrCreate('Mahasiswa', 'web')->syncPermissions([
            'view books',
        ]);
    }
}
