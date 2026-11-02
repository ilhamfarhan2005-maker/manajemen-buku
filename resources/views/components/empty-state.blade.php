@props(['title' => 'Belum ada data', 'description' => null])

<div class="flex flex-col items-center justify-center py-12 px-4 text-center">
    <div class="w-16 h-16 mb-4 rounded-full bg-paper border border-line flex items-center justify-center text-ink-muted">
        <svg class="w-8 h-8 text-ink-muted/80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
            <path d="M6 2v20"/>
            <path d="M9 10h6"/>
            <path d="M12 7v6"/>
        </svg>
    </div>
    <h3 class="text-base font-semibold text-ink">{{ $title }}</h3>
    @if ($description)
        <p class="mt-1 text-sm text-ink-muted max-w-sm">{{ $description }}</p>
    @endif
    @if (isset($action))
        <div class="mt-4">
            {{ $action }}
        </div>
    @endif
</div>
