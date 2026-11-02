<!DOCTYPE html>
<html lang="id" class="h-full bg-paper">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Ditolak | Pustaka</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600|source-serif-4:400,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans text-ink antialiased bg-paper flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-[10px] border border-line shadow-card p-8 text-center">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <x-application-logo />
        </div>

        <!-- 403 Badge & Title -->
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-status-danger-light border border-status-danger/20 flex items-center justify-center text-status-danger">
            <x-icon name="shield" class="w-8 h-8" />
        </div>

        <span class="inline-block px-2.5 py-0.5 rounded-[4px] bg-status-danger-light text-status-danger text-xs font-bold font-mono tracking-wider mb-2">
            GALAT 403
        </span>

        <h1 class="font-serif text-2xl font-bold tracking-tight text-ink mb-2">
            Akses Ditolak
        </h1>

        <p class="text-sm text-ink-muted leading-relaxed mb-6">
            Maaf, peran akun Anda tidak memiliki izin atau wewenang untuk membuka halaman atau menjalankan tindakan ini.
        </p>

        @if(!empty($exception?->getMessage()))
            <div class="p-3 mb-6 bg-paper rounded-[6px] border border-line text-xs font-mono text-ink-muted text-left">
                Detail: {{ $exception->getMessage() }}
            </div>
        @endif

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a
                href="{{ url('/dashboard') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-brand hover:bg-brand-hover text-white text-xs font-semibold rounded-[6px] transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-brand/40"
            >
                <x-icon name="dashboard" class="w-4 h-4" />
                <span>Kembali ke Dashboard</span>
            </a>

            <a
                href="{{ url('/') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 bg-white hover:bg-paper text-ink text-xs font-medium border border-line rounded-[6px] transition-colors"
            >
                Beranda
            </a>
        </div>
    </div>
</body>
</html>
