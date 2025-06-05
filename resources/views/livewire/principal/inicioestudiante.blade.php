<div>
   
    <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 bg-gray-100 dark:bg-gray-900 pb-1">
    
        <div class="relative flex items-center p-6 rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-blue-100 dark:bg-blue-700">
                <svg class="w-8 h-8 text-blue-600 dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.4472 2.10557c-.2815-.14076-.6129-.14076-.8944 0L5.90482 4.92956l.37762.11119c.01131.00333.02257.00687.03376.0106L12 6.94594l5.6808-1.89361.3927-.13363-5.6263-2.81313ZM5 10V6.74803l.70053.20628L7 7.38747V10c0 .5523-.44772 1-1 1s-1-.4477-1-1Zm3-1c0-.42413.06601-.83285.18832-1.21643l3.49538 1.16514c.2053.06842.4272.06842.6325 0l3.4955-1.16514C15.934 8.16715 16 8.57587 16 9c0 2.2091-1.7909 4-4 4-2.20914 0-4-1.7909-4-4Z"/>
                    <path d="M14.2996 13.2767c.2332-.2289.5636-.3294.8847-.2692C17.379 13.4191 19 15.4884 19 17.6488v2.1525c0 1.2289-1.0315 2.1428-2.2 2.1428H7.2c-1.16849 0-2.2-.9139-2.2-2.1428v-2.1525c0-2.1409 1.59079-4.1893 3.75163-4.6288.32214-.0655.65589.0315.89274.2595l2.34883 2.2606 2.3064-2.2634Z"/>
                </svg>
            </div>
            <div class="ml-5">
                <p class="text-base font-medium text-gray-600 dark:text-gray-400">Promedio Global</p>
                <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $promedioGlobal }}%</h4>
            </div>
        </div>
        <div class="relative flex items-center p-6 rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-green-100 dark:bg-green-700">
                <svg class="w-8 h-8 text-green-600 dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 6c0-1.65685 1.3431-3 3-3s3 1.34315 3 3-1.3431 3-3 3-3-1.34315-3-3Zm2 3.62992c-.1263-.04413-.25-.08799-.3721-.13131-1.33928-.47482-2.49256-.88372-4.77995-.8482C4.84875 8.66593 4 9.46413 4 10.5v7.2884c0 1.0878.91948 1.8747 1.92888 1.8616 1.283-.0168 2.04625.1322 2.79671.3587.29285.0883.57733.1863.90372.2987l.00249.0008c.11983.0413.24534.0845.379.1299.2989.1015.6242.2088.9892.3185V9.62992Zm2-.00374V20.7551c.5531-.1678 1.0379-.3374 1.4545-.4832.2956-.1034.5575-.1951.7846-.2653.7257-.2245 1.4655-.3734 2.7479-.3566.5019.0065.9806-.1791 1.3407-.4788.3618-.3011.6723-.781.6723-1.3828V10.5c0-.58114-.2923-1.05022-.6377-1.3503-.3441-.29904-.8047-.49168-1.2944-.49929-2.2667-.0352-3.386.36906-4.6847.83812-.1256.04539-.253.09138-.3832.13765Z"/>
                </svg>
            </div>
            <div class="ml-5">
                <p class="text-base font-medium text-gray-600 dark:text-gray-400">Progreso Programa</p>
                <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $progresoPrograma }}%</h4>
            </div>
        </div>
        <div class="relative flex items-center p-6 rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-purple-100 dark:bg-purple-700">
                <svg class="w-8 h-8 text-purple-600 dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.8638 3.49613C12.6846 3.18891 12.3557 3 12 3s-.6846.18891-.8638.49613l-3.49998 6c-.18042.30929-.1817.69147-.00336 1.00197S8.14193 11 8.5 11h7c.3581 0 .6888-.1914.8671-.5019.1784-.3105.1771-.69268-.0033-1.00197l-3.5-6ZM4 13c-.55228 0-1 .4477-1 1v6c0 .5523.44772 1 1 1h6c.5523 0 1-.4477 1-1v-6c0-.5523-.4477-1-1-1H4Zm12.5-1c-2.4853 0-4.5 2.0147-4.5 4.5s2.0147 4.5 4.5 4.5 4.5-2.0147 4.5-4.5-2.0147-4.5-4.5-4.5Z"/>
                </svg>
            </div>
            <div class="ml-5">
                <p class="text-base font-medium text-gray-600 dark:text-gray-400">Asignaturas</p>
                <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $asignaturasAprobadas }}/{{ $asignaturasTotales }}</h4>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
    
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-800">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Asignaturas Actuales</h3>
            <div class="space-y-4">
                @forelse($asignaturasActuales as $asignatura)
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-b-0">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium text-gray-800 dark:text-white">{{ $asignatura->asignaturadocente->asignatura->nombre }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Prof: {{ $asignatura->asignaturadocente->docente->nombre }}</p>
                        </div>
                        @if($asignatura->nota)
                        <span class="px-2 py-1 text-sm rounded-full 
                            @if($asignatura->promedio_calculado >= 70) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            @elseif($asignatura->promedio_calculado >= 60) bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                            {{ $asignatura->promedio_calculado }}%
                        </span>
                        @else
                        <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                            Sin notas
                        </span>
                        @endif
                    </div>
                    @if($asignatura->nota)
                    <div class="mt-2 grid grid-cols-3 gap-2 text-sm">
                        <span class="text-gray-500 dark:text-gray-400">P1: {{ $asignatura->nota->primerparcial }}</span>
                        <span class="text-gray-500 dark:text-gray-400">P2: {{ $asignatura->nota->segundoparcial }}</span>
                        @if($asignatura->asignaturadocente->mostrarTercerParcial)
                        <span class="text-gray-500 dark:text-gray-400">P3: {{ $asignatura->nota->tercerparcial }}</span>
                        @endif
                        @if($asignatura->nota->recuperacion > 0)
                        <span class="col-span-3 text-green-500 dark:text-green-400">
                            Recuperación: {{ $asignatura->nota->recuperacion }}
                        </span>
                        @endif
                    </div>
                    @endif
                </div>
                @empty
                <p class="text-gray-500 dark:text-gray-400">No tienes asignaturas este período</p>
                @endforelse
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-800">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Últimas Calificaciones</h3>
            <div class="space-y-4">
                @forelse($ultimasNotas as $asignatura)
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-b-0">
                    <div class="flex justify-between items-center">
                        <div>
                            <h4 class="font-medium text-gray-800 dark:text-white">{{ $asignatura->asignaturadocente->asignatura->nombre }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Actualizado: {{ $asignatura->nota->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="block font-bold text-gray-800 dark:text-white">
                                {{ $asignatura->promedio_calculado }}%
                            </span>
                            <div class="flex gap-2 text-sm flex-wrap justify-end">
                                <span class="text-gray-500 dark:text-gray-400">P1: {{ $asignatura->nota->primerparcial }}</span>
                                <span class="text-gray-500 dark:text-gray-400">P2: {{ $asignatura->nota->segundoparcial }}</span>
                                @if($asignatura->asignaturadocente->mostrarTercerParcial)
                                <span class="text-gray-500 dark:text-gray-400">P3: {{ $asignatura->nota->tercerparcial }}</span>
                                @endif
                                @if($asignatura->nota->recuperacion > 0)
                                <span class="text-green-500 dark:text-green-400">Rec: {{ $asignatura->nota->recuperacion }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 dark:text-gray-400">No hay calificaciones recientes</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-4 rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-800">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Progreso del Programa</h3>
            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                {{ $progresoPrograma }}% completado
            </span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
            <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $progresoPrograma }}%"></div>
        </div>
        <div class="mt-2 flex justify-between text-sm text-gray-600 dark:text-gray-300">
            <span>{{ $asignaturasAprobadas }} aprobadas</span>
            <span>{{ $asignaturasTotales - $asignaturasAprobadas }} restantes</span>
        </div>
    </div>

    <div class="mt-4 rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-800">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Historial Académico</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Asignatura</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Docente</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Parciales</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Promedio</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse($asignaturasHistorial as $asignatura)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                            {{ $asignatura->asignaturadocente->asignatura->nombre }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $asignatura->asignaturadocente->docente->nombre }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col">
                                <span>P1: {{ $asignatura->nota->primerparcial }}</span>
                                <span>P2: {{ $asignatura->nota->segundoparcial }}</span>
                                @if($asignatura->asignaturadocente->mostrarTercerParcial)
                                <span>P3: {{ $asignatura->nota->tercerparcial }}</span>
                                @endif
                                @if($asignatura->nota->recuperacion > 0)
                                <span class="text-green-500 dark:text-green-400">Rec: {{ $asignatura->nota->recuperacion }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <span class="@if($asignatura->promedio_calculado >= 70) text-green-600 dark:text-green-400
                                @elseif($asignatura->promedio_calculado >= 60) text-yellow-600 dark:text-yellow-400
                                @else text-red-600 dark:text-red-400 @endif">
                                {{ $asignatura->promedio_calculado }}%
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if($asignatura->promedio_calculado >= 70)
                            <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                Aprobado
                            </span>
                            @else
                            <span class="px-2 py-1 rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                Reprobado
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                            No hay historial académico registrado
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>