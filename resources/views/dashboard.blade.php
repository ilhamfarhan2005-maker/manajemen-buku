@php
    $user = auth()->user();
    $hour = (int) now()->format('H');
    if ($hour >= 4 && $hour < 11) {
        $greeting = 'Selamat pagi';
    } elseif ($hour >= 11 && $hour < 15) {
        $greeting = 'Selamat siang';
    } elseif ($hour >= 15 && $hour < 18) {
        $greeting = 'Selamat sore';
    } else {
        $greeting = 'Selamat malam';
    }

    $roleName = $user->getRoleNames()->first() ?? 'Mahasiswa';
    $roleVariant = match(strtolower($roleName)) {
        'admin' => 'admin',
        'dosen' => 'dosen',
        default => 'mahasiswa',
    };

    $permissions = $user->getAllPermissions();
    $latestBooks = \App\Models\Book::latest()->take(5)->get();
@endphp

<x-app-layout>
    <x-slot name="pageTitle">Dashboard</x-slot>
    <x-slot name="header">Dashboard</x-slot>

    <!-- Welcome Hero Banner -->
    <div class="mb-8 p-6 sm:p-8 rounded-[10px] bg-white border border-line shadow-card flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="text-xs font-semibold text-brand uppercase tracking-wider">{{ $greeting }}</span>
                <span class="text-ink-subtle">•</span>
                <x-badge :variant="$roleVariant" size="sm">
                    {{ $roleName }}
                </x-badge>
            </div>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-ink">
                {{ $greeting }}, {{ $user->name }}
            </h1>
            <p class="mt-1.5 text-sm text-ink-muted max-w-2xl leading-relaxed">
                Kelola data buku kampus, pantau pembaruan koleksi, dan gunakan akses sesuai wewenang peran akademik Anda.
            </p>
        </div>

        <!-- Quick Actions based on permissions -->
        <div class="flex flex-wrap items-center gap-3 shrink-0">
            @can('create books')
                <a
                    href="{{ route('books.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-brand hover:bg-brand-hover active:bg-brand-active text-white text-sm font-medium rounded-[6px] transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-brand/40"
                >
                    <x-icon name="plus" class="w-4 h-4" />
                    <span>Tambah Buku</span>
                </a>
            @endcan

            @can('view books')
                <a
                    href="{{ route('books.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-paper active:bg-[#ECEAE4] text-ink text-sm font-medium border border-line rounded-[6px] transition-colors shadow-card focus:outline-none focus:ring-2 focus:ring-ink/20"
                >
                    <x-icon name="book" class="w-4 h-4 text-ink-muted" />
                    <span>Daftar Buku</span>
                </a>
            @endcan
        </div>
    </div>

    <!-- Statistics Row -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        <!-- Total Buku -->
        <x-card class="p-5 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-ink-muted uppercase tracking-wider">Total Koleksi Buku</p>
                <p class="font-serif text-3xl font-bold text-ink mt-2">{{ $totalBooks }}</p>
                <p class="text-[11px] text-ink-subtle mt-1">Judul buku terdaftar dalam sistem</p>
            </div>
            <div class="w-12 h-12 rounded-[8px] bg-brand-50 border border-brand/20 flex items-center justify-center text-brand">
                <x-icon name="books" class="w-6 h-6" />
            </div>
        </x-card>

        <!-- Role Anda -->
        <x-card class="p-5 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-ink-muted uppercase tracking-wider">Peran Akun Anda</p>
                <div class="mt-2.5">
                    <x-badge :variant="$roleVariant" size="lg">
                        {{ $roleName }}
                    </x-badge>
                </div>
                <p class="text-[11px] text-ink-subtle mt-2">Diverifikasi oleh sistem kampus</p>
            </div>
            <div class="w-12 h-12 rounded-[8px] bg-accent-light border border-accent/25 flex items-center justify-center text-accent">
                <x-icon name="shield" class="w-6 h-6" />
            </div>
        </x-card>

        <!-- Jumlah Izin / Hak Akses -->
        <x-card class="p-5 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-ink-muted uppercase tracking-wider">Hak Akses Aktif</p>
                <p class="font-serif text-3xl font-bold text-ink mt-2">{{ $permissions->count() }}</p>
                <p class="text-[11px] text-ink-subtle mt-1">Izin wewenang yang diberikan</p>
            </div>
            <div class="w-12 h-12 rounded-[8px] bg-[#EDEBE4] border border-line flex items-center justify-center text-ink-muted">
                <x-icon name="dashboard" class="w-6 h-6" />
            </div>
        </x-card>
    </div>

    <!-- Two Columns: Latest Books & Permissions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Buku Terbaru (2 cols) -->
        <div class="lg:col-span-2">
            <x-card>
                <div class="p-5 border-b border-line flex items-center justify-between">
                    <div>
                        <h2 class="font-serif text-lg font-bold text-ink">Buku Terbaru</h2>
                        <p class="text-xs text-ink-muted mt-0.5">5 koleksi buku terakhir yang ditambahkan ke sistem</p>
                    </div>
                    @can('view books')
                        <a href="{{ route('books.index') }}" class="text-xs font-semibold text-brand hover:text-brand-hover hover:underline inline-flex items-center gap-1">
                            Lihat semua
                            <x-icon name="arrow-left" class="w-3 h-3 rotate-180" />
                        </a>
                    @endcan
                </div>

                @if ($latestBooks->isNotEmpty())
                    <div class="divide-y divide-line">
                        @foreach ($latestBooks as $buku)
                            @php
                                $colors = ['bg-[#2C5E5B]', 'bg-[#8A5A36]', 'bg-[#3A506B]', 'bg-[#436436]', 'bg-[#704257]'];
                                $bgColor = $colors[crc32($buku->judul . $buku->penulis) % count($colors)];
                                $initial = mb_strtoupper(mb_substr($buku->judul, 0, 2));
                            @endphp
                            <div class="p-4 sm:px-6 flex items-center justify-between hover:bg-[#FAF9F5] transition-colors">
                                <div class="flex items-center gap-3.5 min-w-0">
                                    <div class="w-10 h-13 rounded-[4px] {{ $bgColor }} text-white flex items-center justify-center text-xs font-bold shadow-sm shrink-0">
                                        {{ $initial }}
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('books.show', $buku) }}" class="text-sm font-semibold text-ink hover:text-brand transition-colors truncate block">
                                            {{ $buku->judul }}
                                        </a>
                                        <p class="text-xs text-ink-muted truncate mt-0.5">
                                            {{ $buku->penulis }} • {{ $buku->tahun_terbit ?? 'Tahun tidak diketahui' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 shrink-0 ml-4">
                                    <a
                                        href="{{ route('books.show', $buku) }}"
                                        class="px-2.5 py-1 text-xs font-medium text-ink-muted hover:text-ink hover:bg-paper rounded-[4px] border border-line transition-colors"
                                    >
                                        Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-8 text-center">
                        <x-empty-state title="Belum ada koleksi buku" description="Buku yang baru ditambahkan akan muncul di sini.">
                            @can('create books')
                                <x-slot name="action">
                                    <a href="{{ route('books.create') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-brand text-white text-xs font-medium rounded-[6px]">
                                        <x-icon name="plus" class="w-3.5 h-3.5" />
                                        Tambah Buku Pertama
                                    </a>
                                </x-slot>
                            @endcan
                        </x-empty-state>
                    </div>
                @endif
            </x-card>
        </div>

        <!-- Hak Akses Panel (1 col) -->
        <div class="space-y-6">
            <x-card class="p-5">
                <div class="mb-4">
                    <h2 class="font-serif text-lg font-bold text-ink">Hak Akses Anda</h2>
                    <p class="text-xs text-ink-muted mt-0.5">Daftar wewenang atomik untuk peran {{ $roleName }}</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    @forelse ($permissions as $permission)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-[4px] text-xs font-medium bg-status-success-light text-status-success border border-status-success/25">
                            <span class="w-1.5 h-1.5 rounded-full bg-status-success"></span>
                            {{ $permission->name }}
                        </span>
                    @empty
                        <span class="text-xs text-ink-muted italic">Tidak ada permission khusus.</span>
                    @endforelse
                </div>

                @can('manage roles')
                    <div class="mt-6 pt-4 border-t border-line">
                        <a
                            href="{{ route('users.index') }}"
                            class="inline-flex items-center justify-between w-full p-2.5 rounded-[6px] bg-brand-50 hover:bg-brand-100 text-brand text-xs font-semibold border border-brand/20 transition-colors"
                        >
                            <span>Kelola Role & Pengguna</span>
                            <x-icon name="arrow-left" class="w-3.5 h-3.5 rotate-180" />
                        </a>
                    </div>
                @endcan
            </x-card>

            <!-- Bantuan / Info Singkat -->
            <x-card class="p-5 bg-paper/50">
                <div class="flex items-start gap-3">
                    <div class="p-2 rounded-[6px] bg-brand-50 text-brand shrink-0">
                        <x-icon name="alert-circle" class="w-4 h-4" />
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-ink uppercase tracking-wider">Peraturan Pustaka</h3>
                        <p class="text-xs text-ink-muted mt-1 leading-relaxed">
                            Pastikan data ISBN dan tahun terbit terisi dengan benar untuk mempermudah inventarisasi buku kampus.
                        </p>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
