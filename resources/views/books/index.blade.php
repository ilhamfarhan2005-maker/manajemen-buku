<x-app-layout>
    <x-slot name="pageTitle">Koleksi Buku</x-slot>
    <x-slot name="header">Koleksi Buku</x-slot>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-ink">
                Koleksi Buku
            </h1>
            <p class="mt-1 text-sm text-ink-muted">
                Daftar seluruh literatur dan referensi akademik yang tersedia di perpustakaan kampus.
            </p>
        </div>

        @can('create books')
            <div class="shrink-0">
                <a
                    href="{{ route('books.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-brand hover:bg-brand-hover active:bg-brand-active text-white text-sm font-medium rounded-[6px] transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-brand/40"
                >
                    <x-icon name="plus" class="w-4 h-4" />
                    <span>Tambah Buku</span>
                </a>
            </div>
        @endcan
    </div>

    <!-- Search & Filter Bar -->
    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('books.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative w-full sm:flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-ink-subtle">
                    <x-icon name="search" class="w-4 h-4" />
                </div>
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari berdasarkan judul buku atau nama penulis..."
                    class="h-11 pl-10 pr-4 block w-full bg-paper/60 border border-line text-ink placeholder:text-ink-subtle text-sm rounded-[6px] transition-colors focus:bg-white focus:border-brand focus:ring-2 focus:ring-brand/20"
                />
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button
                    type="submit"
                    class="h-11 w-full sm:w-auto px-5 bg-brand hover:bg-brand-hover active:bg-brand-active text-white text-sm font-medium rounded-[6px] transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-brand/40 shrink-0"
                >
                    Cari
                </button>

                @if(request('q'))
                    <a
                        href="{{ route('books.index') }}"
                        class="h-11 px-4 inline-flex items-center justify-center bg-white hover:bg-paper text-ink-muted hover:text-ink text-sm font-medium border border-line rounded-[6px] transition-colors shrink-0"
                        title="Reset pencarian"
                    >
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </x-card>

    <!-- Books Container with Alpine Modal for Delete Confirmation -->
    <div x-data="{
        deleteModalOpen: false,
        deleteAction: '',
        deleteTitle: '',
        confirmDelete(action, title) {
            this.deleteAction = action;
            this.deleteTitle = title;
            this.deleteModalOpen = true;
        }
    }">
        @if ($books->isNotEmpty())
            <!-- Desktop Table View (Hidden on mobile) -->
            <x-card class="hidden md:block">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-line bg-paper/50">
                                <th scope="col" class="py-3 px-4 text-[11px] font-semibold uppercase tracking-wider text-ink-muted w-12 text-center">#</th>
                                <th scope="col" class="py-3 px-4 text-[11px] font-semibold uppercase tracking-wider text-ink-muted">Buku</th>
                                <th scope="col" class="py-3 px-4 text-[11px] font-semibold uppercase tracking-wider text-ink-muted">Penerbit</th>
                                <th scope="col" class="py-3 px-4 text-[11px] font-semibold uppercase tracking-wider text-ink-muted">Tahun</th>
                                <th scope="col" class="py-3 px-4 text-[11px] font-semibold uppercase tracking-wider text-ink-muted">ISBN</th>
                                <th scope="col" class="py-3 px-4 text-[11px] font-semibold uppercase tracking-wider text-ink-muted text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-line text-sm">
                            @foreach ($books as $index => $book)
                                @php
                                    $coverPalettes = [
                                        ['bg' => 'bg-[#1C4E4F]', 'text' => 'text-white'],
                                        ['bg' => 'bg-[#824D28]', 'text' => 'text-white'],
                                        ['bg' => 'bg-[#2D4560]', 'text' => 'text-white'],
                                        ['bg' => 'bg-[#3B5A3B]', 'text' => 'text-white'],
                                        ['bg' => 'bg-[#6B3754]', 'text' => 'text-white'],
                                        ['bg' => 'bg-[#4A5568]', 'text' => 'text-white'],
                                    ];
                                    $palette = $coverPalettes[abs(crc32($book->judul . $book->penulis)) % count($coverPalettes)];
                                    $initials = mb_strtoupper(mb_substr($book->judul, 0, 2));
                                @endphp
                                <tr class="hover:bg-[#FAF9F5] transition-colors">
                                    <td class="py-3.5 px-4 text-xs text-ink-subtle text-center">
                                        {{ $books->firstItem() + $index }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            <!-- Book Cover Thumbnail Placeholder -->
                                            <div class="w-9 h-12 rounded-[4px] {{ $palette['bg'] }} {{ $palette['text'] }} flex items-center justify-center font-serif text-xs font-bold shadow-xs shrink-0 select-none border border-black/10">
                                                {{ $initials }}
                                            </div>
                                            <div class="min-w-0">
                                                <a href="{{ route('books.show', $book) }}" class="font-semibold text-ink hover:text-brand transition-colors block truncate">
                                                    {{ $book->judul }}
                                                </a>
                                                <p class="text-xs text-ink-muted truncate mt-0.5">
                                                    {{ $book->penulis }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 text-xs text-ink-muted">
                                        {{ $book->penerbit ?? '—' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-xs text-ink-muted">
                                        {{ $book->tahun_terbit ?? '—' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-xs text-ink font-mono">
                                        {{ $book->isbn ?? '—' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <div class="inline-flex items-center gap-1">
                                            <!-- Detail Button -->
                                            <a
                                                href="{{ route('books.show', $book) }}"
                                                class="p-2 text-ink-muted hover:text-ink hover:bg-paper rounded-[4px] transition-colors"
                                                title="Lihat Detail Buku"
                                                aria-label="Lihat detail {{ $book->judul }}"
                                            >
                                                <x-icon name="eye" class="w-4 h-4" />
                                            </a>

                                            <!-- Edit Button -->
                                            @can('edit books')
                                                <a
                                                    href="{{ route('books.edit', $book) }}"
                                                    class="p-2 text-ink-muted hover:text-brand hover:bg-brand-50 rounded-[4px] transition-colors"
                                                    title="Ubah Data Buku"
                                                    aria-label="Ubah {{ $book->judul }}"
                                                >
                                                    <x-icon name="edit" class="w-4 h-4" />
                                                </a>
                                            @endcan

                                            <!-- Delete Button -->
                                            @can('delete books')
                                                <button
                                                    type="button"
                                                    @click="confirmDelete('{{ route('books.destroy', $book) }}', '{{ addslashes($book->judul) }}')"
                                                    class="p-2 text-ink-muted hover:text-status-danger hover:bg-status-danger-light rounded-[4px] transition-colors"
                                                    title="Hapus Buku"
                                                    aria-label="Hapus {{ $book->judul }}"
                                                >
                                                    <x-icon name="trash" class="w-4 h-4" />
                                                </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>

            <!-- Mobile Card Stack View (Shown on mobile) -->
            <div class="md:hidden space-y-3">
                @foreach ($books as $book)
                    @php
                        $palette = $coverPalettes[abs(crc32($book->judul . $book->penulis)) % count($coverPalettes)];
                        $initials = mb_strtoupper(mb_substr($book->judul, 0, 2));
                    @endphp
                    <x-card class="p-4">
                        <div class="flex items-start gap-3.5">
                            <div class="w-11 h-15 rounded-[4px] {{ $palette['bg'] }} {{ $palette['text'] }} flex items-center justify-center font-serif text-sm font-bold shadow-xs shrink-0 select-none border border-black/10">
                                {{ $initials }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('books.show', $book) }}" class="font-semibold text-sm text-ink hover:text-brand transition-colors block leading-snug">
                                    {{ $book->judul }}
                                </a>
                                <p class="text-xs text-ink-muted mt-1">{{ $book->penulis }}</p>

                                <div class="mt-2.5 pt-2 border-t border-line flex flex-wrap gap-x-4 gap-y-1 text-[11px] text-ink-muted">
                                    <span>Penerbit: <strong class="text-ink font-medium">{{ $book->penerbit ?? '—' }}</strong></span>
                                    <span>Tahun: <strong class="text-ink font-medium">{{ $book->tahun_terbit ?? '—' }}</strong></span>
                                    <span>ISBN: <strong class="text-ink font-mono">{{ $book->isbn ?? '—' }}</strong></span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 pt-3 border-t border-line flex items-center justify-end gap-2">
                            <a
                                href="{{ route('books.show', $book) }}"
                                class="px-3 py-1.5 text-xs font-medium text-ink bg-paper hover:bg-[#ECEAE4] rounded-[4px] border border-line transition-colors"
                            >
                                Detail
                            </a>

                            @can('edit books')
                                <a
                                    href="{{ route('books.edit', $book) }}"
                                    class="px-3 py-1.5 text-xs font-medium text-brand bg-brand-50 hover:bg-brand-100 rounded-[4px] border border-brand/20 transition-colors"
                                >
                                    Edit
                                </a>
                            @endcan

                            @can('delete books')
                                <button
                                    type="button"
                                    @click="confirmDelete('{{ route('books.destroy', $book) }}', '{{ addslashes($book->judul) }}')"
                                    class="px-3 py-1.5 text-xs font-medium text-status-danger bg-status-danger-light hover:bg-status-danger/20 rounded-[4px] border border-status-danger/25 transition-colors"
                                >
                                    Hapus
                                </button>
                            @endcan
                        </div>
                    </x-card>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $books->links() }}
            </div>
        @else
            <!-- Empty State -->
            <x-card class="p-8">
                <x-empty-state
                    title="Belum ada buku"
                    description="{{ request('q') ? 'Tidak ditemukan buku yang cocok dengan kata kunci pencarian Anda.' : 'Koleksi perpustakaan belum memiliki data buku.' }}"
                >
                    <x-slot name="action">
                        @if (request('q'))
                            <a
                                href="{{ route('books.index') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-white text-ink border border-line text-xs font-medium rounded-[6px] hover:bg-paper transition-colors"
                            >
                                Hapus Filter Pencarian
                            </a>
                        @else
                            @can('create books')
                                <a
                                    href="{{ route('books.create') }}"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-brand text-white text-xs font-medium rounded-[6px] hover:bg-brand-hover transition-colors"
                                >
                                    <x-icon name="plus" class="w-3.5 h-3.5" />
                                    Tambah Buku Baru
                                </a>
                            @endcan
                        @endif
                    </x-slot>
                </x-empty-state>
            </x-card>
        @endif

        <!-- Alpine Confirmation Modal for Delete -->
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
                    <span x-text="deleteTitle"></span>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3">
                    <button
                        type="button"
                        @click="deleteModalOpen = false"
                        class="px-4 py-2 bg-white hover:bg-paper text-ink text-xs font-medium border border-line rounded-[6px] transition-colors"
                    >
                        Batal
                    </button>

                    <form :action="deleteAction" method="POST" class="inline">
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
    </div>
</x-app-layout>
