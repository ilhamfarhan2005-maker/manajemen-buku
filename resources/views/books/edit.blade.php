<x-app-layout>
    <x-slot name="pageTitle">Ubah Data Buku: {{ $book->judul }}</x-slot>
    <x-slot name="header">Edit Buku</x-slot>

    <!-- Breadcrumb & Header -->
    <div class="mb-6">
        <nav class="flex items-center gap-1.5 text-xs text-ink-muted mb-2">
            <a href="{{ route('books.index') }}" class="hover:text-brand transition-colors">Buku</a>
            <span class="text-ink-subtle">/</span>
            <a href="{{ route('books.show', $book) }}" class="hover:text-brand transition-colors truncate max-w-xs">{{ $book->judul }}</a>
            <span class="text-ink-subtle">/</span>
            <span class="text-ink font-semibold">Edit</span>
        </nav>
        <h1 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-ink">
            Ubah Data Buku
        </h1>
        <p class="mt-1 text-sm text-ink-muted">
            Perbarui informasi bibliografi untuk buku "{{ $book->judul }}".
        </p>
    </div>

    <!-- Form Card -->
    <x-card class="max-w-4xl p-6 sm:p-8">
        <form method="POST" action="{{ route('books.update', $book) }}">
            @csrf
            @method('PUT')

            @include('books._form', ['book' => $book])

            <!-- Actions Row -->
            <div class="mt-8 pt-6 border-t border-line flex items-center gap-3">
                <x-primary-button>
                    Simpan Perubahan
                </x-primary-button>

                <a
                    href="{{ route('books.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2.5 bg-white hover:bg-paper text-ink text-sm font-medium border border-line rounded-[6px] transition-colors"
                >
                    Batal
                </a>
            </div>
        </form>
    </x-card>
</x-app-layout>
