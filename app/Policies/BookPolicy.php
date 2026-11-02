<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

/**
 * Policy untuk Book (ter-discover otomatis: App\Models\Book -> App\Policies\BookPolicy).
 * Setiap method mengembalikan true/false; false => HTTP 403.
 * Pemeriksaan permission dilakukan lewat Spatie ($user->can('nama permission')).
 */
class BookPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view books');
    }

    public function view(User $user, Book $book): bool
    {
        return $user->can('view books');
    }

    public function create(User $user): bool
    {
        return $user->can('create books');
    }

    public function update(User $user, Book $book): bool
    {
        return $user->can('edit books');
    }

    public function delete(User $user, Book $book): bool
    {
        return $user->can('delete books');
    }
}
