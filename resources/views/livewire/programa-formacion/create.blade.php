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
                    {{ $programaformacion_id ? 'Editar Programa Formación' : 'Crear pograma formación' }}
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
                <div class="-mx-3 flex flex-wrap">
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label for="date" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                                Código:
                            </label>
                            <input type="text" name="codigo" id="codigo" placeholder="Código de programa de formación"
                                wire:model="codigo"
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-red-600 focus:shadow-md" />
                            @error('codigo') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label for="time" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                                Nombre:
                            </label>
                            <input type="text" name="nombre" id="nombre" placeholder="Nombre del programa" wire:model="nombre"
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-red-600 focus:shadow-md" />
                            @error('nombre') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="-mx-3 flex flex-wrap">
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label for="date" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                                Fecha de aprobación:
                            </label>
                            <input type="date" name="fecha_aprobación" id="fecha_aprobación" placeholder="Fecha de aprobación"
                                wire:model="fecha_aprobación"
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-red-600 focus:shadow-md" />
                            @error('fecha_aprobación') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label for="time" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                                Fecha de finalización:
                            </label>
                            <input type="date" name="fecha_final" id="fecha_final" placeholder="fecha de finalización" wire:model="fecha_final"
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-red-600 focus:shadow-md" />
                            @error('fecha_final') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="-mx-3 flex flex-wrap">
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label for="hora_finalizacion" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                                Hora de finalización:
                            </label>
                            <input type="time" name="hora_finalizacion" id="hora_finalizacion" wire:model="hora_finalizacion"
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-red-600 focus:shadow-md" />
                            @error('hora_finalizacion') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label for="date" class="mb-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Instituto:
                            </label>
                            <input type="text" name="instituto" id="instituto" placeholder="Ingrese el instituto"
                                wire:model="instituto"
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-red-600 focus:shadow-md" />
                            @error('instituto') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="-mx-3 flex flex-wrap">
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label for="date" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                               Tipo de programa:
                            </label>
                            <input type="text" name="tipo_programa" id="tipo_programa" placeholder="Tipo de programa"
                                wire:model="tipo_programa"
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-red-600 focus:shadow-md" />
                            @error('tipo_programa') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label for="time" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                                Porcentaje de aprobación:
                            </label>
                            <input type="number" name="procentaje_aprobacion" id="procentaje_aprobacion" placeholder="procentaje_aprobacion del docente" wire:model="procentaje_aprobacion"
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-red-600 focus:shadow-md" />
                            @error('procentaje_aprobacion') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <x-button wire:click.prevent="store()" wire:loading.attr="disabled" wire:target="foto" type="button" class="mt-4 w-full">
                        {{ $programaformacion_id ? 'Editar programa' : 'Crear programa' }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>