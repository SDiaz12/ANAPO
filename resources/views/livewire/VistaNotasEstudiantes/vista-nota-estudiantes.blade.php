<div>
        <!-- Información del Estudiante -->
        <div
            class="flex flex-col sm:flex-row rounded-lg px-16 py-6 text-gray-800 dark:text-white bg-gray-50 dark:bg-gray-800 items-center gap-4">
            @if($datos->foto)
                <img class="w-36 h-36 object-cover rounded-full" src="{{ asset('storage/' . $datos->foto) }}"
                    alt="{{$datos->nombre}}">
            @else
                <img class="w-36 h-36 object-cover rounded-full" alt="{{$datos->nombre}}"
                    src="https://ui-avatars.com/api/?name={{ $datos->nombre }}&amp;color=000&amp;background=facc15">
            @endif
            <div class="font-medium text-gray-800 dark:text-white">
                <div>{{$datos->nombre}} {{$datos->apellido}}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Ingresó el
                    {{ \Carbon\Carbon::parse($datos->created_at)->format('d-m-Y') }}
                </div>
                <div
                    class="{{ $datos->estado ? 'bg-green-100 text-green-800 text-xs font-medium mt-1.5 me-2 w-14 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-green-400 border border-green-400' : 'bg-red-100 text-red-800 text-xs w-16 font-medium mt-1.5 me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-red-400 border border-red-400' }}">
                    {{ $datos->estado ? 'Activo' : 'Inactivo' }}
                </div>
            </div>

            <div class="sm:ml-16 mt-4 sm:mt-0">
                <ul class="space-y-1 text-gray-700 grid lg:grid-cols-1 grid-cols-2 dark:text-gray-300">
                    <li><span class="font-bold">Código:</span> {{$datos->codigo}}</li>
                    <li><span class="font-bold">Instituto: </span>{{ $instituto->instituto ?? 'Instituto no disponible' }}</li> 
                    
                    <li><span class="font-bold">Programa: </span>{{$programaformacion->nombre ?? 'Programa no disponible' }}</li>
                </ul>
            </div>
        
            <div class="sm:ml-16 mt-4 sm:mt-0">
                <ul class="space-y-1 text-gray-700 grid lg:grid-cols-1 grid-cols-2 dark:text-gray-300">
                    <li><span class="font-bold">Indice Global:</span> {{$globalIndice}}</li>
                    <li><span class="font-bold">Indice Periodo:</span> {{ $periodIndice }}</li>
                </ul>
            </div>
        </div>

        <!-- Clases asignadas -->
        <div class="mb-8 mt-4">
            <h5 id="drawer-right-label"
                class="inline-flex items-center mb-1 text-base font-semibold text-gray-800 dark:text-gray-300">
               Historial Académico
            </h5>
            <!-- Tabla -->
            <div class="overflow-x-auto scrollbar-hidden rounded-xl border border-gray-200 dark:border-gray-700">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Código
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Asignatura
                            </th>
                            <th scope="col" class="px-6 py-3">
                                UV
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Sección
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Año
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Periodo
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Primer Parcial
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Segundo Parcial
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tercer Parcial
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Promedio
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Observación
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notas as $nota)
                            <tr
                                class=" overflow-x-auto cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">
                                    {{ $asignatura->codigo }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $asignatura->nombre }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $asignatura->creditos }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $periodo->nombre }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($periodo->fecha_inicio)->format('Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $periodo->nombre }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $nota->primerparcial }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $nota->segundoparcial }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $nota->tercerparcial }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $promedio}}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $nota->observacion }}
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="px-6 py-4 text-center">
                                    No se encontraron registros
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
</div>