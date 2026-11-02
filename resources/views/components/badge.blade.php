@props(['variant' => 'neutral', 'size' => 'md'])

@php
$sizeClasses = [
    'sm' => 'text-[11px] px-2 py-0.5',
    'md' => 'text-xs px-2.5 py-1',
    'lg' => 'text-sm px-3 py-1.5',
][$size] ?? 'text-xs px-2.5 py-1';

$variantClasses = match (strtolower((string) $variant)) {
    'admin', 'brand', 'teal' => 'bg-brand-50 text-brand border border-brand/25 font-semibold',
    'dosen', 'accent', 'amber' => 'bg-accent-light text-accent-hover border border-accent/30 font-semibold',
    'mahasiswa', 'neutral', 'gray', 'abu' => 'bg-[#ECEAE4] text-ink-muted border border-line font-medium',
    'success', 'hijau' => 'bg-status-success-light text-status-success border border-status-success/25 font-semibold',
    'danger', 'merah', 'error' => 'bg-status-danger-light text-status-danger border border-status-danger/25 font-semibold',
    default => 'bg-[#ECEAE4] text-ink-muted border border-line font-medium',
};
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1 rounded-[4px] leading-tight tracking-wide {$sizeClasses} {$variantClasses}"]) }}>
    {{ $slot }}
</span>
