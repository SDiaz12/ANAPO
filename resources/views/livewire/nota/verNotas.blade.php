<div>
     <style>
        /* Estilo para navegadores modernos */
        .barra::-webkit-scrollbar {
            width: 8px;
            /* Ancho de la barra de desplazamiento */
        }

        .barra::-webkit-scrollbar-thumb {
            background-color: #d4d3d3;
            /* Color rojo */
            border-radius: 10px;
            /* Bordes redondeados */
        }

        .barra::-webkit-scrollbar-thumb:hover {
            background-color: #c5c3c3;
            /* Color gris más oscuro al pasar el mouse */
        }

        .barra::-webkit-scrollbar-track {
            background-color: #ffffff;
            /* Color del fondo de la barra */
            border-radius: 10px;
        }

        /* Para navegadores que soportan scrollbar-color */
        .barra {
            scrollbar-color: #d4d3d3 #ffffff;
            /* Color del pulgar y del fondo */
            scrollbar-width: thin;
            /* Barra más delgada */
        }

        .dark\:barra:is(.dark *) {
            scrollbar-color: #707070 #1f2937;
        }
        
        /* Estilo para el toggle switch */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 24px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .toggle-slider {
            background-color: #2196F3;
        }
        
        input:checked + .toggle-slider:before {
            transform: translateX(24px);
        }
    </style>
    @if ($showVerNotasModal)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
            <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-lg w-full max-w-5xl mx-2 sm:mx-0">
                <h2 class="text-lg sm:text-xl font-bold mb-5 text-gray-800 dark:text-gray-200">Ver Notas</h2>

                <div class="mb-4">
                    <form action="{{ route('actualizarNotas') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-4">
                        @csrf
                        <input 
                            type="file" 
                            name="file" 
                            accept=".xlsx,.xls,.csv" 
                            required 
                            class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:border file:rounded-lg file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        >
                        <button 
                            type="submit" 
                            class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-600 transition duration-200 text-sm font-semibold"
                        >
                            📤 Actualizar Notas Estudiantes
                        </button>
                    </form>
                </div>

                <form wire:submit.prevent="storeEditar">
                    <!-- Toggle switch para tercer parcial -->
                    <div class="flex items-center justify-end mb-4">
                        <span class="mr-2 text-sm text-gray-700 dark:text-gray-300">Calificar tres parciales:</span>
                        <label class="toggle-switch">
                            <input type="checkbox" wire:model.live="mostrarTercerParcial" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <div class="max-h-[400px] barra overflow-y-auto border border-gray-300 rounded-lg">
                            <table class="w-full border-collapse border border-gray-300 text-xs sm:text-sm">
                                <thead>
                                    <tr class="bg-blue-500 text-white">
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2 sm:py-3">Código</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2 sm:py-3">Nombre</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2 sm:py-3">Primer Parcial</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2 sm:py-3">Segundo Parcial</th>
                                        @if($mostrarTercerParcial)
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2 sm:py-3">Tercer Parcial</th>
                                        @endif
                                      <!--  <th class="border border-gray-300 px-2 sm:px-4 py-2 sm:py-3">Asistencia</th>-->
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2 sm:py-3">Recuperación</th>
                                        <th class="border border-gray-300 px-2 sm:px-4 py-2 sm:py-3">Observación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($estudiantes as $estudiante)
                                        <tr class="hover:bg-gray-100 bg-gray-100">
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">{{ $estudiante['codigo'] }}</td>
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">{{ $estudiante['nombre'] }} {{ $estudiante['apellido'] }}</td>
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">
                                                <input type="number" 
                                                    wire:model="estudiantes.{{ $loop->index }}.primerparcial" 
                                                    class="w-full sm:w-[100px] border-gray-300 rounded-md py-2 px-2 sm:px-3 text-xs sm:text-sm" 
                                                    placeholder="Primer Parcial">
                                            </td>
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">
                                                <input type="number" 
                                                    wire:model="estudiantes.{{ $loop->index }}.segundoparcial" 
                                                    class="w-full sm:w-[100px] border-gray-300 rounded-md py-2 px-2 sm:px-3 text-xs sm:text-sm" 
                                                    placeholder="Segundo Parcial">
                                            </td>
                                            @if($mostrarTercerParcial)
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">
                                                <input type="number" 
                                                    wire:model="estudiantes.{{ $loop->index }}.tercerparcial" 
                                                    class="w-full sm:w-[100px] border-gray-300 rounded-md py-2 px-2 sm:px-3 text-xs sm:text-sm" 
                                                    placeholder="Tercer Parcial">
                                            </td>
                                            @endif
                                           <!-- <td class="border border-gray-300 px-2 sm:px-4 py-2">
                                                <input type="text" 
                                                    wire:model="estudiantes.{{ $loop->index }}.asistencia" 
                                                    class="w-full sm:w-[100px] border-gray-300 rounded-md py-2 px-2 sm:px-3 text-xs sm:text-sm" 
                                                    placeholder="Asistencia">
                                            </td>-->
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">
                                                <input type="number" 
                                                    wire:model="estudiantes.{{ $loop->index }}.recuperacion" 
                                                    class="w-full sm:w-[100px] border-gray-300 rounded-md py-2 px-2 sm:px-3 text-xs sm:text-sm" 
                                                    placeholder="Recuperación">
                                            </td>
                                            <td class="border border-gray-300 px-2 sm:px-4 py-2">
                                                <input type="text" 
                                                    wire:model="estudiantes.{{ $loop->index }}.observacion" 
                                                    class="w-full sm:w-[150px] border-gray-300 rounded-md py-2 px-2 sm:px-3 text-xs sm:text-sm" 
                                                    placeholder="Observación">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between mt-6 gap-2">
                        <button type="button" wire:click="closeModal" class="bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-900 hover:bg-gray-900 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                        Cancelar
                        </button>
                        <button type="submit" 
                            class="bg-red-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow-md hover:bg-red-700 transition duration-300 transform hover:scale-105">
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>