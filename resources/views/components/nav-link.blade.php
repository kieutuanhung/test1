@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 text-xs font-bold uppercase tracking-widest2 leading-5 text-accent focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 text-xs font-bold uppercase tracking-widest2 leading-5 text-white hover:text-accent focus:outline-none focus:text-accent transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
