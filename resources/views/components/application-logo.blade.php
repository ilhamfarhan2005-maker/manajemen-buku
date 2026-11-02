@props(['inverted' => false, 'iconOnly' => false, 'class' => ''])

<div class="inline-flex items-center gap-2.5 {{ $class }}">
    <div class="flex items-center justify-center w-9 h-9 rounded-[6px] {{ $inverted ? 'bg-white/10 text-white border border-white/20' : 'bg-brand text-white shadow-sm' }} shrink-0">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
            <path d="M6 2v20"/>
            <path d="M10 7h6"/>
            <path d="M10 11h4"/>
        </svg>
    </div>
    @if(!$iconOnly)
        <div class="flex flex-col text-left leading-none">
            <span class="font-serif font-bold text-lg tracking-tight {{ $inverted ? 'text-white' : 'text-ink' }}">Pustaka</span>
            <span class="text-[10px] uppercase font-medium tracking-wider mt-0.5 {{ $inverted ? 'text-white/70' : 'text-ink-muted' }}">Manajemen Buku</span>
        </div>
    @endif
</div>
