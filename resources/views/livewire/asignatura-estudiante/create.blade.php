

<div class="fixed z-50 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full dark:bg-gray-900"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="flex justify-between items-center p-4 md:p-5 mb-1 rounded-t border-b dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $asignaturaestudiante_id ? 'Editar matricula de asignatura' : 'Matricular Asignatura' }}
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

    <form  class="p-4 md:p-5">
        <div>
            <!-- Campo: Busqueda estudiante -->
            <div class="mb-4">
                <label for="inputSearchEstudiante" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                    Estudiante:
                </label>
                <input wire:model.live="inputSearchEstudiante" type="text" id="inputSearchEstudiante"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                    placeholder="Buscar estudiante...">
                @error('inputSearchEstudiante') <span class="text-red-500">{{ $message }}</span> @enderror
        
                <!-- Desplegable de resultados de búsqueda -->
                @if(!empty($searchEstudiante))
                    <ul class="mt-2 bg-white border border-gray-300 rounded-lg shadow-lg dark:bg-gray-800">
                        @foreach($searchEstudiante as $estudiante)
                            <li wire:click="selectEstudiante({{ $estudiante->id }})"
                                class="p-2 hover:bg-gray-200 cursor-pointer dark:hover:bg-gray-600 dark:text-white">
                                {{ $estudiante->nombre }} {{ $estudiante->apellido }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
  <!-- Mensaje de error -->
  @if ($error)
  <p class="text-red-500 text-sm mt-2">{{ $error }}</p>
@endif
            <div class="mb-4">
                <label for="asignatura_id" class="block text-gray-700 text-sm font-bold mb-2 dark:text-white">
                    Asignatura
                </label>
                <select id="asignatura_id"
                    class="shadow bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                    wire:model.live="asignatura_id">
                    <option value="">Seleccione Asignatura</option>
                    @forelse($asignaturas as $asignatura)
                        <option value="{{ $asignatura->id }}">{{ $asignatura->nombre }}</option>
                    @empty
                        <option value="">No hay clases en este periodo</option>
                    @endforelse
                </select>
                @error('asignatura_id') 
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Botón de Enviar -->
        <div class="flex justify-center">
            <x-button wire:click.prevent="store()">
                {{ $asignaturaestudiante_id ? 'Editar matricula de asignatura' : 'Matricular Asignatura' }}
            </x-button>
        </div>
    </form>         
        </div>
    </div>
</div>