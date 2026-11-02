<x-guest-layout>
    <x-slot name="title">Lupa Kata Sandi - Pustaka</x-slot>

    <div class="mb-6">
        <h2 class="font-serif text-2xl font-bold tracking-tight text-ink">Pemulihan kata sandi</h2>
        <p class="mt-1.5 text-sm text-ink-muted leading-relaxed">
            Masukkan alamat email yang terdaftar. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Alamat Email" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@kampus.ac.id" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full h-11">
                Kirim Tautan Pemulihan
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs text-brand hover:text-brand-hover hover:underline transition-colors">
            <x-icon name="arrow-left" class="w-3.5 h-3.5" />
            Kembali ke halaman Masuk
        </a>
    </div>
</x-guest-layout>
