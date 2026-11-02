<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Lapisan 1 (route)  : middleware 'auth' + 'permission:...' di routes/web.php
     * Lapisan 2 (policy) : Gate::authorize() di setiap method di bawah (defense in depth)
     */
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Book::class);

        $books = Book::query()
            ->when($request->query('q'), function ($query, $keyword) {
                $query->where(function ($w) use ($keyword) {
                    $w->where('judul', 'like', "%{$keyword}%")
                      ->orWhere('penulis', 'like', "%{$keyword}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('books.index', compact('books'));
    }

    public function create(): View
    {
        Gate::authorize('create', Book::class);

        return view('books.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Book::class);

        $data = $request->validate($this->rules());

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $book): View
    {
        Gate::authorize('view', $book);

        return view('books.show', compact('book'));
    }

    public function edit(Book $book): View
    {
        Gate::authorize('update', $book);

        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        Gate::authorize('update', $book);

        $book->update($request->validate($this->rules($book)));

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        Gate::authorize('delete', $book);

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }

    private function rules(?Book $book = null): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'penulis' => ['required', 'string', 'max:255'],
            'penerbit' => ['nullable', 'string', 'max:255'],
            'tahun_terbit' => ['nullable', 'integer', 'min:1000', 'max:' . (date('Y') + 1)],
            'isbn' => ['nullable', 'string', 'max:20', Rule::unique('books', 'isbn')->ignore($book?->id)],
            'deskripsi' => ['nullable', 'string'],
        ];
    }
}
