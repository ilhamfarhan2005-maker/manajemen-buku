<x-app-layout>
    <x-slot name="pageTitle">{{ $book->judul }} - Detail Buku</x-slot>
    <x-slot name="header">Detail Buku</x-slot>

    @php
        $coverPalettes = [
            ['bg' => 'bg-[#1C4E4F]', 'spine' => 'border-l-[#123637]', 'text' => 'text-white'],
            ['bg' => 'bg-[#824D28]', 'spine' => 'border-l-[#5E371C]', 'text' => 'text-white'],
            ['bg' => 'bg-[#2D4560]', 'spine' => 'border-l-[#1D2E42]', 'text' => 'text-white'],
            ['bg' => 'bg-[#3B5A3B]', 'spine' => 'border-l-[#253D25]', 'text' => 'text-white'],
            ['bg' => 'bg-[#6B3754]', 'spine' => 'border-l-[#472236]', 'text' => 'text-white'],
        ];
        $palette = $coverPalettes[abs(crc32($book->judul . $book->penulis)) % count($coverPalettes)];
        $initials = mb_strtoupper(mb_substr($book->judul, 0, 2));
    @endphp

    <div x-data="{
        deleteModalOpen: false
    }">
        <!-- Breadcrumb & Header -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <nav class="flex items-center gap-1.5 text-xs text-ink-muted mb-2">
                    <a href="{{ route('books.index') }}" class="hover:text-brand transition-colors">Buku</a>
                    <span class="text-ink-subtle">/</span>
                    <span class="text-ink font-semibold truncate max-w-sm">{{ $book->judul }}</span>
                </nav>
                <h1 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-ink">
                    Informasi Bibliografi
                </h1>
            </div>

            <!-- Action buttons per permission -->
            <div class="flex items-center gap-2.5 shrink-0">
                <a
                    href="{{ route('books.index') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-paper text-ink text-xs font-medium border border-line rounded-[6px] transition-colors"
                >
                    <x-icon name="arrow-left" class="w-3.5 h-3.5" />
                    <span>Kembali</span>
                </a>

                @can('edit books')
                    <a
                        href="{{ route('books.edit', $book) }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-brand-50 hover:bg-brand-100 text-brand text-xs font-medium border border-brand/20 rounded-[6px] transition-colors"
                    >
                        <x-icon name="edit" class="w-3.5 h-3.5" />
                        <span>Edit Buku</span>
                    </a>
                @endcan

                @can('delete books')
                    <button
                        type="button"
                        @click="deleteModalOpen = true"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-status-danger-light hover:bg-status-danger/20 text-status-danger text-xs font-medium border border-status-danger/25 rounded-[6px] transition-colors"
                    >
                        <x-icon name="trash" class="w-3.5 h-3.5" />
                        <span>Hapus</span>
                    </button>
                @endcan
            </div>
        </div>

        <!-- Book Detail Card (Desktop 2 Columns) -->
        <x-card class="p-6 sm:p-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                <!-- Left Column: Large Book Cover Placeholder (4 cols) -->
                <div class="md:col-span-4 flex flex-col items-center">
                    <div class="w-48 sm:w-56 aspect-[3/4] rounded-[8px] {{ $palette['bg'] }} {{ $palette['text'] }} p-6 shadow-md border-l-8 {{ $palette['spine'] }} flex flex-col justify-between relative overflow-hidden select-none">
                        <!-- Book Cover Pattern -->
                        <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(45deg, #fff 0, #fff 1px, transparent 0, transparent 16px);"></div>

                        <div class="relative z-10 flex items-center justify-between">
                            <span class="text-[10px] uppercase font-bold tracking-widest opacity-75">Pustaka</span>
                            <x-icon name="book" class="w-4 h-4 opacity-75" />
                        </div>

                        <div class="relative z-10 my-auto text-center py-4">
                            <div class="w-16 h-16 mx-auto rounded-full bg-white/15 border border-white/25 flex items-center justify-center font-serif text-2xl font-bold mb-3">
                                {{ $initials }}
                            </div>
                            <h2 class="font-serif font-bold text-base line-clamp-3 leading-snug">
                                {{ $book->judul }}
                            </h2>
                            <p class="text-xs opacity-80 mt-1 line-clamp-1 font-sans">
                                {{ $book->penulis }}
                            </p>
                        </div>

                        <div class="relative z-10 text-[10px] opacity-75 text-center pt-2 border-t border-white/15 font-mono">
                            ISBN: {{ $book->isbn ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <span class="inline-flex items-center gap-1.5 text-xs text-ink-muted">
                            <span class="w-2 h-2 rounded-full bg-status-success"></span>
                            Tersedia di Katalog
                        </span>
                    </div>
                </div>

                <!-- Right Column: Metadata Definition List (8 cols) -->
                <div class="md:col-span-8">
                    <div class="border-b border-line pb-4 mb-6">
                        <h2 class="font-serif text-2xl font-bold text-ink leading-tight">
                            {{ $book->judul }}
                        </h2>
                        <p class="text-sm text-ink-muted mt-1">
                            Karya <strong class="text-ink font-semibold">{{ $book->penulis }}</strong>
                        </p>
                    </div>

                    <dl class="grid grid-cols-1 sm:grid-cols-3 gap-y-4 gap-x-6 text-sm">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-muted">Penulis</dt>
                        <dd class="sm:col-span-2 text-ink font-medium">{{ $book->penulis }}</dd>

                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-muted">Penerbit</dt>
                        <dd class="sm:col-span-2 text-ink">{{ $book->penerbit ?? '—' }}</dd>

                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-muted">Tahun Terbit</dt>
                        <dd class="sm:col-span-2 text-ink">{{ $book->tahun_terbit ?? '—' }}</dd>

                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-muted">Nomor ISBN</dt>
                        <dd class="sm:col-span-2 text-ink font-mono font-medium">{{ $book->isbn ?? '—' }}</dd>

                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-muted">Terdaftar Pada</dt>
                        <dd class="sm:col-span-2 text-ink text-xs text-ink-muted">{{ $book->created_at ? $book->created_at->translatedFormat('d F Y, H:i') : '—' }}</dd>

                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-muted pt-2 border-t border-line">Sinopsis / Deskripsi</dt>
                        <dd class="sm:col-span-2 text-ink leading-relaxed pt-2 border-t border-line">
                            @if ($book->deskripsi)
                                <p class="whitespace-pre-line text-ink">{{ $book->deskripsi }}</p>
                            @else
                                <span class="text-ink-muted italic">Tidak ada deskripsi yang dicantumkan untuk buku ini.</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </x-card>

        <!-- Alpine Confirmation Modal for Delete -->
        @can('delete books')
            <div
                x-show="deleteModalOpen"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-ink/50 backdrop-blur-xs"
                style="display: none;"
                @keydown.escape.window="deleteModalOpen = false"
            >
                <div
                    x-show="deleteModalOpen"
                    @click.away="deleteModalOpen = false"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="bg-white rounded-[10px] border border-line shadow-modal max-w-md w-full p-6 text-left"
                >
                    <div class="flex items-center gap-3.5 mb-4">
                        <div class="w-10 h-10 rounded-full bg-status-danger-light text-status-danger flex items-center justify-center shrink-0">
                            <x-icon name="trash" class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-ink">Hapus Buku</h3>
                            <p class="text-xs text-ink-muted">Konfirmasi penghapusan inventaris</p>
                        </div>
                    </div>

                    <p class="text-sm text-ink-muted leading-relaxed">
                        Hapus buku ini? Tindakan tidak bisa dibatalkan.
                    </p>

                    <div class="mt-2 p-3 bg-paper rounded-[6px] border border-line text-xs font-semibold text-ink truncate">
                        {{ $book->judul }}
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3">
                        <button
                            type="button"
                            @click="deleteModalOpen = false"
                            class="px-4 py-2 bg-white hover:bg-paper text-ink text-xs font-medium border border-line rounded-[6px] transition-colors"
                        >
                            Batal
                        </button>

                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="px-4 py-2 bg-status-danger hover:bg-[#9B2F26] text-white text-xs font-medium rounded-[6px] transition-colors shadow-sm"
                            >
                                Hapus Buku
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
    </div>
</x-app-layout>
