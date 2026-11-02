<section class="space-y-4">
    <header class="border-b border-line pb-4">
        <h2 class="font-serif text-lg font-bold text-status-danger">
            Hapus Akun
        </h2>

        <p class="mt-1 text-xs text-ink-muted leading-relaxed">
            Setelah akun Anda dihapus, seluruh sumber daya dan data yang terkait akan dihapus secara permanen. Sebelum menghapus akun, pastikan Anda telah mencadangkan data yang diperlukan.
        </p>
    </header>

    <div class="pt-2">
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        >Hapus Akun Saya</x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3.5 mb-4">
                <div class="w-10 h-10 rounded-full bg-status-danger-light text-status-danger flex items-center justify-center shrink-0">
                    <x-icon name="trash" class="w-5 h-5" />
                </div>
                <div>
                    <h2 class="text-base font-bold text-ink">
                        Konfirmasi Hapus Akun
                    </h2>
                    <p class="text-xs text-ink-muted">Tindakan ini tidak dapat dibatalkan</p>
                </div>
            </div>

            <p class="text-xs text-ink-muted leading-relaxed mb-4">
                Apakah Anda yakin ingin menghapus akun Anda? Masukkan kata sandi akun Anda untuk mengonfirmasi bahwa Anda benar-benar ingin menghapus akun ini secara permanen.
            </p>

            <div>
                <x-input-label for="password" value="Kata Sandi Akun" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full sm:w-3/4"
                    placeholder="Masukkan kata sandi untuk konfirmasi"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1.5" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>

                <x-danger-button>
                    Ya, Hapus Akun
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
