@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-4 pe-4 py-2.5 border-l-2 border-accent text-start text-sm font-semibold uppercase tracking-wide text-white bg-neutral-900 focus:outline-none transition duration-150 ease-in-out'
            : 'block w-full ps-4 pe-4 py-2.5 border-l-2 border-transparent text-start text-sm font-semibold uppercase tracking-wide text-neutral-300 hover:text-white hover:bg-neutral-900 hover:border-neutral-700 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
