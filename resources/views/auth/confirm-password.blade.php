<x-guest-layout>
    <x-slot name="title">Konfirmasi Kata Sandi - Pustaka</x-slot>

    <div class="mb-6">
        <h2 class="font-serif text-2xl font-bold tracking-tight text-ink">Konfirmasi keamanan</h2>
        <p class="mt-1.5 text-sm text-ink-muted">
            Ini adalah area aman aplikasi. Harap konfirmasikan kata sandi Anda sebelum melanjutkan.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Kata Sandi" />
            <x-text-input id="password" class="block w-full" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full h-11">
                Konfirmasi
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
