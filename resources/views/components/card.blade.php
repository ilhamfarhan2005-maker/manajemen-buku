@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'bg-white rounded-[10px] border border-line shadow-card overflow-hidden ' . $class]) }}>
    {{ $slot }}
</div>
