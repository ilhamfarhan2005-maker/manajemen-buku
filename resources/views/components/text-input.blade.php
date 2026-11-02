@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge([
    'class' => 'h-11 px-3.5 bg-white border border-line text-ink placeholder:text-ink-subtle text-sm rounded-[6px] shadow-sm transition-colors duration-150 focus:border-brand focus:ring-2 focus:ring-brand/20 disabled:bg-[#F2F0EB] disabled:text-ink-muted disabled:cursor-not-allowed'
]) }}>
