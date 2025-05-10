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
                    {{ $periodo_id ? 'Editar período' : 'Crear período' }}
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
                    <div class="w-full px-3">
                        <div class="mb-5">
                            <label for="nombre" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                                Nombre:
                            </label>
                            <input type="text" name="nombre" id="nombre" wire:model="nombre" placeholder="Nombre del período"
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 p-2 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-red-500 focus:shadow-md" />
                            @error('nombre') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label for="fecha_inicio" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                                Fecha Inicio:
                            </label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" wire:model="fecha_inicio"
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 p-2 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-red-500 focus:shadow-md" />
                            @error('fecha_inicio') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label for="fecha_fin" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                                Fecha Fin:
                            </label>
                            <input type="date" name="fecha_fin" id="fecha_fin" wire:model="fecha_fin"
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 p-2 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-red-500 focus:shadow-md" />
                            @error('fecha_fin') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div>
                    <x-button wire:click.prevent="store()" type="button" class="w-full">
                        {{ $periodo_id ? 'Actualizar período' : 'Crear período' }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>