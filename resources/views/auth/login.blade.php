<x-guest-layout>
    <x-navbar />
    <section class="bg-white w-full z-0">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <!-- Sección del formulario -->
            <div class="flex items-center justify-center px-4 pt-8 pb-36 bg-white sm:px-6 lg:px-8 sm:py-6 lg:py-6">
                <div class="xl:w-full xl:max-w-sm 2xl:max-w-md xl:mx-auto">
                    <h2 class="text-3xl font-bold leading-tight text-black sm:text-4xl">Iniciar sesión</h2>
                    <p class="mt-2 text-base text-gray-600">
                        ¿No tienes cuenta de estudiante?
                        <a href="{{ route('register') }}" class="font-medium text-red-600 transition-all duration-200 hover:text-red-700 hover:underline focus:text-red-700">
                            Crea una cuenta
                        </a>
                    </p>
    
                    <x-validation-errors class="mb-4" />
    
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('status') }}
                        </div>
                    @endif
    
                    <form method="POST" action="{{ route('login') }}" class="mt-8">
                        @csrf
    
                        <div class="space-y-5">
                            <div>
                                <x-label for="email" value="Correo Electrónico" class="text-base font-medium text-gray-900" />
                                <div class="mt-2.5">
                                    <x-input id="email" class="block w-full p-3 text-black border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-red-600 focus:bg-white caret-red-600"
                                        type="email" name="email" :value="old('email')" required autofocus placeholder="Ingresa tu correo" />
                                </div>
                            </div>
    
                            <div>
                                <div class="flex items-center justify-between">
                                    <x-label for="password" value="Contraseña" class="text-base font-medium text-gray-900" />
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-red-600 hover:underline hover:text-red-700 focus:text-red-700">
                                            ¿Recordar contraseña?
                                        </a>
                                    @endif
                                </div>
                                <div class="mt-2.5">
                                    <x-input id="password" class="block w-full p-3 text-black border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-red-600 focus:bg-white caret-red-600"
                                        type="password" name="password" required placeholder="Ingresa tu contraseña" />
                                </div>
                            </div>
    
                            <div>
                                <x-button class="w-full">
                                    Acceder
                                </x-button>
                            </div>
                        </div>
                    </form>
    
                    
                </div>
            </div>
    
            <!-- Sección de la imagen y texto -->
            <div class="flex items-center justify-center px-4 py-10 sm:py-6 lg:py-24 bg-gradient-to-b from-red-50 to-yellow-100 sm:px-6 lg:px-8">
                <div>
                    <img class="w-full mx-auto" src="{{ asset('Logo/LOGO.png') }}" alt="Signup Banner" />
    
                    <div class="w-full max-w-md mx-auto xl:max-w-xl">
                        <h3 class="text-2xl font-bold text-center text-black">Plataforma Académica ANAPO</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
</x-guest-layout>
