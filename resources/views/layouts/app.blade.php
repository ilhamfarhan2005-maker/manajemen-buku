@php
    $user = Auth::user();
    $roleName = $user ? ($user->getRoleNames()->first() ?? 'Mahasiswa') : '';
    $roleVariant = match(strtolower($roleName)) {
        'admin' => 'admin',
        'dosen' => 'dosen',
        default => 'mahasiswa',
    };
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-paper">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $pageTitle ?? ($title ?? 'Pustaka') }} - Sistem Manajemen Buku Kampus</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|source-serif-4:400,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full font-sans text-ink antialiased bg-paper">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">
            <!-- Navigation Sidebar & Mobile Drawer -->
            @include('layouts.navigation')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Top Bar -->
                <header class="h-16 bg-white border-b border-line px-4 sm:px-6 lg:px-8 flex items-center justify-between sticky top-0 z-30 shadow-card">
                    <div class="flex items-center gap-3">
                        <!-- Mobile Hamburger Button -->
                        <button
                            type="button"
                            @click="sidebarOpen = true"
                            class="p-2 -ml-2 text-ink-muted hover:text-ink hover:bg-paper rounded-[6px] lg:hidden focus:outline-none"
                            aria-label="Buka menu navigasi"
                        >
                            <x-icon name="menu" class="w-5 h-5" />
                        </button>

                        <div class="text-sm font-semibold text-ink-muted hidden sm:block">
                            @isset($header)
                                {{ $header }}
                            @else
                                Pustaka Kampus
                            @endisset
                        </div>
                    </div>

                    <!-- Right Side: User Status & Dropdown -->
                    <div class="flex items-center gap-3" x-data="{ dropdownOpen: false }">
                        <div class="flex items-center gap-2.5">
                            <x-avatar :name="$user->name" :role="$roleName" size="md" />
                            <div class="hidden sm:flex flex-col text-left">
                                <span class="text-xs font-semibold text-ink leading-tight">{{ $user->name }}</span>
                                <div class="mt-0.5">
                                    <x-badge :variant="$roleVariant" size="sm">
                                        {{ $roleName }}
                                    </x-badge>
                                </div>
                            </div>
                        </div>

                        <!-- Dropdown Menu -->
                        <div class="relative">
                            <button
                                type="button"
                                @click="dropdownOpen = !dropdownOpen"
                                class="p-1.5 text-ink-muted hover:text-ink hover:bg-paper rounded-[4px] transition-colors focus:outline-none focus:ring-2 focus:ring-brand/20"
                                aria-label="Menu pengguna"
                            >
                                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div
                                x-show="dropdownOpen"
                                @click.away="dropdownOpen = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-[8px] border border-line shadow-modal py-1 z-50"
                                style="display: none;"
                            >
                                <div class="px-3 py-2 border-b border-line sm:hidden">
                                    <p class="text-xs font-semibold text-ink truncate">{{ $user->name }}</p>
                                    <p class="text-[11px] text-ink-muted truncate">{{ $user->email }}</p>
                                </div>

                                <a
                                    href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-2 px-3 py-2 text-xs font-medium text-ink hover:bg-paper transition-colors"
                                    @click="dropdownOpen = false"
                                >
                                    <x-icon name="user" class="w-4 h-4 text-ink-muted" />
                                    <span>Profil Saya</span>
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="w-full flex items-center gap-2 px-3 py-2 text-xs font-medium text-status-danger hover:bg-status-danger-light transition-colors text-left"
                                    >
                                        <x-icon name="logout" class="w-4 h-4" />
                                        <span>Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Toast Notifications (Flash messages) -->
        <div
            aria-live="assertive"
            class="fixed top-4 right-4 z-50 flex flex-col gap-2 max-w-sm w-full pointer-events-none"
        >
            @if (session('success'))
                <div
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 4000)"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                    class="pointer-events-auto bg-white border border-status-success/30 rounded-[8px] p-3.5 shadow-toast flex items-start gap-3"
                    role="alert"
                >
                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-status-success-light text-status-success shrink-0 mt-0.5">
                        <x-icon name="check" class="w-3.5 h-3.5" />
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-ink">Berhasil</p>
                        <p class="text-xs text-ink-muted mt-0.5">{{ session('success') }}</p>
                    </div>
                    <button
                        type="button"
                        @click="show = false"
                        class="text-ink-subtle hover:text-ink p-1 rounded focus:outline-none"
                        aria-label="Tutup notifikasi"
                    >
                        <x-icon name="x-mark" class="w-3.5 h-3.5" />
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 4000)"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                    class="pointer-events-auto bg-white border border-status-danger/30 rounded-[8px] p-3.5 shadow-toast flex items-start gap-3"
                    role="alert"
                >
                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-status-danger-light text-status-danger shrink-0 mt-0.5">
                        <x-icon name="alert-circle" class="w-3.5 h-3.5" />
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-ink">Terjadi Kendala</p>
                        <p class="text-xs text-ink-muted mt-0.5">{{ session('error') }}</p>
                    </div>
                    <button
                        type="button"
                        @click="show = false"
                        class="text-ink-subtle hover:text-ink p-1 rounded focus:outline-none"
                        aria-label="Tutup notifikasi"
                    >
                        <x-icon name="x-mark" class="w-3.5 h-3.5" />
                    </button>
                </div>
            @endif
        </div>
    </body>
</html>
