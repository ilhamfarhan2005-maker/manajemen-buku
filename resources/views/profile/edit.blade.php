<x-app-layout>
    <x-slot name="pageTitle">Profil Akun Saya</x-slot>
    <x-slot name="header">Profil Saya</x-slot>

    <!-- Header -->
    <div class="mb-6">
        <h1 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-ink">
            Pengaturan Akun
        </h1>
        <p class="mt-1 text-sm text-ink-muted">
            Kelola data diri, alamat email, dan keamanan akun Pustaka Anda.
        </p>
    </div>

    <div class="space-y-6 max-w-4xl">
        <x-card class="p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </x-card>

        <x-card class="p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </x-card>

        <x-card class="p-6 sm:p-8 border-status-danger/20">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </x-card>
    </div>
</x-app-layout>
