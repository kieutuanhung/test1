@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xs font-semibold uppercase tracking-widest2 text-neutral-300 mb-1.5']) }}>
    {{ $value ?? $slot }}
</label>
