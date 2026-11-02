<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Role;

/**
 * Setiap pengguna yang mendaftar lewat Breeze otomatis menjadi "Mahasiswa".
 * Listener ini ter-discover otomatis oleh Laravel 11 (type-hint Registered).
 */
class AssignDefaultRole
{
    public function handle(Registered $event): void
    {
        $user = $event->user;

        $roleExists = Role::where('name', 'Mahasiswa')->where('guard_name', 'web')->exists();

        if ($roleExists && $user->roles()->doesntExist()) {
            $user->assignRole('Mahasiswa');
        }
    }
}
