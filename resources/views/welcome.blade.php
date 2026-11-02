<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-paper">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Pustaka - Sistem Manajemen Buku Kampus</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|source-serif-4:400,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full font-sans text-ink antialiased bg-paper flex flex-col justify-between">
        <!-- Top Navigation -->
        <header class="border-b border-line bg-white/80 backdrop-blur-xs sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <a href="/" class="focus:outline-none">
                    <x-application-logo />
                </a>

                <nav class="flex items-center gap-3">
                    @auth
                        <a
                            href="{{ route('dashboard') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-brand hover:bg-brand-hover text-white text-xs font-semibold rounded-[6px] transition-colors shadow-sm"
                        >
                            <x-icon name="dashboard" class="w-4 h-4" />
                            <span>Buka Dashboard</span>
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="px-3.5 py-2 text-xs font-semibold text-ink-muted hover:text-ink transition-colors"
                        >
                            Masuk
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-flex items-center px-4 py-2 bg-brand hover:bg-brand-hover text-white text-xs font-semibold rounded-[6px] transition-colors shadow-sm"
                            >
                                Daftar Akun
                            </a>
                        @endif
                    @endauth
                </nav>
            </div>
        </header>

        <!-- Main Hero & Content -->
        <main class="flex-1">
            <!-- Hero Section -->
            <section class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto text-center">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-brand-50 text-brand border border-brand/20 mb-6 tracking-wide uppercase">
                    Sistem Manajemen Buku Kampus
                </span>

                <h1 class="font-serif text-3xl sm:text-5xl font-bold tracking-tight text-ink leading-tight max-w-3xl mx-auto">
                    Kelola koleksi buku kampus dengan rapi, terstruktur, dan aman.
                </h1>

                <p class="mt-5 text-base sm:text-lg text-ink-muted max-w-2xl mx-auto leading-relaxed">
                    Aplikasi perpustakaan terintegrasi untuk dosen, mahasiswa, dan pengelola akademik. Telusuri katalog literatur, kelola inventaris, dan pantau wewenang akses dengan efisien.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                    @auth
                        <a
                            href="{{ route('dashboard') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-brand hover:bg-brand-hover active:bg-brand-active text-white text-sm font-semibold rounded-[6px] transition-colors shadow-sm"
                        >
                            <span>Lanjut ke Dashboard</span>
                            <x-icon name="arrow-left" class="w-4 h-4 rotate-180" />
                        </a>
                        <a
                            href="{{ route('books.index') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-white hover:bg-paper text-ink text-sm font-medium border border-line rounded-[6px] transition-colors shadow-card"
                        >
                            <span>Jelajahi Buku</span>
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-brand hover:bg-brand-hover active:bg-brand-active text-white text-sm font-semibold rounded-[6px] transition-colors shadow-sm"
                        >
                            <span>Masuk ke Akun</span>
                            <x-icon name="arrow-left" class="w-4 h-4 rotate-180" />
                        </a>
                        <a
                            href="{{ route('register') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-white hover:bg-paper text-ink text-sm font-medium border border-line rounded-[6px] transition-colors shadow-card"
                        >
                            <span>Daftar Akun Baru</span>
                        </a>
                    @endauth
                </div>
            </section>

            <!-- Feature Cards Section -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <x-card class="p-6">
                        <div class="w-10 h-10 rounded-[6px] bg-brand-50 border border-brand/20 flex items-center justify-center text-brand mb-4">
                            <x-icon name="search" class="w-5 h-5" />
                        </div>
                        <h3 class="font-serif text-lg font-bold text-ink">Katalog & Pencarian Cepat</h3>
                        <p class="text-xs text-ink-muted mt-2 leading-relaxed">
                            Cari koleksi buku berdasarkan judul dan penulis dengan pencarian instan dan paginasi yang rapi.
                        </p>
                    </x-card>

                    <x-card class="p-6">
                        <div class="w-10 h-10 rounded-[6px] bg-accent-light border border-accent/25 flex items-center justify-center text-accent mb-4">
                            <x-icon name="shield" class="w-5 h-5" />
                        </div>
                        <h3 class="font-serif text-lg font-bold text-ink">Kontrol Akses Bertingkat</h3>
                        <p class="text-xs text-ink-muted mt-2 leading-relaxed">
                            Pemisahan izin ketat untuk Admin, Dosen, dan Mahasiswa memastikan data inventaris terlindungi.
                        </p>
                    </x-card>

                    <x-card class="p-6">
                        <div class="w-10 h-10 rounded-[6px] bg-paper border border-line flex items-center justify-center text-ink mb-4">
                            <x-icon name="book" class="w-5 h-5" />
                        </div>
                        <h3 class="font-serif text-lg font-bold text-ink">Standar Bibliografi Kampus</h3>
                        <p class="text-xs text-ink-muted mt-2 leading-relaxed">
                            Format metadata lengkap mencakup nomor ISBN resmi, penerbit, tahun terbit, dan deskripsi buku.
                        </p>
                    </x-card>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="border-t border-line bg-white py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-ink-muted">
                <div class="flex items-center gap-2">
                    <span class="font-serif font-bold text-ink">Pustaka</span>
                    <span>&copy; {{ date('Y') }} Sistem Manajemen Buku Kampus.</span>
                </div>
                <div>
                    <span>Didesain dengan palet netral hangat & Dark Teal.</span>
                </div>
            </div>
        </footer>
    </body>
</html>
