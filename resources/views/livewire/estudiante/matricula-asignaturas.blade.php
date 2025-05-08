<div>
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Matricula de Asignaturas
                    </h2>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <div class="relative rounded-md shadow-sm">
                        <input 
                            wire:model.live="search" 
                            type="text" 
                            class="block w-full pr-10 sm:text-sm border-gray-300 rounded-md p-2 border" 
                            placeholder="Buscar asignaturas..."
                        >
                    </div>
                </div>
            </div>

            @if($successMessage)
                <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ $successMessage }}</span>
                </div>
            @endif

            @if($errorMessage)
                <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ $errorMessage }}</span>
                </div>
            @endif

            @if(!$matricula)
                <div class="mt-8 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                    <p class="font-bold">No tienes una matrícula activa</p>
                    <p>No puedes matricularte en asignaturas sin una matrícula activa en el sistema.</p>
                </div>
            @else
                <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse($asignaturas as $asignatura)
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
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
                                        @if($asignatura->asignatura->requisitos->count() > 0)
                                            <div class="mt-2 text-sm text-gray-500">
                                                <p class="font-medium">Requisitos:</p>
                                                <ul class="list-disc pl-5">
                                                    @foreach($asignatura->asignatura->requisitos as $requisito)
                                                        <li>{{ $requisito->codigo }} - {{ $requisito->nombre }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <button
                                        wire:click="confirmMatricula('{{ $asignatura->id }}')"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    >
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

                @if($asignaturas->hasMorePages())
                    <div class="mt-6 text-center">
                        <button
                            wire:click="loadMore"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            Cargar más asignaturas
                        </button>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Modal de confirmación -->
    @if($confirmingMatricula)
        <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div>
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Confirmar matrícula
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    ¿Estás seguro que deseas matricularte en <strong>{{ $asignaturaSeleccionada->asignatura->nombre }}</strong> con el docente <strong>{{ $asignaturaSeleccionada->docente->nombre }} {{ $asignaturaSeleccionada->docente->apellido }}</strong>?
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                        <button
                            wire:click="matricular"
                            type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:col-start-2 sm:text-sm"
                        >
                            Confirmar
                        </button>
                        <button
                            wire:click="$set('confirmingMatricula', false)"
                            type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:col-start-1 sm:text-sm"
                        >
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>