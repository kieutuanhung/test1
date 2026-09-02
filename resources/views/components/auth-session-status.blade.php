@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-white border border-neutral-700 bg-neutral-900 px-4 py-2']) }}>
        {{ $status }}
    </div>
@endif
