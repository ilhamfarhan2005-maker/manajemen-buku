<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-paper">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Pustaka - Sistem Manajemen Buku Kampus' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|source-serif-4:400,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full font-sans text-ink antialiased">
        <div class="min-h-screen flex">
            <!-- Left Column: Branding (Desktop only) -->
            <div class="hidden lg:flex lg:w-1/2 bg-brand text-white flex-col justify-between p-12 relative overflow-hidden border-r border-brand-active">
                <!-- Subtle background pattern -->
                <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 24px 24px;"></div>

                <div class="relative z-10">
                    <a href="/" class="inline-block">
                        <x-application-logo :inverted="true" />
                    </a>
                </div>

                <div class="relative z-10 my-auto max-w-lg py-12">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-white/90 border border-white/20 mb-6 tracking-wide uppercase">
                        Sistem Informasi Kampus
                    </span>
                    <h1 class="font-serif text-3xl xl:text-4xl font-bold leading-tight text-white mb-6">
                        Kelola koleksi buku kampus dengan rapi.
                    </h1>
                    <p class="text-white/80 text-base leading-relaxed mb-8">
                        Platform terintegrasi untuk katalogisasi, peminjaman, dan pengelolaan inventaris pustaka akademik yang cepat, aman, dan mudah digunakan.
                    </p>

                    <ul class="space-y-4 text-sm text-white/90">
                        <li class="flex items-start gap-3">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-white/15 text-white shrink-0 mt-0.5">
                                <x-icon name="check" class="w-3.5 h-3.5" />
                            </span>
                            <span>Katalog buku terstruktur dengan ISBN, penulis, dan penerbit akurat.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-white/15 text-white shrink-0 mt-0.5">
                                <x-icon name="check" class="w-3.5 h-3.5" />
                            </span>
                            <span>Kontrol hak akses ketat bertingkat untuk Admin, Dosen, dan Mahasiswa.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-white/15 text-white shrink-0 mt-0.5">
                                <x-icon name="check" class="w-3.5 h-3.5" />
                            </span>
                            <span>Pencarian instan dan pembaruan data koleksi yang responsif.</span>
                        </li>
                    </ul>
                </div>

                <div class="relative z-10 text-xs text-white/60 flex items-center justify-between pt-6 border-t border-white/10">
                    <span>&copy; {{ date('Y') }} Pustaka Kampus. Hak cipta dilindungi.</span>
                    <span>Versi 2.0</span>
                </div>
            </div>

            <!-- Right Column: Form Container -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 sm:p-10 bg-white min-h-screen">
                <div class="w-full max-w-[400px]">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden mb-8 text-center flex justify-center">
                        <a href="/">
                            <x-application-logo />
                        </a>
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
