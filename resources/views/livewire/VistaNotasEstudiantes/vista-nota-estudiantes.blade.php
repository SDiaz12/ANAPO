<div>
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{route('dashboard')}}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-red-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    Inicio
                </a>
            </li>
            <li class="inline-flex items-center">
                <div class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    Mis notas
                </div>
            </li>
        </ol>
    </nav>
  
    @if ($matricula && $estudiante)
        <!-- Mostrar botón de descargar solo si hay registros -->
        @if($tieneRegistros)
            <div class="flex justify-end mb-4">
                <a href="{{ route('descargarHistorial', ['matriculaId' => $matricula->id]) }}" 
                   class="flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Descargar Historial 
                </a>
            </div>
        @endif

        <!-- Información del estudiante -->
        <div class="flex flex-col sm:flex-row rounded-lg px-16 py-6 text-gray-800 dark:text-white bg-gray-50 dark:bg-gray-800 items-center gap-4">
            @if($estudiante->foto)
                <img class="w-36 h-36 object-cover rounded-full" src="{{ asset('storage/' . $estudiante->foto) }}" alt="{{$estudiante->nombre}}">
            @else
                <img class="w-36 h-36 object-cover rounded-full" alt="{{$estudiante->nombre}}" src="https://ui-avatars.com/api/?name={{ $estudiante->nombre }}&amp;color=000&amp;background=facc15">
            @endif
            <div class="font-medium text-gray-800 dark:text-white">
                <div>{{$estudiante->nombre}} {{$estudiante->apellido}}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Ingresó el {{ \Carbon\Carbon::parse($estudiante->created_at)->format('d-m-Y') }}</div>
                <div class="{{ $estudiante->estado ? 'bg-green-100 text-green-800 text-xs font-medium mt-1.5 me-2 w-14 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-green-400 border border-green-400' : 'bg-red-100 text-red-800 text-xs w-16 font-medium mt-1.5 me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-red-400 border border-red-400' }}">
                    {{ $estudiante->estado ? 'Activo' : 'Inactivo' }}
                </div>
            </div>

            <div class="sm:ml-16 mt-4 sm:mt-0">
                <ul class="space-y-1 text-gray-700 grid lg:grid-cols-1 grid-cols-2 dark:text-gray-300">
                    <li><span class="font-bold">Código:</span> {{$estudiante->codigo}}</li>
                    <li><span class="font-bold">Instituto: </span>{{ $matricula->instituto->nombre ?? 'Instituto no disponible' }}</li> 
                    <li><span class="font-bold">Programa: </span>{{ $matricula->programaFormacion->nombre ?? 'Programa no disponible' }}</li>
                </ul>
            </div>
            @if($tieneRegistros)
                <div class="sm:ml-16 mt-4 sm:mt-0">
                    <ul class="space-y-1 text-gray-700 grid lg:grid-cols-1 grid-cols-2 dark:text-gray-300">
                        <li>
                            <span class="font-bold">Índice Global:</span> 
                            {{ number_format($globalIndice, 2) }}
                        </li>
                    </ul>
                </div>
            @endif
        </div>
        <div class="mb-8 mt-4">
            <h5 id="drawer-right-label" class="inline-flex items-center mb-1 text-base font-semibold text-gray-800 dark:text-gray-300">
               Historial Académico
            </h5>
            <div class="overflow-x-auto scrollbar-hidden rounded-xl border border-gray-200 dark:border-gray-700">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Código</th>
                            <th scope="col" class="px-6 py-3">Asignatura</th>
                            <th scope="col" class="px-6 py-3">UV</th>
                            <th scope="col" class="px-6 py-3">Sección</th>
                            <th scope="col" class="px-6 py-3">Año</th>
                            <th scope="col" class="px-6 py-3">Periodo</th>
                            <th scope="col" class="px-6 py-3">Nota Final</th>
                            <th scope="col" class="px-6 py-3">Observación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historialCompleto as $asignatura)
                            @php
                                $nota = $asignatura->notas;
                                $promedio = 0;
                                $observacion = $nota->observacion ?? 'Sin calificar';
                                
                                if ($nota && $asignatura->asignaturaDocente) {
                                    $p1 = (float)($nota->primerparcial ?? 0);
                                    $p2 = (float)($nota->segundoparcial ?? 0);
                                    $recuperacion = (float)($nota->recuperacion ?? 0);
                                    $mostrarTercerParcial = $asignatura->asignaturaDocente->mostrarTercerParcial ?? false;
                                
                                    if ($mostrarTercerParcial) {
                                        $p3 = (float)($nota->tercerparcial ?? 0);
                                        $sumaParciales = $p1 + $p2 + $p3;
                                        $promedio = $sumaParciales / 3;

                                        if ($recuperacion > 0) {
                                            $minParcial = min($p1, $p2, $p3);
                                            $promedio = ($sumaParciales - $minParcial + $recuperacion) / 3;
                                        }
                                    } else {
                                        $sumaParciales = $p1 + $p2;
                                        $promedio = $sumaParciales / 2;
                       
                                        if ($recuperacion > 0) {
                                            $promedio = max($promedio, $recuperacion);
                                        }
                                    }
                                    
                                    $promedio = round($promedio, 2);
                                    if ($observacion === 'Sin calificar') {
                                        if ($promedio >= 90) {
                                            $observacion = 'Excelente';
                                        } elseif ($promedio >= 80) {
                                            $observacion = 'Muy Bueno';
                                        } elseif ($promedio >= 70) {
                                            $observacion = 'Bueno';
                                        } elseif ($promedio > 0) {
                                            $observacion = 'Insuficiente';
                                        } else {
                                            $observacion = 'No presentado';
                                        }
                                    }
                                }
                            @endphp
                            
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">{{ $asignatura->asignaturaDocente->asignatura->codigo ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $asignatura->asignaturaDocente->asignatura->nombre ?? 'Asignatura no disponible' }}</td>
                                <td class="px-6 py-4">{{ $asignatura->asignaturaDocente->asignatura->creditos ?? 0 }}</td>
                                <td class="px-6 py-4">{{ $asignatura->asignaturaDocente->seccion->nombre ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    @if($asignatura->periodo)
                                        {{ \Carbon\Carbon::parse($asignatura->asignaturaDocente->periodo->fecha_inicio)->format('Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $asignatura->asignaturaDocente->periodo->nombre ?? 'N/A' }}</td>
                                <td class="px-6 py-4 font-medium {{ $promedio >= 70 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $promedio }}
                                </td>
                                <td class="px-6 py-4">{{ $observacion }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No se encontraron registros de asignaturas de periodos finalizados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl dark:bg-gray-800 dark:text-white">
            <div class="md:flex">
                <div class="p-8">
                    <div class="uppercase tracking-wide text-sm text-red-600 font-semibold dark:text-red-600"></div>
                    <p class="block mt-1 text-lg leading-tight font-medium text-black dark:text-white">¡Aquí veras tus calificaciones!</p>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Una vez que te matricules en un programa de formación y califiquen tus clases, podrás ver tu información y tus calificaciones.</p>
                    <div class="mt-4">
                        <a href="{{ route('dashboard') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded dark:bg-red-600 dark:hover:bg-red-700">
                           Ir al inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>