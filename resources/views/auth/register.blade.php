<x-guest-layout>
    <x-navbar/>
    <section class="bg-white w-full z-0 relative">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <!-- Formulario de Registro -->
            <div class="flex items-center justify-center px-4 py-4 bg-white sm:px-6 lg:px-8 sm:py-4">
                <div class="xl:w-full xl:max-w-sm 2xl:max-w-md xl:mx-auto">
                    <h2 class="text-3xl font-bold leading-tight text-black sm:text-4xl">Regístrate</h2>
                    <p class="mt-2 text-base text-gray-600">
                        ¿Ya tienes cuenta de estudiante?
                        <a href="{{ route('login') }}" class="font-medium text-red-600 transition-all duration-200 hover:text-red-700 hover:underline focus:text-red-700">
                            Acceder
                        </a>
                    </p>
    
                    <x-validation-errors class="mb-4" />
    
                    <form method="POST" action="{{ route('register') }}" class="mt-2">
                        @csrf
    
                        <div class="space-y-4">
                            <div>
                                <x-label for="name" value="Nombre completo" class="text-base font-medium text-gray-900" />
                                <div class="mt-2">
                                    <x-input id="name" class="block w-full p-3 text-black border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-red-600 focus:bg-white caret-red-600"
                                        type="text" name="name" :value="old('name')" required autofocus placeholder="Ingresa tu nombre completo" />
                                </div>
                            </div>
    
                            <div>
                                <x-label for="email" value="Correo" class="text-base font-medium text-gray-900" />
                                <div class="mt-2">
                                    <x-input id="email" class="block w-full p-3 text-black border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-red-600 focus:bg-white caret-red-600"
                                        type="email" name="email" :value="old('email')" required placeholder="Ingresa tu correo" />
                                </div>
                            </div>
    
                            <div>
                                <x-label for="password" value="Contraseña" class="text-base font-medium text-gray-900" />
                                <div class="mt-2">
                                    <x-input id="password" class="block w-full p-3 text-black border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-red-600 focus:bg-white caret-red-600"
                                        type="password" name="password" required placeholder="Ingresa tu contraseña" />
                                </div>
                            </div>
    
                            <div>
                                <x-label for="password_confirmation" value="Confirmar contraseña" class="text-base font-medium text-gray-900" />
                                <div class="mt-2">
                                    <x-input id="password_confirmation" class="block w-full p-3 text-black border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-red-600 focus:bg-white caret-red-600"
                                        type="password" name="password_confirmation" required placeholder="Confirma tu contraseña" />
                                </div>
                            </div>
    
                            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                <div class="flex items-center">
                                    <x-checkbox id="terms" name="terms" required class="w-5 h-5 text-red-600 bg-white border-gray-200 rounded" />
                                    <label for="terms" class="ml-3 text-sm font-medium text-gray-500">
                                        {!! __('Acepto los :terms_of_service y :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-red-600 hover:text-red-700 hover:underline">Términos de Servicio</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-red-600 hover:text-red-700 hover:underline">la Política de Privacidad</a>',
                                        ]) !!}
                                    </label>
                                </div>
                            @endif
    
                            <div>
                                <x-button class="w-full">
                                    Crear cuenta
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
