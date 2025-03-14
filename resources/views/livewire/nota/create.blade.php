<div>
    @if ($isOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-5xl">
                <h2 class="text-xl font-bold mb-5 text-gray-800">Agregar Notas</h2>

                <form wire:submit.prevent="store">
                    <div class="overflow-x-auto">
                        <div class="max-h-[500px] overflow-y-auto border border-gray-300 rounded-lg">
                            <table class="w-full border-collapse border border-gray-300 text-sm">
                                <thead>
                                    <tr class="bg-blue-500 text-white">
                                        
                                        <th class="border border-gray-300 px-4 py-3">Código</th>
                                        <th class="border border-gray-300 px-4 py-3">Nombre</th>
                                        <th class="border border-gray-300 px-4 py-3">Apellido</th>
                                        <th class="border border-gray-300 px-4 py-3">Asignatura Estudiante ID</th>
                                        <th class="border border-gray-300 px-4 py-3">Primer Parcial</th>
                                        <th class="border border-gray-300 px-4 py-3">Segundo Parcial</th>
                                        <th class="border border-gray-300 px-4 py-3">Tercer Parcial</th>
                                        <th class="border border-gray-300 px-4 py-3">Asistencia</th>
                                        <th class="border border-gray-300 px-4 py-3">Recuperación</th>
                                        <th class="border border-gray-300 px-4 py-3">Observación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($estudiantes && count($estudiantes) > 0)
                                        @foreach ($estudiantes as $estudiante)
                                            <tr class="hover:bg-gray-100">
                                               
                                                <td class="border border-gray-300 px-4 py-2 text-xs">{{ $estudiante['codigo'] }}</td>
                                                <td class="border border-gray-300 px-4 py-2 text-xs">{{ $estudiante['nombre'] }}</td>
                                                <td class="border border-gray-300 px-4 py-2 text-xs">{{ $estudiante['apellido'] }}</td>
                                                <td class="border border-gray-300 px-4 py-2 text-xs">
                                                    <input type="hidden" wire:model="notas.{{ $estudiante['id'] }}.asignatura_estudiante_id"
                                                        value="{{ $estudiante['asignatura_estudiante_id'] ?? '' }}">
                                                         {{ $estudiante['asignatura_estudiante_id'] ?? 'No asignado' }}
                                                    @error('notas.{{ $estudiante["id"] }}.asignatura_estudiante_id') 
                                                        <span class="text-red-500">{{ $message }}</span> 
                                                    @enderror
                                                </td>


                                                <td class="border border-gray-300 px-4 py-2">
                                                    <input type="number" wire:model="notas.{{ $estudiante['id'] }}.primerparcial" class="w-[100px] border-gray-300 rounded-md py-2 px-3 text-sm">
                                                    @error('notas.{{ $estudiante["id"] }}.primerparcial') 
                                                        <span class="text-red-500">{{ $message }}</span> 
                                                    @enderror
                                                </td>

                                                <td class="border border-gray-300 px-4 py-2">
                                                    <input type="number" wire:model="notas.{{ $estudiante['id'] }}.segundoparcial" class="w-[100px] border-gray-300 rounded-md py-2 px-3 text-sm">
                                                    @error('notas.{{ $estudiante["id"] }}.segundoparcial') 
                                                        <span class="text-red-500">{{ $message }}</span> 
                                                    @enderror
                                                </td>

                                                <td class="border border-gray-300 px-4 py-2">
                                                    <input type="number" wire:model="notas.{{ $estudiante['id'] }}.tercerparcial" class="w-[100px] border-gray-300 rounded-md py-2 px-3 text-sm">
                                                    @error('notas.{{ $estudiante["id"] }}.tercerparcial') 
                                                        <span class="text-red-500">{{ $message }}</span> 
                                                    @enderror
                                                </td>

                                                <td class="border border-gray-300 px-4 py-2">
                                                    <input type="text" wire:model="notas.{{ $estudiante['id'] }}.asistencia" class="w-[120px] border-gray-300 rounded-md py-2 px-3 text-sm">
                                                    @error('notas.{{ $estudiante["id"] }}.asistencia') 
                                                        <span class="text-red-500">{{ $message }}</span> 
                                                    @enderror
                                                </td>

                                                <td class="border border-gray-300 px-4 py-2">
                                                    <input type="number" wire:model="notas.{{ $estudiante['id'] }}.recuperacion" 
                                                        class="w-[120px] border-gray-300 rounded-md py-2 px-3 text-sm">
                                                    @error('notas.{{ $estudiante["id"] }}.recuperacion') 
                                                        <span class="text-red-500">{{ $message }}</span> 
                                                    @enderror
                                                </td>

                                                <td class="border border-gray-300 px-4 py-2">
                                                    <input type="text" wire:model="notas.{{ $estudiante['id'] }}.observacion" class="w-[150px] border-gray-300 rounded-md py-2 px-3 text-sm">
                                                    @error('notas.{{ $estudiante["id"] }}.observacion') 
                                                        <span class="text-red-500">{{ $message }}</span> 
                                                    @enderror
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center text-gray-500 py-4">No hay estudiantes disponibles.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-between mt-6">
                   
                        <button type="button" wire:click="closeModal" class="bg-gray-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-gray-700 transition duration-300 transform hover:scale-105">
                            <span class="mr-2">❌</span> Cancelar
                        </button>
                        <div>
                        <x-button wire:click.prevent="store()" wire:loading.attr="disabled" wire:target="foto" type="button" class="w-full">
                            Guardar
                        </x-button>
                    </div>
                </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
