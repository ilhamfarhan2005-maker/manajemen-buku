<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Akun pengujian untuk tiga role. Password semua akun: "password".
     */
    public function run(): void
    {
        $accounts = [
            ['Administrator', 'admin@example.com', 'Admin'],
            ['Dosen Pengampu', 'dosen@example.com', 'Dosen'],
            ['Mahasiswa Uji', 'mahasiswa@example.com', 'Mahasiswa'],
        ];

        foreach ($accounts as [$name, $email, $role]) {
            $user = User::firstOrNew(['email' => $email]);
            $user->forceFill([
                'name' => $name,
                'password' => 'password', // di-hash otomatis oleh cast 'hashed' pada model User
                'email_verified_at' => now(),
            ])->save();

            $user->syncRoles($role); // assign role
        }
    }
}
