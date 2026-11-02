@props(['title', 'description' => null])

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        @if (isset($breadcrumb))
            <div class="mb-1 text-xs text-ink-muted">
                {{ $breadcrumb }}
            </div>
        @endif
        <h1 class="font-serif text-2xl font-bold tracking-tight text-ink sm:text-3xl">
            {{ $title }}
        </h1>
        @if ($description)
            <p class="mt-1 text-sm text-ink-muted">
                {{ $description }}
            </p>
        @endif
    </div>

    @if (isset($actions))
        <div class="flex items-center gap-2.5 shrink-0">
            {{ $actions }}
        </div>
    @endif
</div>
