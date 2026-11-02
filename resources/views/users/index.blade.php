<x-app-layout>
    <x-slot name="pageTitle">Kelola Role Pengguna</x-slot>
    <x-slot name="header">Kelola Role</x-slot>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-ink">
                Kelola Role Pengguna
            </h1>
            <p class="mt-1 text-sm text-ink-muted">
                Atur wewenang dan tingkatan akses untuk akun staf, pengajar, dan mahasiswa.
            </p>
        </div>

        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-[6px] bg-brand-50 border border-brand/20 text-brand text-xs font-semibold">
            <x-icon name="shield" class="w-4 h-4" />
            <span>Hak Akses Khusus Administrator</span>
        </div>
    </div>

    <!-- Users Table Card -->
    <x-card>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-line bg-paper/50">
                        <th scope="col" class="py-3 px-5 text-[11px] font-semibold uppercase tracking-wider text-ink-muted">Pengguna</th>
                        <th scope="col" class="py-3 px-5 text-[11px] font-semibold uppercase tracking-wider text-ink-muted">Alamat Email</th>
                        <th scope="col" class="py-3 px-5 text-[11px] font-semibold uppercase tracking-wider text-ink-muted">Role Saat Ini</th>
                        <th scope="col" class="py-3 px-5 text-[11px] font-semibold uppercase tracking-wider text-ink-muted text-right">Ubah Wewenang</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line text-sm">
                    @foreach ($users as $user)
                        @php
                            $currentRole = $user->getRoleNames()->first() ?? 'Tanpa Role';
                            $roleVariant = match(strtolower($currentRole)) {
                                'admin' => 'admin',
                                'dosen' => 'dosen',
                                default => 'mahasiswa',
                            };
                            $isSelf = $user->is(auth()->user());
                        @endphp
                        <tr class="hover:bg-[#FAF9F5] transition-colors {{ $isSelf ? 'bg-brand-50/20' : '' }}">
                            <td class="py-3.5 px-5">
                                <div class="flex items-center gap-3">
                                    <x-avatar :name="$user->name" :role="$currentRole" size="md" />
                                    <div>
                                        <div class="font-semibold text-ink flex items-center gap-2">
                                            <span>{{ $user->name }}</span>
                                            @if ($isSelf)
                                                <span class="px-1.5 py-0.5 rounded-[4px] bg-brand/10 text-brand text-[10px] font-bold uppercase tracking-wider">
                                                    Anda
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-ink-muted sm:hidden mt-0.5">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="py-3.5 px-5 text-xs text-ink-muted">
                                {{ $user->email }}
                            </td>

                            <td class="py-3.5 px-5">
                                <x-badge :variant="$roleVariant" size="md">
                                    {{ $currentRole }}
                                </x-badge>
                            </td>

                            <td class="py-3.5 px-5 text-right">
                                @if ($isSelf)
                                    <span class="text-xs text-ink-subtle italic">
                                        (Akun Anda sendiri)
                                    </span>
                                @else
                                    <form method="POST" action="{{ route('users.role.update', $user) }}" class="inline-flex items-center gap-2 justify-end">
                                        @csrf
                                        @method('PATCH')

                                        <select
                                            name="role"
                                            class="h-9 px-2.5 py-1 bg-white border border-line text-xs font-medium rounded-[6px] text-ink focus:border-brand focus:ring-1 focus:ring-brand/20"
                                        >
                                            @foreach ($roles as $roleOption)
                                                <option value="{{ $roleOption }}" @selected($user->hasRole($roleOption))>
                                                    {{ $roleOption }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <button
                                            type="submit"
                                            class="h-9 px-3 bg-brand hover:bg-brand-hover active:bg-brand-active text-white text-xs font-semibold rounded-[6px] transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-brand/40"
                                        >
                                            Simpan
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</x-app-layout>
