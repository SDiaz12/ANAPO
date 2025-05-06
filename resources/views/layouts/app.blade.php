<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Plataforma ANAPO') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('Logo/LOGO.png') }}" />
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <style>
            @layer utilities {
                .scrollbar-hidden::-webkit-scrollbar {
                display: none;
            }
            }
        </style>
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            // On page load or when changing themes, best to add inline in `head` to avoid FOUC
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased scrollbar-hidden">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <x-sidebar />
            <!-- Page Heading -->
            
            <!-- Page Content -->
            <main class="dark:bg-gray-900">
                <div class="p-4 sm:ml-64 mt-10">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
                        {{ $slot }}
                    </div>
                </div>
                <script>
                    var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
                    var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
        
                    // Change the icons inside the button based on previous settings
                    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                        themeToggleLightIcon.classList.remove('hidden');
                    } else {
                        themeToggleDarkIcon.classList.remove('hidden');
                    }
        
                    var themeToggleBtn = document.getElementById('theme-toggle');
        
                    themeToggleBtn.addEventListener('click', function () {
        
                        // toggle icons inside button
                        themeToggleDarkIcon.classList.toggle('hidden');
                        themeToggleLightIcon.classList.toggle('hidden');
        
                        // if set via local storage previously
                        if (localStorage.getItem('color-theme')) {
                            if (localStorage.getItem('color-theme') === 'light') {
                                document.documentElement.classList.add('dark');
                                localStorage.setItem('color-theme', 'dark');
                            } else {
                                document.documentElement.classList.remove('dark');
                                localStorage.setItem('color-theme', 'light');
                            }
        
                            // if NOT set via local storage previously
                        } else {
                            if (document.documentElement.classList.contains('dark')) {
                                document.documentElement.classList.remove('dark');
                                localStorage.setItem('color-theme', 'light');
                            } else {
                                document.documentElement.classList.add('dark');
                                localStorage.setItem('color-theme', 'dark');
                            }
                        }
        
                    });
                </script>
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
    </body>
</html>