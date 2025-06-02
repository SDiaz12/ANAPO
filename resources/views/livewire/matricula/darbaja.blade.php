<div>
    @if($showBajaModal)
    
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div class="fixed inset-0 bg-gray-500 dark:bg-gray-500 bg-opacity-50 dark:bg-opacity-50 transition-opacity" aria-hidden="true"></div>
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mb-4" id="modal-title">
                            Confirmar desactivación de matrícula
                        </h3>
                        <div class="mb-4">
                            <label for="motivo_estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Motivo de la baja <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="motivo_estado" id="motivo_estado" 
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm transition duration-150 ease-in-out">
                                <option value="">Seleccione un motivo</option>
                                <option value="Deserción">Deserción</option>
                                <option value="Cambio de programa">Cambio de programa</option>
                                <option value="Finalización">Finalización</option>
                                <option value="Otro">Otro</option>
                            </select>
                            @error('motivo_estado') 
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="observacion_estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Observaciones adicionales
                            </label>
                            <textarea wire:model="observacion_estado" id="observacion_estado" rows="3"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm transition duration-150 ease-in-out"></textarea>
                            @error('observacion_estado') 
                                <span class="text-red-500 text-xs mt-1 block"></span> 
                            @enderror
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="confirmarBaja" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition duration-150 ease-in-out">
                            Confirmar baja
                        </button>
                        <button wire:click="cancelarBaja" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-600 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition duration-150 ease-in-out">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>