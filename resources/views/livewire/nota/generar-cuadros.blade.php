<div>
    @if($showGenerarCuadrosModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="w-full max-w-md mx-2 bg-white rounded-lg shadow-xl transform transition-all dark:bg-gray-800">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mb-4 text-center">
                    Generar Cuadros de Notas
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input wire:model.live="cuadroSeleccionado" id="cuadro_final" value="cuadro_final" type="radio" class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300">
                        <label for="cuadro_final" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Cuadro Consolidado
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input wire:model.live="cuadroSeleccionado" id="boletas" value="boletas" type="radio" class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300">
                        <label for="boletas" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Boletas (Todos estudiantes)
                        </label>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-b-lg px-4 py-3 flex flex-col gap-2 sm:flex-row-reverse sm:gap-0">
                <button wire:click="generarCuadro" type="button" class="w-full sm:w-auto inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:text-sm">
                    Generar
                </button>
                <button wire:click="$set('showGenerarCuadrosModal', false)" type="button" class="w-full sm:w-auto inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:text-sm dark:bg-gray-800 dark:text-gray-200">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
    @endif
</div>