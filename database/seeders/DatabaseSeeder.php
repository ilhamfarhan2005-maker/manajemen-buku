<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan penting: role/permission dulu, baru user (agar role bisa di-assign)
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            BookSeeder::class,
        ]);
    }
}
