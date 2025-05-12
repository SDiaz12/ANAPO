<div>
    <nav class="flex mb-2" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <div class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400">
                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z"
                            clip-rule="evenodd" />
                    </svg>
                    Matricula
                </div>
            </li>
        </ol>
    </nav>
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-300">Asignaturas disponibles</h3>
                </div>
                <div class="mt-1 sm:mt-0 sm:ml-16 sm:flex-none">
                    <div class="relative rounded-md shadow-sm">
                        <input wire:model.live="search" type="text"
                            class="block w-full pr-10 sm:text-sm dark:border-gray-600 border-gray-300 dark:text-gray-300 dark:bg-gray-700 rounded-md p-2 border"
                            placeholder="Buscar asignaturas...">
                    </div>
                </div>
            </div>

            @if($successMessage)
                <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ $successMessage }}</span>
                </div>
            @endif

            @if($errorMessage)
                <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ $errorMessage }}</span>
                </div>
            @endif

            @if(!$matricula)
                <div class="mt-8 bg-white dark:bg-gray-800 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                    <p class="font-bold">No tienes una matrícula activa</p>
                    <p>No puedes matricularte en asignaturas sin una matrícula activa en el sistema.</p>
                </div>
            @else

                @if(!$mostrarAsignaturas)
                    <div
                        class="col-span-3 bg-white dark:bg-gray-800 dark:border-gray-300 overflow-hidden shadow rounded-lg mt-4">
                        <div class="px-4 py-5 sm:p-6 text-center">
                            <p class="text-gray-600 dark:text-gray-400">
                                @if($FechaActual >= $periodoActivo->fecha_inicio)
                                    El período de adición de asignaturas ha finalizado
                                @else
                                    El período de matrícula aún no está disponible.
                                @endif
                            </p>
                        </div>
                    </div>
                @else
                    <div class="mt-2 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @forelse($asignaturas as $asignatura)
                            <div class="bg-white overflow-hidden shadow rounded-lg">
                                <div class="px-4 py-5 sm:p-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-red-700 rounded-md p-3">
                                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 truncate">
                                                    {{ $asignatura->asignatura->codigo }}
                                                </dt>
                                                <dt class="text-sm font-medium text-gray-500 truncate">
                                                    {{ $asignatura->seccion->nombre }}
                                                </dt>
                                                <dd class="flex items-baseline">
                                                    <div class="text-lg font-semibold text-gray-900">
                                                        {{ $asignatura->asignatura->nombre }}
                                                    </div>
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <div class="border-t border-gray-200 pt-4">
                                            <div class="text-sm text-gray-500">
                                                <p class="font-medium">Docente:</p>
                                                <p>{{ $asignatura->docente->nombre }} {{ $asignatura->docente->apellido }}</p>
                                            </div>
                                            <div class="mt-2 text-sm text-gray-500">
                                                <p class="font-medium">Créditos:</p>
                                                <p>{{ $asignatura->asignatura->creditos }}</p>
                                            </div>
                                            <div class="mt-2 text-sm text-gray-500">
                                                <p class="font-medium">Horas:</p>
                                                <p>{{ $asignatura->asignatura->horas }}</p>
                                            </div>
                                            <div class="mt-2 text-sm text-gray-500">
                                                <p class="font-medium">Periodo:</p>
                                                <p>{{ $asignatura->periodo->nombre }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5">
                                        <button wire:click="confirmMatricula('{{ $asignatura->id }}')"
                                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Matricular
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 bg-white overflow-hidden shadow rounded-lg">
                                <div class="px-4 py-5 sm:p-6 text-center">
                                    <p class="text-gray-500">No hay asignaturas disponibles para matricular en este período.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                @endif
            @endif
        </div>

        @if($matriculadas->isNotEmpty())
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-300 mb-4">Asignaturas Matriculadas</h3>
                <div class="relative overflow-x-auto scrollbar-hidden bg-white rounded-lg dark:bg-gray-800 items-center justify-between">
                    <table class="min-w-full w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Código
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Asignatura
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Docente
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Período
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Sección
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($matriculadas as $matriculada)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $matriculada->asignaturadocente->asignatura->codigo ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $matriculada->asignaturadocente->asignatura->nombre ?? 'N/A'}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $matriculada->asignaturadocente->docente->nombre ?? 'N/A'}}
                                        {{ $matriculada->asignaturadocente->docente->apellido ?? 'N/A'}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $matriculada->asignaturadocente->periodo->nombre ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $matriculada->asignaturadocente->seccion->nombre ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($matriculada->notas)
                                            <a
                                                href="{{ route('notasEstudiante', ['asignaturaEstudianteId' => $matriculada->id]) }}">
                                                <button
                                                    class="inline-flex items-center px-4 py-2 border border-yellow-300 text-sm font-medium rounded-md text-yellow-500 bg-yellow-100">
                                                    <span> Calificada</span>
                                                </button>
                                            </a>
                                        @else
                                            @if($mostrarAsignaturas)
                                                <button wire:click="quitarAsignatura('{{ $matriculada->id }}')"
                                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    Quitar
                                                </button>
                                            @else
                                                <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd"
                                                        d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal de confirmación -->
    @if($confirmingMatricula)
        <div class="fixed z-50 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div>
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Confirmar matrícula
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    ¿Estás seguro que deseas matricularte en
                                    <strong>{{ $asignaturaSeleccionada->asignatura->nombre }}</strong> con el docente
                                    <strong>{{ $asignaturaSeleccionada->docente->nombre }}
                                        {{ $asignaturaSeleccionada->docente->apellido }}</strong>?
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                        <button wire:click="matricular" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:col-start-2 sm:text-sm">
                            Confirmar
                        </button>
                        <button wire:click="$set('confirmingMatricula', false)" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>