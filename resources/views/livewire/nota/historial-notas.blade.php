<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-4 sm:p-6">
    @if($showVerNotasModal)
        @include('livewire.nota.ver-historial-notas')
    @endif
    
    @if($showGenerarCuadrosModal)
        @include('livewire.nota.generar-cuadros')
    @endif

    <nav class="flex mb-4 md:mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <div class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400">
                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Zm-1 9a1 1 0 1 0-2 0v2a1 1 0 1 0 2 0v-2Zm2-5a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1Zm4 4a1 1 0 1 0-2 0v3a1 1 0 1 0 2 0v-3Z" clip-rule="evenodd"/>
                    </svg>
                    Historial de Notas
                </div>
            </li>
        </ol>
    </nav>
    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 mb-4 shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="w-full md:w-1/3">
                <label for="periodo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Seleccionar Periodo</label>
                <select 
                    wire:model.live="periodo_id" 
                    id="periodo"
                    class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm dark:bg-gray-700 dark:text-white"
                >
                    <option value="">Todos los periodos</option>
                    @foreach($periodos as $periodo)
                        <option value="{{ $periodo->id }}">{{ $periodo->nombre }} ({{ $periodo->year ?? date('Y', strtotime($periodo->fecha_inicio)) }})</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-4">
                <button wire:click="redirectToNotas" 
                    class="inline-flex items-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                    <svg class="w-4 h-4 me-2 transform rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                        <path d="M19 0H1a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1ZM2 6v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1Zm11-3h2v2h-2V3Z"/>
                    </svg>
                    Volver a Notas
                </button>
                
                <div class="flex items-center gap-2">
                    <button wire:click="toggleViewMode"
                        class="inline-flex items-center text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 focus:outline-none hover:bg-gray-100 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 font-medium rounded-lg text-sm p-2 transition-colors"
                        type="button">
                        @if ($viewMode === 'table')
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6Zm2 8v-2h7v2H4Zm0 2v2h7v-2H4Zm9 2h7v-2h-7v2Zm7-4v-2h-7v2h7Z" clip-rule="evenodd"/>
                            </svg>  
                        @else
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M4.857 3A1.857 1.857 0 0 0 3 4.857v4.286C3 10.169 3.831 11 4.857 11h4.286A1.857 1.857 0 0 0 11 9.143V4.857A1.857 1.857 0 0 0 9.143 3H4.857Zm10 0A1.857 1.857 0 0 0 13 4.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 9.143V4.857A1.857 1.857 0 0 0 19.143 3h-4.286Zm-10 10A1.857 1.857 0 0 0 13 14.857v4.286C3 20.169 3.831 21 4.857 21h4.286A1.857 1.857 0 0 0 11 19.143v-4.286A1.857 1.857 0 0 0 9.143 13H4.857Zm10 0A1.857 1.857 0 0 0 13 14.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 19.143v-4.286A1.857 1.857 0 0 0 19.143 13h-4.286Z" clip-rule="evenodd"/>
                            </svg>  
                        @endif
                    </button>
                    
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <input wire:model.live="search" type="text" id="table-search"
                            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full sm:w-80 bg-gray-50 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500 transition-colors"
                            placeholder="Buscar asignatura">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($asignaturas->isNotEmpty())
        @if ($viewMode === 'table')
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-3 py-3 sm:px-6 sm:py-3">Código</th>
                            <th scope="col" class="px-3 py-3 sm:px-6 sm:py-3">Asignatura</th>
                            <th scope="col" class="px-3 py-3 sm:px-6 sm:py-3 hidden sm:table-cell">Periodo</th>
                            <th scope="col" class="px-3 py-3 sm:px-6 sm:py-3 hidden md:table-cell">Docente</th>
                            <th scope="col" class="px-3 py-3 sm:px-6 sm:py-3">Sección</th>
                            <th scope="col" class="px-3 py-3 sm:px-6 sm:py-3 hidden sm:table-cell">Estudiantes</th>
                            <th scope="col" class="px-3 py-3 sm:px-6 sm:py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($asignaturas as $asignatura)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                <td class="px-3 py-4 sm:px-6 sm:py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $asignatura->asignatura_codigo }}
                                </td>
                                <td class="px-3 py-4 sm:px-6 sm:py-4">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $asignatura->asignatura_nombre }}</div>
                                    <div class="sm:hidden text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        Periodo: {{ $asignatura->periodo_nombre }}
                                    </div>
                                    <div class="sm:hidden text-xs text-gray-500 dark:text-gray-400">
                                        Estudiantes: {{ $asignatura->estudiantes_count }}
                                    </div>
                                </td>
                                <td class="px-3 py-4 sm:px-6 sm:py-4 hidden sm:table-cell">
                                    {{ $asignatura->periodo_nombre }}
                                </td>
                                <td class="px-3 py-4 sm:px-6 sm:py-4 hidden md:table-cell">
                                    {{ $asignatura->docente_nombre }}
                                </td>
                                <td class="px-3 py-4 sm:px-6 sm:py-4">
                                    {{ $asignatura->seccion_nombre }}
                                </td>
                                
                                <td class="px-3 py-4 sm:px-6 sm:py-4 hidden sm:table-cell">
                                    {{ $asignatura->estudiantes_count }}
                                </td>
                                <td class="px-3 py-4 sm:px-6 sm:py-4">
                                    <div class="flex flex-col sm:flex-row sm:space-x-2 space-y-2 sm:space-y-0">
                                        <button wire:click="verNotas('{{ $asignatura->asignatura_codigo }}', '{{ $asignatura->docente_codigo }}', '{{ $asignatura->seccion_id }}')" 
                                            class="bg-green-600 text-white px-2 py-1 sm:px-3 sm:py-2 rounded-md text-xs sm:text-sm hover:bg-green-700 shadow-md transition-all duration-200 ease-in-out">
                                            📖 Ver Notas
                                        </button>
                                        <button wire:click="abrirModalGenerarCuadros('{{ $asignatura->asignatura_codigo }}', '{{ $asignatura->docente_codigo }}', '{{ $asignatura->seccion_id }}')" 
                                            class="bg-purple-600 text-white px-2 py-1 sm:px-3 sm:py-2 rounded-md text-xs sm:text-sm hover:bg-purple-700 shadow-md transition-all duration-200 ease-in-out">
                                            📊 Generar Cuadros
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($asignaturas as $asignatura)
                    <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 hover:shadow-md transition-shadow">
                        <div class="p-4 sm:p-5">
                            <div class="flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 {{ $asignatura->asignatura_docente_estado ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }} text-xl font-bold rounded-full mx-auto mb-3">
                                {{ substr($asignatura->asignatura_nombre, 0, 2) }}
                            </div>
                            
                            <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white text-center">{{ $asignatura->asignatura_nombre }}</h5>
                            
                            <div class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 space-y-1">
                                <p><span class="font-semibold">Código:</span> {{ $asignatura->asignatura_codigo }}</p>
                                <p><span class="font-semibold">Periodo:</span> {{ $asignatura->periodo_nombre }}</p>
                                <p><span class="font-semibold">Docente:</span> {{ $asignatura->docente_nombre }}</p>
                                <p><span class="font-semibold">Sección:</span> {{ $asignatura->seccion_nombre }}</p>
                                <p><span class="font-semibold">Estudiantes:</span> {{ $asignatura->estudiantes_count }}</p>
                            </div>
                            
                            <div class="mt-4 flex flex-col sm:flex-row sm:space-x-2 space-y-2 sm:space-y-0">
                                <button wire:click="verNotas('{{ $asignatura->asignatura_codigo }}', '{{ $asignatura->docente_codigo }}', '{{ $asignatura->seccion_id }}')" 
                                    class="bg-green-600 text-white px-2 py-1 sm:px-3 sm:py-2 rounded-md text-xs sm:text-sm hover:bg-green-700 shadow-md transition-all duration-200 ease-in-out">
                                    📖 Ver Notas
                                </button>
                                <button wire:click="abrirModalGenerarCuadros('{{ $asignatura->asignatura_codigo }}', '{{ $asignatura->docente_codigo }}', '{{ $asignatura->seccion_id }}')" 
                                    class="bg-purple-600 text-white px-2 py-1 sm:px-3 sm:py-2 rounded-md text-xs sm:text-sm hover:bg-purple-700 shadow-md transition-all duration-200 ease-in-out">
                                    📊 Generar Cuadros
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-4">
            {{ $asignaturas->links() }}
        </div>
    @else
        <div class="p-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
            No se encontraron asignaturas asignadas en ese periodo.
        </div>
    @endif
    @if($periodoActivo)
        <div class="p-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
            Actualmente hay un período activo. Los historiales de notas del período actual estarán disponibles una vez que el período termine.
        </div>
    @endif
</div>