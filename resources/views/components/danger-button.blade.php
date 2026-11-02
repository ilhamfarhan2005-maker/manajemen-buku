@props(['type' => 'submit'])

<button {{ $attributes->merge([
    'type' => $type,
    'class' => 'inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-status-danger hover:bg-[#9E2E25] active:bg-[#85251D] text-white text-sm font-medium rounded-[6px] transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-status-danger/40 focus:ring-offset-2 focus:ring-offset-paper disabled:opacity-50 disabled:cursor-not-allowed shadow-sm'
]) }}>
    {{ $slot }}
</button>
