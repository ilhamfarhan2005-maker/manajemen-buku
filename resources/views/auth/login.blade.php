<x-guest-layout>
    <x-slot name="title">Masuk ke Pustaka</x-slot>

    <div x-data="{
        email: '{{ old('email', '') }}',
        password: '',
        showPassword: false,
        loading: false,
        fillAccount(accEmail, accPass) {
            this.email = accEmail;
            this.password = accPass;
        }
    }">
        <div class="mb-6">
            <h2 class="font-serif text-2xl font-bold tracking-tight text-ink">Selamat datang kembali</h2>
            <p class="mt-1.5 text-sm text-ink-muted">Masuk dengan kredensial akun kampus Anda.</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-5" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" @submit="loading = true" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" value="Alamat Email" />
                <x-text-input
                    id="email"
                    class="block w-full"
                    type="email"
                    name="email"
                    x-model="email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="nama@kampus.ac.id"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <x-input-label for="password" value="Kata Sandi" class="!mb-0" />
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-brand hover:text-brand-hover hover:underline transition-colors">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>

                <div class="relative">
                    <input
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        name="password"
                        x-model="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
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

            <!-- Remember Me -->
            <div class="flex items-center justify-between pt-1">
                <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer select-none">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="w-4 h-4 rounded-[4px] border-line text-brand focus:ring-brand/30 transition-colors"
                    >
                    <span class="text-xs text-ink-muted">Ingat saya di perangkat ini</span>
                </label>
            </div>

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
                    <span x-text="loading ? 'Memproses...' : 'Masuk'">Masuk</span>
                </button>
            </div>
        </form>

        <!-- Register Link -->
        <p class="mt-6 text-center text-xs text-ink-muted">
            Belum memiliki akun?
            <a href="{{ route('register') }}" class="font-semibold text-brand hover:text-brand-hover hover:underline transition-colors">
                Daftar sekarang
            </a>
        </p>

        <!-- Akun Demo -->
        <div class="mt-8 pt-6 border-t border-line">
            <div class="flex items-center justify-between mb-2.5">
                <span class="text-xs font-semibold uppercase tracking-wider text-ink-muted flex items-center gap-1.5">
                    <x-icon name="shield" class="w-3.5 h-3.5 text-accent" />
                    Akun Demo Pengujian
                </span>
                <span class="text-[11px] text-ink-subtle">Pass: password</span>
            </div>

            <div class="space-y-2">
                <div class="flex items-center justify-between p-2 rounded-[6px] bg-paper border border-line text-xs">
                    <div>
                        <div class="font-semibold text-ink flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand"></span>
                            Admin
                        </div>
                        <div class="text-[11px] text-ink-muted">admin@example.com</div>
                    </div>
                    <button
                        type="button"
                        @click="fillAccount('admin@example.com', 'password')"
                        class="px-2 py-1 bg-white hover:bg-brand-50 text-brand border border-line rounded-[4px] font-medium text-[11px] transition-colors"
                    >
                        Isi otomatis
                    </button>
                </div>

                <div class="flex items-center justify-between p-2 rounded-[6px] bg-paper border border-line text-xs">
                    <div>
                        <div class="font-semibold text-ink flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                            Dosen
                        </div>
                        <div class="text-[11px] text-ink-muted">dosen@example.com</div>
                    </div>
                    <button
                        type="button"
                        @click="fillAccount('dosen@example.com', 'password')"
                        class="px-2 py-1 bg-white hover:bg-accent-light text-accent-hover border border-line rounded-[4px] font-medium text-[11px] transition-colors"
                    >
                        Isi otomatis
                    </button>
                </div>

                <div class="flex items-center justify-between p-2 rounded-[6px] bg-paper border border-line text-xs">
                    <div>
                        <div class="font-semibold text-ink flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-ink-muted"></span>
                            Mahasiswa
                        </div>
                        <div class="text-[11px] text-ink-muted">mahasiswa@example.com</div>
                    </div>
                    <button
                        type="button"
                        @click="fillAccount('mahasiswa@example.com', 'password')"
                        class="px-2 py-1 bg-white hover:bg-[#EAE7DF] text-ink-muted border border-line rounded-[4px] font-medium text-[11px] transition-colors"
                    >
                        Isi otomatis
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
