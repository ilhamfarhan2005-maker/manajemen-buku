<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Semua route di dalam group ini WAJIB login (middleware 'auth').
// Tamu yang membuka URL-nya akan di-redirect ke /login.
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ---- CRUD Buku: tiap route dijaga permission Spatie (403 jika tidak punya) ----
    // PENTING: /books/create harus didaftarkan SEBELUM /books/{book}
    Route::get('/books', [BookController::class, 'index'])
        ->middleware('permission:view books')->name('books.index');

    Route::get('/books/create', [BookController::class, 'create'])
        ->middleware('permission:create books')->name('books.create');
    Route::post('/books', [BookController::class, 'store'])
        ->middleware('permission:create books')->name('books.store');

    Route::get('/books/{book}', [BookController::class, 'show'])
        ->middleware('permission:view books')->name('books.show');

    Route::get('/books/{book}/edit', [BookController::class, 'edit'])
        ->middleware('permission:edit books')->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])
        ->middleware('permission:edit books')->name('books.update');

    Route::delete('/books/{book}', [BookController::class, 'destroy'])
        ->middleware('permission:delete books')->name('books.destroy');

    // ---- Kelola role pengguna: hanya Admin ----
    Route::middleware('permission:manage roles')
        ->prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserRoleController::class, 'index'])->name('index');
            Route::patch('/{user}/role', [UserRoleController::class, 'update'])->name('role.update');
        });
});

require __DIR__.'/auth.php';
