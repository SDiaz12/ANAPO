<div>
    @if ($isOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-5xl">
                <h2 class="text-xl font-bold mb-5 text-gray-800">Agregar Notas</h2>
                <div class="mb-4">
                    <form action="{{ route('actualizarNotas') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-4">
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

                
                <form wire:submit.prevent="store">
                    <div class="overflow-x-auto">
                        <div class="max-h-[500px] overflow-y-auto border border-gray-300 rounded-lg">
                            <table class="w-full border-collapse border border-gray-300 text-sm">
                                <thead>
                                    
                                    <tr class="bg-blue-500 text-white">
                                        
                                        <th class="border border-gray-300 px-4 py-3">Código</th>
                                        <th class="border border-gray-300 px-4 py-3">Nombre</th>
                                        <th class="border border-gray-300 px-4 py-3">Primer Parcial</th>
                                        <th class="border border-gray-300 px-4 py-3">Segundo Parcial</th>
                                        <th class="border border-gray-300 px-4 py-3">Tercer Parcial</th>
                                        <th class="border border-gray-300 px-4 py-3">Asistencia</th>
                                        <th class="border border-gray-300 px-4 py-3">Recuperación</th>
                                        <th class="border border-gray-300 px-4 py-3">Observación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($estudiantes as $estudiante)
                                        <tr class="hover:bg-gray-100">
                                          
                                            <td class="border border-gray-300 px-4 py-2 text-xs">{{ $estudiante['codigo'] }}</td>
                                            <td class="border border-gray-300 px-4 py-2 text-xs">{{ $estudiante['nombre'] }} {{ $estudiante['apellido'] }}</td>
                                            
            
                                            <td class="border border-gray-300 px-4 py-2">
                                                <input type="number" 
                                                    wire:model="estudiantes.{{ $loop->index }}.primerparcial" 
                                                    class="w-[100px] border-gray-300 rounded-md py-2 px-3 text-sm" 
                                                    placeholder="Primer Parcial">
                                            </td>

                                            <td class="border border-gray-300 px-4 py-2">
                                                <input type="number" 
                                                    wire:model="estudiantes.{{ $loop->index }}.segundoparcial" 
                                                    class="w-[100px] border-gray-300 rounded-md py-2 px-3 text-sm" 
                                                    placeholder="Segundo Parcial">
                                            </td>

                                            <td class="border border-gray-300 px-4 py-2">
                                                <input type="number" 
                                                    wire:model="estudiantes.{{ $loop->index }}.tercerparcial" 
                                                    class="w-[100px] border-gray-300 rounded-md py-2 px-3 text-sm" 
                                                    placeholder="Tercer Parcial">
                                            </td>

                                           
                                            <td class="border border-gray-300 px-4 py-2">
                                                <input type="text" 
                                                    wire:model="estudiantes.{{ $loop->index }}.asistencia" 
                                                    class="w-[100px] border-gray-300 rounded-md py-2 px-3 text-sm" 
                                                    placeholder="Asistencia">
                                            </td>

                                            <td class="border border-gray-300 px-4 py-2">
                                                <input type="number" 
                                                    wire:model="estudiantes.{{ $loop->index }}.recuperacion" 
                                                    class="w-[100px] border-gray-300 rounded-md py-2 px-3 text-sm" 
                                                    placeholder="Recuperación">
                                            </td>

                                            <td class="border border-gray-300 px-4 py-2">
                                                <input type="text" 
                                                    wire:model="estudiantes.{{ $loop->index }}.observacion" 
                                                    class="w-[150px] border-gray-300 rounded-md py-2 px-3 text-sm" 
                                                    placeholder="Observación">
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>


                            </table>
                        </div>
                    </div>

                    <div class="flex justify-between mt-6">
                   
                        <button type="button" wire:click="closeModal" class="bg-gray-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-gray-700 transition duration-300 transform hover:scale-105">
                            <span class="mr-2">❌</span> Cancelar
                        </button>
                        <div>
                        <button type="submit" 
                            class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 transition duration-300 transform hover:scale-105">
                            💾 Guardar
                        </button>
                    </div>
                </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
