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
                    {{ $matricula_id ? 'Editar matricula' : 'Matricular estudiante' }}
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
                <div>
                    <!-- Input para el código del estudiante -->
                    <div class="mb-4">
                        <label for="DniBusqueda" class="block text-sm font-medium text-gray-700 dark:text-gray-300">DNI
                            del Estudiante</label>
                        <input type="text" id="DniBusqueda" name="DniBusqueda"
                            wire:model.live.debounce.500ms="dniBusqueda"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            placeholder="Ingrese su DNI">
                    </div>

                    <!-- Input para DNI (read-only) -->
                    @if ($codigoEstudiante)
                        <div class="mb-4">
                            <label for="CodigoEstudiante"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Código del
                                Estudiante</label>
                            <input type="text" id="CodigoEstudiante" name="CodigoEstudiante"
                                wire:model.live.debounce.500ms="codigoEstudiante"
                                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                placeholder="Ingrese su código">
                        </div>
                    @endif

                    <!-- Input oculto para ID del estudiante -->
                    <div class="mb-4 hidden">
                        <label for="estudiante_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ID
                            estudiante</label>
                        <input type="text" id="estudiante_id" name="estudiante_id" wire:model="estudiante_id" readonly
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            placeholder="DNI del estudiante">
                    </div>

                    <!-- Input para Nombre completo (read-only) -->
                    @if ($nombreCompleto)
                        <div class="mb-4">
                            <label for="nombreCompleto"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del
                                Estudiante</label>
                            <input type="text" id="nombreCompleto" name="nombreCompleto" wire:model="nombreCompleto"
                                readonly
                                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                placeholder="Nombre completo del estudiante">
                        </div>
                    @endif
                    <!-- Mensaje de error -->
                    @if ($error)
                        <p class="text-red-500 text-sm mt-2">{{ $error }}</p>
                    @endif
                </div>

                <!-- Campo: Programa de Formación -->
                <div class="mb-4">
                    <label for="programaformacion_id"
                        class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                        Programa de Formación:
                    </label>
                    <input wire:model.live="inputSearchProgramaFormacion" type="text" id="programaformacion_id"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                        placeholder="Buscar programa de formación...">
                    @error('programaformacion_id') <span class="text-red-500">{{ $message }}</span> @enderror

                    <!-- Desplegable de resultados de búsqueda -->
                    @if(!empty($searchProgramasFormacion))
                        <ul class="mt-2 bg-white border border-gray-300 rounded-lg shadow-lg dark:bg-gray-800">
                            @forelse($searchProgramasFormacion as $programa)
                                <li wire:click="selectProgramaFormacion({{ $programa->id }})"
                                    class="p-2 hover:bg-gray-200 cursor-pointer dark:hover:bg-gray-600 dark:text-white">
                                    {{ $programa->nombre }}
                                </li>
                                @empty
                                <li class="p-2 dark:text-white">No se encontró "{{ $inputSearchProgramaFormacion }}". Probablemente esté inactivo o necesitas crearlo.</li>
                            @endforelse
                        </ul>
                    @endif
                    @if ($errorUnique)
                        <p class="text-red-500 text-sm mt-2">{{ $errorUnique }}</p>
                    @endif
                </div>

                <!-- Campo: Instituto -->
                <div class="mb-4">
                    <label for="instituto"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Instituto</label>
                    <input type="text" id="instituto" name="instituto" wire:model="instituto"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                        placeholder="Instituto">
                </div>

                <!-- Botón de Enviar -->
                <div class="flex justify-center">
                    <x-button wire:click.prevent="store()">
                        {{ $matricula_id ? 'Editar matricula' : 'Matricular estudiante' }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>