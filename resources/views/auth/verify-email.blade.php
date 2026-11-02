<x-guest-layout>
    <x-slot name="title">Verifikasi Email - Pustaka</x-slot>

    <div class="mb-6">
        <h2 class="font-serif text-2xl font-bold tracking-tight text-ink">Verifikasi alamat email</h2>
        <p class="mt-2 text-sm text-ink-muted leading-relaxed">
            Terima kasih telah mendaftar! Sebelum memulai, silakan klik tautan verifikasi yang baru saja kami kirimkan ke alamat email Anda.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-xs font-medium text-status-success bg-status-success-light border border-status-success/20 p-3.5 rounded-[6px]">
            Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda daftarkan.
        </div>
    @endif

    <div class="space-y-4 pt-2">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="w-full h-11">
                Kirim Ulang Email Verifikasi
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit" class="text-xs text-ink-muted hover:text-ink underline transition-colors">
                Keluar
            </button>
        </form>
    </div>
</x-guest-layout>
