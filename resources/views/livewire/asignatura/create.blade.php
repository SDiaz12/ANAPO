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
                    {{ $asignatura_id ? 'Editar asignatura' : 'Crear asignatura' }}
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

            <form class="p-4 md:p-5">
                <div class="mb-5">
                    <label for="codigo" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                        Código de la asignatura:
                    </label>
                    <input type="text" name="codigo" id="codigo" placeholder="Código de la asignatura"
                        wire:model="codigo"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('codigo') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-5">
                    <label for="nombre" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                        Nombre de la asignatura:
                    </label>
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre de la asignatura"
                        wire:model="nombre"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('nombre') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-5">
                    <label for="descripcion" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                        Descripción:
                    </label>
                    <textarea type="text" name="descripcion" id="descripcion" placeholder="Descripción de la asignatura"
                        wire:model="descripcion"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md"></textarea>
                    @error('descripcion') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-5">
                    <label for="creditos" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                        Créditos:
                    </label>
                    <input type="number" name="creditos" id="creditos" placeholder="Número de créditos"
                        wire:model="creditos"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('creditos') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-5">
                    <label for="horas" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                        Horas:
                    </label>
                    <input type="number" name="horas" id="horas" placeholder="Número de horas"
                        wire:model="horas"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('horas') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

        
                <div class="mb-5">
                    <label for="programa_formacion_id" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                        Programa de Formación:
                    </label>
                    <input wire:model.live="inputSearchProgramaFormacion" type="text" id="programa_formacion_id"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md"
                        placeholder="Buscar programa de formación...">
                    @error('programa_formacion_id') <span class="text-red-500">{{ $message }}</span> @enderror

                    @if(!empty($searchProgramasFormacion))
                        <ul class="mt-2 bg-white border border-gray-300 rounded-lg shadow-lg dark:bg-gray-800">
                            @foreach($searchProgramasFormacion as $programa)
                                <li wire:click="selectProgramaFormacion({{ $programa->id }})"
                                    class="p-2 hover:bg-gray-200 cursor-pointer dark:hover:bg-gray-600 dark:text-white">
                                    {{ $programa->nombre }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                
                <div class="mb-5">
                    <label for="tiene_requisitos" class="flex items-center mb-3 text-base font-medium text-gray-700 dark:text-gray-300">
                        <input type="checkbox" id="tiene_requisitos" wire:model.live="tiene_requisitos" class="mr-2"> 
                        Requisitos
                        @if($tiene_requisitos && $cantidad_requisitos > 0)
                            <button wire:click="clearAllRequisitos" type="button" class="ml-2 text-red-600 text-sm">
                                (Eliminar todos)
                            </button>
                        @endif
                    </label>

                    @if($tiene_requisitos)
                        <div class="mb-5">
                            <label for="cantidad_requisitos" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                                Cantidad de requisitos:
                            </label>
                            <input type="number" id="cantidad_requisitos" wire:model.live="cantidad_requisitos"
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md"
                                placeholder="Cantidad de requisitos" min="1" max="3">
                            @error('cantidad_requisitos') <span class="text-red-500"></span> @enderror
                            @if($cantidad_requisitos > 3)
                                <p class="text-red-500">No puedes ingresar más de 3 requisitos.</p>
                            @endif
                        </div>

                        @if($cantidad_requisitos <= 3)
                            @for($i = 0; $i < $cantidad_requisitos; $i++)
                                <div class="grid grid-cols-3 gap-4 mt-4">
                                    <div class="col-span-2">
                                        <label for="RequisitoSelect_{{$i}}" class="block text-gray-700 text-sm font-bold mb-2 dark:text-white">
                                            Requisito #{{$i + 1}}:
                                        </label>
                                        <select id="RequisitoSelect_{{$i}}"
                                            class="shadow bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                                            wire:model.live="requisitos.{{$i}}">
                                            <option value="">Seleccione Requisito</option>
                                            @foreach($asignaturas as $asignatura)
                                                @if($asignatura->id != $asignatura_id) {{-- Excluir la asignatura actual --}}
                                                    <option value="{{ $asignatura->id }}" 
                                                        @if(isset($requisitos[$i]) && $requisitos[$i] == $asignatura->id) selected @endif>
                                                        {{ $asignatura->nombre }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('requisitos.{{$i}}') 
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="flex items-end">
                                        @if(isset($requisitos[$i]) && $requisitos[$i])
                                            <button wire:click="removeRequisito({{ $i }})" type="button" 
                                                class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800">
                                                Eliminar
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endfor
                        @endif
                    @endif
                </div>
                <div>
                    <x-button wire:click.prevent="store()" wire:loading.attr="disabled" wire:target="foto" type="button" class="w-full">
                        {{ $asignatura_id ? 'Editar asignatura' : 'Crear asignatura' }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
