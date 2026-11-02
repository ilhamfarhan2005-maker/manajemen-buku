@php
    $user = Auth::user();
    $roleName = $user->getRoleNames()->first() ?? 'Mahasiswa';
    $roleVariant = match(strtolower($roleName)) {
        'admin' => 'admin',
        'dosen' => 'dosen',
        default => 'mahasiswa',
    };
@endphp

<!-- Mobile Backdrop -->
<div
    x-show="sidebarOpen"
    x-transition:enter="transition-opacity ease-linear duration-150"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="sidebarOpen = false"
    class="fixed inset-0 z-40 bg-ink/40 backdrop-blur-xs lg:hidden"
    style="display: none;"
    aria-hidden="true"
></div>

<!-- Sidebar: Desktop Fixed & Mobile Drawer -->
<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-line flex flex-col transition-transform duration-150 ease-in-out lg:static lg:inset-auto lg:translate-x-0 shrink-0"
>
    <!-- Logo & Close (Mobile) -->
    <div class="h-16 px-6 flex items-center justify-between border-b border-line shrink-0">
        <a href="{{ route('dashboard') }}" class="focus:outline-none">
            <x-application-logo />
        </a>
        <button
            type="button"
            @click="sidebarOpen = false"
            class="p-1.5 text-ink-muted hover:text-ink hover:bg-paper rounded-[4px] lg:hidden focus:outline-none"
            aria-label="Tutup menu navigasi"
        >
            <x-icon name="x-mark" class="w-5 h-5" />
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        <div class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-ink-subtle">
            Menu Utama
        </div>

        <!-- Dashboard -->
        <a
            href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-[6px] text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand font-semibold border-l-4 border-brand pl-2' : 'text-ink-muted hover:text-ink hover:bg-paper border-l-4 border-transparent pl-2' }}"
        >
            <x-icon name="dashboard" class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-brand' : 'text-ink-muted' }}" />
            <span>Dashboard</span>
        </a>

        <!-- Buku -->
        @can('view books')
            <a
                href="{{ route('books.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-[6px] text-sm font-medium transition-colors {{ request()->routeIs('books.*') ? 'bg-brand-50 text-brand font-semibold border-l-4 border-brand pl-2' : 'text-ink-muted hover:text-ink hover:bg-paper border-l-4 border-transparent pl-2' }}"
            >
                <x-icon name="book" class="w-4 h-4 {{ request()->routeIs('books.*') ? 'text-brand' : 'text-ink-muted' }}" />
                <span>Koleksi Buku</span>
            </a>
        @endcan

        <!-- Kelola Role (Admin Only) -->
        @can('manage roles')
            <a
                href="{{ route('users.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-[6px] text-sm font-medium transition-colors {{ request()->routeIs('users.*') ? 'bg-brand-50 text-brand font-semibold border-l-4 border-brand pl-2' : 'text-ink-muted hover:text-ink hover:bg-paper border-l-4 border-transparent pl-2' }}"
            >
                <x-icon name="users" class="w-4 h-4 {{ request()->routeIs('users.*') ? 'text-brand' : 'text-ink-muted' }}" />
                <span>Kelola Role</span>
            </a>
        @endcan

        <div class="pt-4 px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-ink-subtle">
            Pengaturan
        </div>

        <!-- Profil -->
        <a
            href="{{ route('profile.edit') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-[6px] text-sm font-medium transition-colors {{ request()->routeIs('profile.*') ? 'bg-brand-50 text-brand font-semibold border-l-4 border-brand pl-2' : 'text-ink-muted hover:text-ink hover:bg-paper border-l-4 border-transparent pl-2' }}"
        >
            <x-icon name="user" class="w-4 h-4 {{ request()->routeIs('profile.*') ? 'text-brand' : 'text-ink-muted' }}" />
            <span>Profil Saya</span>
        </a>
    </nav>

    <!-- Sidebar Bottom: Current User Card & Logout -->
    <div class="p-3 border-t border-line shrink-0 bg-paper/60">
        <div class="p-2.5 rounded-[8px] bg-white border border-line shadow-card flex items-center justify-between">
            <div class="flex items-center gap-2.5 min-w-0">
                <x-avatar :name="$user->name" :role="$roleName" size="sm" />
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-ink truncate">{{ $user->name }}</p>
                    <x-badge :variant="$roleVariant" size="sm" class="mt-0.5">
                        {{ $roleName }}
                    </x-badge>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="p-1.5 text-ink-muted hover:text-status-danger hover:bg-status-danger-light rounded-[4px] transition-colors focus:outline-none"
                    title="Keluar"
                    aria-label="Keluar dari akun"
                >
                    <x-icon name="logout" class="w-4 h-4" />
                </button>
            </form>
        </div>
    </div>
</aside>
