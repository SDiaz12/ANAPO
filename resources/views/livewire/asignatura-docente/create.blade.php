<div class="fixed z-50 inset-0 overflow-y-auto ease-out duration-300">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

        <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full dark:bg-gray-800">
            <div class="flex justify-between items-center p-4 mb-2 rounded-t border-b border-gray-300 dark:border-gray-600 bg-blue-50 dark:bg-gray-800">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Asignación de Asignaturas a Docente</h3>
                <button wire:click="closeModal()" type="button"
                    class="text-gray-800 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-400 p-2 rounded-lg focus:outline-none">
                    <svg aria-hidden="true" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>


            <form class="p-6">
               
                <div class="mb-5">
                    <label for="id_docente" class="block text-base font-medium text-gray-900 dark:text-gray-300">Docente:</label>
                    <input wire:model.live="inputSearchdocente" type="text" id="id_docente"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 py-3 px-4 text-gray-900 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Buscar docente..." />
                    @if($searchdocente)
                        <ul class="mt-2 max-h-40 overflow-y-auto bg-white border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600">
                            @foreach($searchdocente as $docente)
                                <li wire:click="selectdocente({{ $docente->id }})"
                                    class="px-4 py-2 cursor-pointer hover:bg-indigo-100 dark:hover:bg-gray-600">
                                    {{ $docente->nombre }} {{ $docente->apellido }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

               
                <div class="mb-5">
                    <label for="cantidad_materias" class="block text-base font-medium text-gray-900 dark:text-gray-300">¿Cuántas asignaturas asignar?</label>
                    <input wire:model.live="cantidad_materias" type="number" min="1" id="cantidad_materias"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 py-3 px-4 text-gray-900 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                </div>

                @for ($i = 0; $i < $cantidad_materias; $i++)
                    <div class="mb-5">
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="asignatura_{{ $i }}" class="block text-base font-medium text-gray-900 dark:text-gray-300">Asignatura {{ $i + 1 }}</label>
                                <select wire:model.live="selectedAsignaturas.{{ $i }}" id="asignatura_{{ $i }}"
                                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 py-3 px-4 text-gray-900 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Seleccione asignatura</option>
                                    @foreach($asignaturas as $asignatura)
                                        <option value="{{ $asignatura->id }}">{{ $asignatura->nombre }} ({{ $asignatura->programaformacion->nombre }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="periodo_{{ $i }}" class="block text-base font-medium text-gray-900 dark:text-gray-300">Periodo {{ $i + 1 }}</label>
                                <select wire:model.live="selectedPeriodos.{{ $i }}" id="periodo_{{ $i }}"
                                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 py-3 px-4 text-gray-900 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Seleccione periodo</option>
                                    @foreach($periodos as $periodo)
                                        <option value="{{ $periodo->id }}">{{ $periodo->nombre }} ({{ optional(\Carbon\Carbon::parse($periodo->fecha_inicio))->format('Y') ?? 'N/A' }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="seccion_{{ $i }}" class="block text-base font-medium text-gray-900 dark:text-gray-300">Sección {{ $i + 1 }}</label>
                                <select wire:model.live="selectedSecciones.{{ $i }}" id="seccion_{{ $i }}"
                                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 py-3 px-4 text-gray-900 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Seleccione sección</option>
                                    @foreach($secciones as $seccion)
                                        <option value="{{ $seccion->id }}">{{ $seccion->nombre }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endfor

                <div class="mt-4 flex justify-end space-x-4">
   
                    <button wire:click="closeModal" class="flex items-center text-gray-900 bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancelar
                    </button>

                
                    <button wire:click="store" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-500 transition">
                        Guardar
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
