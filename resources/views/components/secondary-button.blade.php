@props(['type' => 'button'])

<button {{ $attributes->merge([
    'type' => $type,
    'class' => 'inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-[#F2F0EB] active:bg-[#EAE7DF] text-ink text-sm font-medium border border-line rounded-[6px] transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-ink/20 focus:ring-offset-2 focus:ring-offset-paper disabled:opacity-50 disabled:cursor-not-allowed shadow-card'
]) }}>
    {{ $slot }}
</button>
