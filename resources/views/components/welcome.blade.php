
    <section class="relative lg:min-h-[580px] pt-24 pb-10 sm:pt-32 sm:pb-16 lg:pb-24">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 relative z-20">
            <div class="max-w-xl mx-auto text-center">
                <h1 class="text-4xl font-bold sm:text-6xl">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-yellow-600"> Bienveni@ <span>{{Auth::user()->name}}</span> </span>
                </h1>
                <p class="mt-5 text-base dark:text-white text-gray-800 sm:text-xl">Estás en la plataforma oficial de la Academia Nacional de Policias, aquí puedrás revisar tus informacion.</p>

                <x-button title="" class="mt-8">
                    Ver calificaciones
                    <svg class="w-6 h-6 ml-8 -mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </x-button>
            </div>
        </div>
    </section>

