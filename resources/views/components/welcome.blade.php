
    <section class="relative lg:min-h-[580px] pt-24 pb-10 sm:pt-32 sm:pb-16 lg:pb-24">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 relative z-20">
            <div class="max-w-xl mx-auto text-center">
                <h1 class="text-4xl font-bold sm:text-6xl">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-yellow-600"> Bienvenid@ <br><span>{{Auth::user()->name}}</span> </span>
                </h1>
                <p class="mt-5 text-base dark:text-white text-gray-800 sm:text-xl">Estás en la plataforma oficial de la Academia Nacional de Policias, aquí puedrás revisar tu informacion.</p>

                @if(Auth::user()->estudiante && Auth::user()->estudiante->asignaturaEstudiantes->isNotEmpty())
                    <a href="{{ route('notasEstudiante', ['asignaturaEstudianteId' => Auth::user()->estudiante->asignaturaEstudiantes->first()->id]) }}"
                        class="inline-flex items-center px-6 py-4 mt-8 font-semibold text-white transition-all duration-200 bg-red-600 rounded-lg sm:mt-16 hover:bg-red-700 focus:bg-red-700">
                        Ver calificaciones
                        <svg class="w-6 h-6 ml-8 -mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </a>
                @elseif(Auth::user()->estudiante == null)
                <a href="{{ route('userEstudiante') }}"
                    class="inline-flex items-center px-6 py-4 mt-8 font-semibold text-white transition-all duration-200 bg-red-600 rounded-lg sm:mt-16 hover:bg-red-700 focus:bg-red-700">
                    Registrar tus datos de estudiante
                    <svg class="w-6 h-6 ml-8 -mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </a>
                @else
                    <button
                        class="inline-flex items-center px-6 py-4 mt-8 font-semibold text-white transition-all duration-200 bg-red-600 rounded-lg sm:mt-16 hover:bg-red-700 focus:bg-red-700">
                        Esperando matricula
                       <!-- <svg class="w-6 h-6 ml-8 -mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg> -->
                    </button>
                @endif

            </div>
        </div>
    </section>

