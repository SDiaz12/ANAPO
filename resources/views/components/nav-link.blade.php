@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'bg-red-600 flex transition duration-100 ease-in-out dark:hover:bg-red-600 dark:bg-red-600 items-center p-2 text-black rounded-lg dark:text-white hover:bg-red-600 dark:hover:bg-red-600 group'
        : 'bg-red-0 flex dark:hover:bg-red-600 transition duration-100 ease-in-out items-center p-2 text-black rounded-lg dark:text-white hover:bg-red-600 dark:hover:bg-red-600 group';

@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>