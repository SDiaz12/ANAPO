@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'transition duration-100 ease-in-out text-white dark:text-white group'
        : 'transition duration-100 ease-in-out text-black dark:text-white group';

@endphp

<svg {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</svg>