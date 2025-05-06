<div class="fixed z-50 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full dark:bg-gray-900"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="flex justify-between items-center p-4 md:p-5 mb-1 rounded-t border-b dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $asignaturaestudiante_id ? 'Editar matrícula' : 'Matricular estudiante' }}
                </h3>
                <button wire:click="closeModal()" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <form class="p-4 md:p-5">
                <!-- Buscador de Estudiante -->
                <div class="mb-4">
                    <label for="inputSearchEstudiante" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Buscar Estudiante
                    </label>
                    <input wire:model.live="inputSearchEstudiante" type="text" id="inputSearchEstudiante"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                        placeholder="Nombre, apellido o código del estudiante">
                    
                    @if(!empty($searchEstudiante))
                        <ul class="mt-2 bg-white border border-gray-300 rounded-lg shadow-lg dark:bg-gray-800">
                            @forelse($searchEstudiante as $matricula)
                                <li wire:click="selectEstudiante({{ $matricula->id }})"
                                    class="p-2 hover:bg-gray-200 cursor-pointer dark:hover:bg-gray-600 dark:text-white">
                                    {{ $matricula->estudiante->nombre }} {{ $matricula->estudiante->apellido }} - {{ $matricula->estudiante->dni }}- {{ $matricula->programaformacion->nombre }}
                                </li>
                            @empty
                                <li class="p-2 dark:text-white">No se encontraron estudiantes</li>
                            @endforelse
                        </ul>
                    @endif
                </div>

                <!-- Buscador de Asignatura -->
                <div class="mb-4">
                    <label for="inputSearchAsignatura" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Buscar Asignatura
                    </label>
                    <input wire:model.live="inputSearchAsignatura" type="text" id="inputSearchAsignatura"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                        placeholder="Nombre o código de la asignatura"
                        {{ !$matricula_id ? 'disabled' : '' }}>
                    
                    @if(!empty($searchAsignatura))
                        <ul class="mt-2 bg-white border border-gray-300 rounded-lg shadow-lg dark:bg-gray-800">
                            @forelse($searchAsignatura as $asignaturaDocente)
                                <li wire:click="selectAsignatura({{ $asignaturaDocente->id }})"
                                    class="p-2 hover:bg-gray-200 cursor-pointer dark:hover:bg-gray-600 dark:text-white">
                                    {{ $asignaturaDocente->asignatura->nombre }} ({{ $asignaturaDocente->asignatura->codigo }}) - {{ $asignaturaDocente->docente->nombre }}- {{ $asignaturaDocente->asignatura->programaformacion->nombre }}
                                </li>
                            @empty
                                <li class="p-2 dark:text-white">No se encontraron asignaturas</li>
                            @endforelse
                        </ul>
                    @endif
                </div>

                <!-- Estado -->
                <div class="mb-4">
                    <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Estado
                    </label>
                    <select wire:model="estado" id="estado"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>

                <!-- Mensaje de error -->
                @if ($error)
                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ $error }}
                    </div>
                @endif

                <!-- Botón de Enviar -->
                <div class="flex justify-center">
                    <x-button wire:click.prevent="store()">
                        {{ $asignaturaestudiante_id ? 'Actualizar matrícula' : 'Crear matrícula' }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>