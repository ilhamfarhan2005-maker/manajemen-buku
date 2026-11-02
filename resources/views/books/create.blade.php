<x-app-layout>
    <x-slot name="pageTitle">Tambah Buku Baru</x-slot>
    <x-slot name="header">Tambah Buku</x-slot>

    <!-- Breadcrumb & Header -->
    <div class="mb-6">
        <nav class="flex items-center gap-1.5 text-xs text-ink-muted mb-2">
            <a href="{{ route('books.index') }}" class="hover:text-brand transition-colors">Buku</a>
            <span class="text-ink-subtle">/</span>
            <span class="text-ink font-semibold">Tambah</span>
        </nav>
        <h1 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-ink">
            Tambah Buku Baru
        </h1>
        <p class="mt-1 text-sm text-ink-muted">
            Lengkapi formulir di bawah ini untuk mendaftarkan buku ke dalam katalog perpustakaan.
        </p>
    </div>

    <!-- Form Card -->
    <x-card class="max-w-4xl p-6 sm:p-8">
        <form method="POST" action="{{ route('books.store') }}">
            @csrf

            @include('books._form')

            <!-- Actions Row -->
            <div class="mt-8 pt-6 border-t border-line flex items-center gap-3">
                <x-primary-button>
                    Simpan
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
