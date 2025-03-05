@props(['title' => 'Flowbite', 'buttonText' => 'Get Started'])

<a href="{{ url('/') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
    <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Logo">
    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">{{ $title }}</span>
</a>

<button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    {{ $buttonText }}
</button>
