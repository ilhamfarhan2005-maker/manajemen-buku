<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pengujian otomatis sesuai "F. Pengujian Minimum" pada lembar tugas.
 * Jalankan: php artisan test --filter=BookAccessTest
 */
class BookAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    private function userWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    private function validBookData(array $override = []): array
    {
        return array_merge([
            'judul' => 'Buku Uji',
            'penulis' => 'Penulis Uji',
            'penerbit' => 'Penerbit Uji',
            'tahun_terbit' => 2024,
            'isbn' => '9781234567890',
            'deskripsi' => 'Deskripsi uji.',
        ], $override);
    }

    // ---------- F1: belum login -> redirect ke login ----------
    public function test_guest_is_redirected_to_login_on_protected_pages(): void
    {
        $book = Book::factory()->create();

        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/books')->assertRedirect('/login');
        $this->get('/books/create')->assertRedirect('/login');
        $this->get("/books/{$book->id}/edit")->assertRedirect('/login');
        $this->delete("/books/{$book->id}")->assertRedirect('/login');
        $this->get('/users')->assertRedirect('/login');
    }

    // ---------- F2: password salah gagal, valid berhasil ----------
    public function test_login_with_wrong_password_fails(): void
    {
        $user = $this->userWithRole('Mahasiswa');

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password-salah',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_login_with_valid_credentials_succeeds(): void
    {
        $user = $this->userWithRole('Dosen');

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password', // password default UserFactory
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    // ---------- F3: hapus buku ----------
    public function test_admin_can_delete_book(): void
    {
        $book = Book::factory()->create();

        $this->actingAs($this->userWithRole('Admin'))
            ->delete("/books/{$book->id}")
            ->assertRedirect(route('books.index'));

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_dosen_and_mahasiswa_cannot_delete_book(): void
    {
        $book = Book::factory()->create();

        foreach (['Dosen', 'Mahasiswa'] as $role) {
            $this->actingAs($this->userWithRole($role))
                ->delete("/books/{$book->id}")
                ->assertForbidden();
        }

        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }

    // ---------- F4: dosen tambah/ubah; mahasiswa ditolak ----------
    public function test_dosen_can_create_and_update_book(): void
    {
        $dosen = $this->userWithRole('Dosen');

        $this->actingAs($dosen)->get('/books/create')->assertOk();

        $this->actingAs($dosen)->post('/books', $this->validBookData())
            ->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', ['judul' => 'Buku Uji']);

        $book = Book::where('judul', 'Buku Uji')->firstOrFail();

        $this->actingAs($dosen)->get("/books/{$book->id}/edit")->assertOk();
        $this->actingAs($dosen)
            ->put("/books/{$book->id}", $this->validBookData(['judul' => 'Judul Baru']))
            ->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', ['id' => $book->id, 'judul' => 'Judul Baru']);
    }

    // ---------- F5: mahasiswa lihat saja, termasuk lewat URL langsung ----------
    public function test_mahasiswa_can_view_books_but_cannot_create_update_or_delete(): void
    {
        $mahasiswa = $this->userWithRole('Mahasiswa');
        $book = Book::factory()->create();

        $this->actingAs($mahasiswa)->get('/books')->assertOk();
        $this->actingAs($mahasiswa)->get("/books/{$book->id}")->assertOk();

        // akses URL langsung ke halaman form -> 403
        $this->actingAs($mahasiswa)->get('/books/create')->assertForbidden();
        $this->actingAs($mahasiswa)->get("/books/{$book->id}/edit")->assertForbidden();

        // kirim request langsung (tanpa tombol UI) -> 403 dan data tidak berubah
        $this->actingAs($mahasiswa)->post('/books', $this->validBookData())->assertForbidden();
        $this->actingAs($mahasiswa)
            ->put("/books/{$book->id}", $this->validBookData(['judul' => 'Diretas']))
            ->assertForbidden();
        $this->actingAs($mahasiswa)->delete("/books/{$book->id}")->assertForbidden();

        $this->assertDatabaseMissing('books', ['judul' => 'Buku Uji']);
        $this->assertDatabaseMissing('books', ['judul' => 'Diretas']);
        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }

    // ---------- F6: logout mengakhiri session ----------
    public function test_logout_ends_session_and_blocks_protected_pages(): void
    {
        $user = $this->userWithRole('Admin');

        $this->actingAs($user)->post('/logout')->assertRedirect('/');
        $this->assertGuest();

        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/books')->assertRedirect('/login');
    }

    // ---------- Kelola role: hanya Admin ----------
    public function test_only_admin_can_manage_roles(): void
    {
        $target = $this->userWithRole('Mahasiswa');

        $this->actingAs($this->userWithRole('Dosen'))->get('/users')->assertForbidden();
        $this->actingAs($this->userWithRole('Mahasiswa'))->get('/users')->assertForbidden();
        $this->actingAs($this->userWithRole('Dosen'))
            ->patch("/users/{$target->id}/role", ['role' => 'Admin'])
            ->assertForbidden();
        $this->assertTrue($target->fresh()->hasRole('Mahasiswa'));

        $admin = $this->userWithRole('Admin');
        $this->actingAs($admin)->get('/users')->assertOk();
        $this->actingAs($admin)
            ->patch("/users/{$target->id}/role", ['role' => 'Dosen'])
            ->assertSessionHas('success');
        $this->assertTrue($target->fresh()->hasRole('Dosen'));
        $this->assertFalse($target->fresh()->hasRole('Mahasiswa'));
    }

    public function test_admin_cannot_change_own_role(): void
    {
        $admin = $this->userWithRole('Admin');

        $this->actingAs($admin)
            ->patch("/users/{$admin->id}/role", ['role' => 'Mahasiswa'])
            ->assertSessionHas('error');

        $this->assertTrue($admin->fresh()->hasRole('Admin'));
    }

    // ---------- Registrasi: default role Mahasiswa ----------
    public function test_new_registered_user_gets_mahasiswa_role(): void
    {
        $this->post('/register', [
            'name' => 'Pengguna Baru',
            'email' => 'baru@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('dashboard', absolute: false));

        $this->assertTrue(User::where('email', 'baru@example.com')->firstOrFail()->hasRole('Mahasiswa'));
    }
}
