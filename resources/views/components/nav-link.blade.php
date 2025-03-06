@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'bg-red-500 flex transition duration-100 ease-in-out dark:hover:bg-red-500 dark:bg-red-500 items-center p-2 text-black rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-red-500 group'
        : 'bg-red-0 flex dark:hover:bg-red-500 transition duration-100 ease-in-out items-center p-2 text-black rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-red-500 group';

@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>