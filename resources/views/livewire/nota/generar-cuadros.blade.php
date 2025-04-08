<div>
    @if($showGenerarCuadrosModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        Generar Cuadros de Notas
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input wire:model="cuadroSeleccionado" id="cuadro1" value="cuadro1" type="radio" class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300">
                            <label for="cuadro1" class="ml-3 block text-sm font-medium text-gray-700">
                                Cuadro 1 (Parciales)
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input wire:model="cuadroSeleccionado" id="cuadro_final" value="cuadro_final" type="radio" class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300">
                            <label for="cuadro_final" class="ml-3 block text-sm font-medium text-gray-700">
                                Cuadro Final (Consolidado)
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input wire:model="cuadroSeleccionado" id="boletas" value="boletas" type="radio" class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300">
                            <label for="boletas" class="ml-3 block text-sm font-medium text-gray-700">
                                Boletas (Todos estudiantes)
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input wire:model="cuadroSeleccionado" id="boletas_individuales" value="boletas_individuales" type="radio" class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300">
                            <label for="boletas_individuales" class="ml-3 block text-sm font-medium text-gray-700">
                                Boletas Individuales
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="generarCuadro" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Generar
                    </button>
                    <button wire:click="$set('showGenerarCuadrosModal', false)" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>