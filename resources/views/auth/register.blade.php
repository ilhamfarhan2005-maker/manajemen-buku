<x-guest-layout>
    <x-slot name="title">Daftar Akun Pustaka</x-slot>

    <div x-data="{
        showPassword: false,
        loading: false
    }">
        <div class="mb-6">
            <h2 class="font-serif text-2xl font-bold tracking-tight text-ink">Buat akun baru</h2>
            <p class="mt-1.5 text-sm text-ink-muted">Daftar untuk mengakses katalog buku kampus.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" @submit="loading = true" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" value="Nama Lengkap" />
                <x-text-input
                    id="name"
                    class="block w-full"
                    type="text"
                    name="name"
                    :value="old('name')"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Nama lengkap Anda"
                />
                <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" value="Alamat Email" />
                <x-text-input
                    id="email"
                    class="block w-full"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autocomplete="username"
                    placeholder="nama@kampus.ac.id"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" value="Kata Sandi" />
                <div class="relative">
                    <input
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                        class="h-11 px-3.5 pr-11 block w-full bg-white border border-line text-ink placeholder:text-ink-subtle text-sm rounded-[6px] shadow-sm transition-colors duration-150 focus:border-brand focus:ring-2 focus:ring-brand/20"
                    />
                    <button
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute right-0 top-0 bottom-0 px-3 flex items-center text-ink-muted hover:text-ink transition-colors focus:outline-none"
                        :aria-label="showPassword ? 'Sembunyikan password' : 'Tampilkan password'"
                    >
                        <template x-if="!showPassword">
                            <x-icon name="eye" class="w-4 h-4" />
                        </template>
                        <template x-if="showPassword">
                            <x-icon name="eye-off" class="w-4 h-4" />
                        </template>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" />
                <input
                    id="password_confirmation"
                    :type="showPassword ? 'text' : 'password'"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi kata sandi"
                    class="h-11 px-3.5 block w-full bg-white border border-line text-ink placeholder:text-ink-subtle text-sm rounded-[6px] shadow-sm transition-colors duration-150 focus:border-brand focus:ring-2 focus:ring-brand/20"
                />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
            </div>

            <p class="text-[11px] text-ink-muted pt-1">
                Pendaftar baru secara default mendapatkan role <span class="font-semibold text-ink">Mahasiswa</span>.
            </p>

            <!-- Submit Button -->
            <div class="pt-2">
                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full h-11 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-brand hover:bg-brand-hover active:bg-brand-active text-white text-sm font-medium rounded-[6px] transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:ring-offset-2 disabled:opacity-75 disabled:cursor-wait shadow-sm"
                >
                    <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="loading ? 'Mendaftarkan...' : 'Daftar Sekarang'">Daftar Sekarang</span>
                </button>
            </div>
        </form>

        <p class="mt-6 text-center text-xs text-ink-muted">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="font-semibold text-brand hover:text-brand-hover hover:underline transition-colors">
                Masuk di sini
            </a>
        </p>
    </div>
</x-guest-layout>
