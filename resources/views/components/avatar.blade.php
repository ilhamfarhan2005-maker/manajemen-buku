@props(['name' => 'User', 'size' => 'md', 'role' => null])

@php
$words = preg_split('/\s+/', trim($name));
$initials = '';
if (count($words) >= 2) {
    $initials = mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1);
} elseif (count($words) === 1 && !empty($words[0])) {
    $initials = mb_substr($words[0], 0, 2);
} else {
    $initials = 'U';
}
$initials = mb_strtoupper($initials);

$sizeClasses = [
    'xs' => 'w-6 h-6 text-[10px]',
    'sm' => 'w-8 h-8 text-xs',
    'md' => 'w-9 h-9 text-xs',
    'lg' => 'w-11 h-11 text-sm font-semibold',
    'xl' => 'w-16 h-16 text-lg font-semibold',
][$size] ?? 'w-9 h-9 text-xs';

// Role-based or deterministic palette
$colorClass = match (strtolower((string) $role)) {
    'admin' => 'bg-brand text-white border-brand',
    'dosen' => 'bg-accent text-white border-accent',
    'mahasiswa' => 'bg-[#E3DFD5] text-ink border-line',
    default => 'bg-brand/10 text-brand border-brand/20',
};
@endphp

<div {{ $attributes->merge(['class' => "relative inline-flex items-center justify-center rounded-full font-semibold border select-none shrink-0 {$sizeClasses} {$colorClass}"]) }}>
    <span>{{ $initials }}</span>
</div>
