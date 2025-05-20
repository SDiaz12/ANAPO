<section class="relative lg:min-h-[580px] pt-24 pb-10 sm:pt-32 sm:pb-16 lg:pb-24">
    @if (session('message'))
        <div id="toast-message"
            class="fixed top-6 right-6 z-50 flex items-center w-auto max-w-xs p-4 mb-4 text-green-700 bg-green-100 rounded-lg shadow-lg animate-fade-in-down"
            role="alert">
            <svg class="w-6 h-6 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span class="font-medium">{{ session('message') }}</span>
            <button onclick="document.getElementById('toast-message').remove()"
                class="ml-4 text-green-700 hover:text-green-900">
                &times;
            </button>
        </div>
    @endif

    @if (session('error'))
        <div id="toast-error"
            class="fixed top-6 right-6 z-50 flex items-center w-auto max-w-xs p-4 mb-4 text-red-700 bg-red-100 rounded-lg shadow-lg animate-fade-in-down"
            role="alert">
            <svg class="w-6 h-6 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span class="font-medium">{{ session('error') }}</span>
            <button onclick="document.getElementById('toast-error').remove()" class="ml-4 text-red-700 hover:text-red-900">
                &times;
            </button>
        </div>
    @endif
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 relative z-20">

        <div class="max-w-xl mx-auto text-center">
            <h1 class="text-4xl font-bold sm:text-6xl">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-yellow-600"> Bienvenid@
                    <br><span>{{Auth::user()->name}}</span> </span>
            </h1>
            <p class="mt-5 text-base dark:text-white text-gray-800 sm:text-xl">Estás en la plataforma oficial de la
                Academia Nacional de Policias, aquí puedrás revisar tu informacion.</p>
            @if (Auth::user()->activeRole && Auth::user()->activeRole->hasPermissionTo('estudiante-admin-userestudiante'))
                @php
                    $tieneMatricula = Auth::user()->estudiante &&
                        Auth::user()->estudiante->matriculas()->exists();
                @endphp

                @if(Auth::user()->estudiante && $tieneMatricula)
                    <a href="{{ route('notasEstudiante', ['asignaturaEstudianteId' => Auth::user()->estudiante->asignaturaEstudiantes->first()->id ?? 0]) }}"
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
                        Esperando matrícula
                    </button>
                @endif
            @endif
        </div>
    </div>
    <script>
        // Desaparecer automáticamente después de 4 segundos
        setTimeout(() => {
            document.getElementById('toast-message')?.remove();
            document.getElementById('toast-error')?.remove();
        }, 4000);
    </script>

    <style>
        @keyframes fade-in-down {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.5s;
        }
    </style>
</section>