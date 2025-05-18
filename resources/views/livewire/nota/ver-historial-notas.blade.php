<div>
    @if($showVerNotasModal)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900/50 dark:bg-gray-900/80 z-50 p-4">
            <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-xl w-full max-w-full sm:max-w-5xl max-h-[90vh] flex flex-col border border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Detalle de Notas</h2>
                    <button wire:click="closeModal" class="text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex-1 overflow-hidden">
                    <div class="h-full overflow-auto">
                        <div class="min-w-full">
                            <table class="w-full border-collapse">
                                <thead class="sticky top-0 z-10">
                                    <tr class="bg-blue-600 dark:bg-blue-800 text-white">
                                        <th class="p-3 border-b border-blue-700 dark:border-blue-900 text-xs sm:text-sm">Código</th>
                                        <th class="p-3 border-b border-blue-700 dark:border-blue-900 text-xs sm:text-sm">Nombre</th>
                                        <th class="p-3 border-b border-blue-700 dark:border-blue-900 text-xs sm:text-sm">1er Parcial</th>
                                        <th class="p-3 border-b border-blue-700 dark:border-blue-900 text-xs sm:text-sm">2do Parcial</th>
                                        <th class="p-3 border-b border-blue-700 dark:border-blue-900 text-xs sm:text-sm hidden sm:table-cell">3er Parcial</th>
                                        <th class="p-3 border-b border-blue-700 dark:border-blue-900 text-xs sm:text-sm hidden sm:table-cell">Asistencia</th>
                                        <th class="p-3 border-b border-blue-700 dark:border-blue-900 text-xs sm:text-sm hidden md:table-cell">Recuperación</th>
                                        <th class="p-3 border-b border-blue-700 dark:border-blue-900 text-xs sm:text-sm hidden md:table-cell">Observación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($estudiantes as $estudiante)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 border-b border-gray-200 dark:border-gray-700">
                                            <td class="p-3 text-xs sm:text-sm text-gray-800 dark:text-gray-200">{{ $estudiante['codigo'] }}</td>
                                            <td class="p-3 text-xs sm:text-sm text-gray-800 dark:text-gray-200">
                                                <div class="font-medium">{{ $estudiante['nombre'] }} {{ $estudiante['apellido'] }}</div>
                                                <div class="sm:hidden text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    3erP: {{ $estudiante['tercerparcial'] ?? '-' }} | 
                                                    Asist: {{ $estudiante['asistencia'] ?? '-' }}
                                                </div>
                                                <div class="sm:hidden text-xs text-gray-500 dark:text-gray-400">
                                                    Recup: {{ $estudiante['recuperacion'] ?? '-' }} | 
                                                    Obs: {{ $estudiante['observacion'] ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="p-3 text-center text-xs sm:text-sm text-gray-800 dark:text-gray-200">{{ $estudiante['primerparcial'] }}</td>
                                            <td class="p-3 text-center text-xs sm:text-sm text-gray-800 dark:text-gray-200">{{ $estudiante['segundoparcial'] ?? '-' }}</td>
                                            <td class="p-3 text-center text-xs sm:text-sm text-gray-800 dark:text-gray-200 hidden sm:table-cell">{{ $estudiante['tercerparcial'] ?? '-' }}</td>
                                            <td class="p-3 text-center text-xs sm:text-sm text-gray-800 dark:text-gray-200 hidden sm:table-cell">{{ $estudiante['asistencia'] ?? '-' }}</td>
                                            <td class="p-3 text-center text-xs sm:text-sm text-gray-800 dark:text-gray-200 hidden md:table-cell">{{ $estudiante['recuperacion'] ?? '-' }}</td>
                                            <td class="p-3 text-center text-xs sm:text-sm text-gray-800 dark:text-gray-200 hidden md:table-cell">{{ $estudiante['observacion'] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button wire:click="closeModal" class="flex items-center bg-gray-600 dark:bg-gray-700 hover:bg-gray-700 dark:hover:bg-gray-600 text-white px-4 py-2 sm:px-6 sm:py-2 rounded-lg shadow transition-colors">
                        <span class="mr-2">✕</span> Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>