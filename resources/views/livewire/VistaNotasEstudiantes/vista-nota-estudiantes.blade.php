<div>
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <div class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400">
                  <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                  </svg>
                  Mis notas
                </div>
              </li>
        </ol>
    </nav>
    @if ($matricula && $estudiante)
        <div class="flex justify-end mb-4">
            <a href="{{ route('descargarHistorial', ['matriculaId' => $matricula->id]) }}" 
               class="flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Descargar Historial 
            </a>
        </div>
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
        
            <div class="sm:ml-16 mt-4 sm:mt-0">
                <ul class="space-y-1 text-gray-700 grid lg:grid-cols-1 grid-cols-2 dark:text-gray-300">
                    <li><span class="font-bold">Indice Global:</span> {{ number_format($globalIndice, 2) }}</li>
                    @if(isset($periodIndice) && is_array($periodIndice) && count($periodIndice) > 0)
                        <li><span class="font-bold">Indice Periodo:</span> {{ number_format(array_values($periodIndice)[0], 2) }}</li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Historial Académico -->
        <div class="mb-8 mt-4">
            <h5 id="drawer-right-label" class="inline-flex items-center mb-1 text-base font-semibold text-gray-800 dark:text-gray-300">
               Historial Académico
            </h5>
            <!-- Tabla -->
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
                                $promedio = $nota ? round(($nota->primerparcial + $nota->segundoparcial + $nota->tercerparcial) / 3, 2) : 0;
                            @endphp
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">{{ $asignatura->asignatura->codigo ?? '' }}</td>
                                <td class="px-6 py-4">{{ $asignatura->asignatura->nombre ?? '' }}</td>
                                <td class="px-6 py-4">{{ $asignatura->asignatura->creditos ?? 0 }}</td>
                                <td class="px-6 py-4">{{ $asignatura->asignaturaDocente->seccion->nombre ?? '' }}</td>
                                <td class="px-6 py-4">
                                    @if($asignatura->periodo)
                                        {{ \Carbon\Carbon::parse($asignatura->periodo->fecha_inicio)->format('Y') }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $asignatura->periodo->nombre ?? '' }}</td>
                                <td class="px-6 py-4">{{ $promedio }}</td>
                                <td class="px-6 py-4">{{ $nota->observacion ?? '' }}</td>
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