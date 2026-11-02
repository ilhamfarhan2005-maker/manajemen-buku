@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'flex items-center gap-2.5 p-3.5 mb-4 text-xs font-medium text-status-success bg-status-success-light border border-status-success/20 rounded-[6px]']) }}>
        <svg class="w-4 h-4 shrink-0 text-status-success" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
        <span>{{ $status }}</span>
    </div>
@endif
