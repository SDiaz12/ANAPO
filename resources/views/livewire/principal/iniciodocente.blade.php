<div class="space-y-6">
    <h5 class="text-xl font-semibold text-gray-900 dark:text-white">Tus Clases Asignadas</h5>

    <!-- Clases actuales -->
    <div class="p-5 border border-gray-100 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Período Actual</h2>
        
        @if(count($clasesActuales) > 0)
            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead class="text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left">Asignatura</th>
                            <th scope="col" class="px-6 py-3 text-left">Código</th>
                            <th scope="col" class="px-6 py-3 text-left">Período</th>
                            <th scope="col" class="px-6 py-3 text-left">Sección</th>
                            <th scope="col" class="px-6 py-3 text-left">Estudiantes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clasesActuales as $clase)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $clase->asignatura->nombre }}
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                    {{ $clase->asignatura->codigo }}
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                    {{ $clase->periodo->nombre }}
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                    {{ $clase->seccion->nombre }}
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                    {{ $clase->estudiantes_count ?? 0 }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-700 dark:text-blue-400" role="alert">
                No tienes asignaturas asignadas en el período actual.
            </div>
        @endif
    </div>

    <!-- Clases históricas -->
    <div class="p-5 border border-gray-100 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Períodos Anteriores</h2>
        
        @if(count($clasesHistoricas) > 0)
            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead class="text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left">Asignatura</th>
                            <th scope="col" class="px-6 py-3 text-left">Código</th>
                            <th scope="col" class="px-6 py-3 text-left">Período</th>
                            <th scope="col" class="px-6 py-3 text-left">Sección</th>
                            <th scope="col" class="px-6 py-3 text-left">Año</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clasesHistoricas as $clase)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $clase->asignatura->nombre }}
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                    {{ $clase->asignatura->codigo }}
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                    {{ $clase->periodo->nombre }}
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                    {{ $clase->seccion->nombre }}
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($clase->periodo->fecha_inicio)->format('Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-4 text-sm text-gray-500 rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-gray-400" role="alert">
                No tienes asignaturas de períodos anteriores.
            </div>
        @endif
    </div>
</div>