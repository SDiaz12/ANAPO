<div class="fixed z-50 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

       
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full dark:bg-gray-900"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">

         
            <div class="flex justify-between items-center p-4 md:p-5 mb-1 rounded-t border-b dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $promocion_id ? 'Editar Promoción' : 'Crear Promoción' }}
                </h3>
                <button wire:click="closeModal()" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>

            <form wire:submit.prevent="store" class="p-4 md:p-5 space-y-4">

                <div class="mb-5">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre de la Promoción:</label>
                    <input type="text" id="nombre" wire:model="nombre" placeholder="Ingrese el nombre"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-2 px-4 text-sm font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-5">
                    <label for="inputSearchEstudiante" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estudiante:</label>
                    <input type="text" id="inputSearchEstudiante" wire:model.live="inputSearchEstudiante" placeholder="Buscar estudiante"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-2 px-4 text-sm font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @if(!empty($searchEstudiantes))
                        <ul class="mt-2 bg-white dark:bg-gray-700 border rounded-md">
                            @foreach($searchEstudiantes as $estudiante)
                                <li wire:click="selectEstudiante({{ $estudiante->id }})"
                                    class="px-4 py-2 cursor-pointer hover:bg-red-200 dark:hover:bg-red-600 dark:text-gray-300">
                                    {{ $estudiante->nombre }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @error('estudiante_id') <span class="text-red-500 text-sm"></span> @enderror
                </div>

                <div class="mb-5">
                    <label for="inputSearchPeriodo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Periodo:</label>
                    <input type="text" id="inputSearchPeriodo" wire:model.live="inputSearchPeriodo" placeholder="Buscar Periodo"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-2 px-4 text-sm font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @if(!empty($searchPeriodos))
                        <ul class="mt-2 bg-white dark:bg-gray-700 border rounded-md">
                            @foreach($searchPeriodos as $periodo)
                                <li wire:click="selectPeriodo({{ $periodo->id }})"
                                    class="px-4 py-2 cursor-pointer hover:bg-red-200 dark:hover:bg-red-600 dark:text-gray-300">
                                    {{ $periodo->nombre }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @error('periodo_id') <span class="text-red-500 text-sm"></span> @enderror
                </div>

              
                <div class="mb-5">
                    <label for="inputSearchProgramaFormacion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Programa de Formación:</label>
                    <input type="text" id="inputSearchProgramaFormacion" wire:model.live="inputSearchProgramaFormacion" placeholder="Buscar programa de formación"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-2 px-4 text-sm font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @if(!empty($searchProgramasFormacion))
                        <ul class="mt-2 bg-white dark:bg-gray-700 border rounded-md">
                            @foreach($searchProgramasFormacion as $programa)
                                <li wire:click="selectProgramaFormacion({{ $programa->id }})"
                                    class="px-4 py-2 cursor-pointer hover:bg-red-200 dark:hover:bg-red-600 dark:text-gray-300">
                                    {{ $programa->nombre }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @error('programaformacion_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-5">
                    <label for="nivel_anterior" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nivel Anterior:</label>
                    <input type="text" id="nivel_anterior" wire:model.live="nivel_anterior" placeholder="Ingrese el nivel anterior"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-2 px-4 text-sm font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('nivel_anterior') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-5">
                    <label for="nivel_actual" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nivel Actual:</label>
                    <input type="text" id="nivel_actual" wire:model.live="nivel_actual" placeholder="Ingrese el nivel actual"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-2 px-4 text-sm font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('nivel_actual') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-5">
                    <label for="fecha_promocion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Promoción:</label>
                    <input type="date" id="fecha_promocion" wire:model="fecha_promocion"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-2 px-4 text-sm font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('fecha_promocion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-end p-6 space-x-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" wire:click="closeModal"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:ring-2 focus:ring-gray-400 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 dark:focus:ring-gray-500">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-400 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-700">
                        {{ $promocion_id ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>