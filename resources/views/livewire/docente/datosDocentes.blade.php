<!-- Fondo oscuro con opacidad (estilo modal) -->
<div class="fixed inset-0 bg-black bg-opacity-50 z-50" wire:click="closeDatos()"></div>

<!-- Drawer derecho -->
<div id="drawer-right-example"
    class="fixed top-0 right-0 z-50 w-[50%] h-screen p-4 overflow-y-auto bg-white border border-gray-200 shadow-lg dark:bg-gray-800 dark:border-gray-700"
    tabindex="-1" aria-labelledby="drawer-right-label">

    <!-- Título y botón de cierre -->
    <div class="flex justify-between items-center mb-4">
        <h5 id="drawer-right-label" class="text-lg font-semibold text-gray-800 dark:text-gray-300">
            Datos del Docente
        </h5>
        <button type="button" wire:click="closeDatos()"
            class="text-gray-500 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center dark:hover:bg-gray-700 dark:hover:text-white">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>

    <!-- Información del docente -->
    <div class="flex rounded-lg px-3 py-3 text-gray-800 dark:text-white bg-gray-50 dark:bg-gray-700 items-center gap-4">
        @if($foto)
            <img class="w-24 h-24 object-cover rounded-full" src="{{ asset('storage/' . $foto) }}" alt="{{$nombre}}">
        @else
            <img class="w-24 h-24 object-cover rounded-full" alt="{{$nombre}}"
                src="https://ui-avatars.com/api/?name={{ $nombre }}&amp;color=000&amp;background=facc15">
        @endif
        <div class="font-medium text-gray-800 dark:text-white">
            <div>{{$nombre}} {{$apellido}}</div>
            <div class="text-sm text-gray-500 dark:text-gray-400">Ingresó el
                {{ \Carbon\Carbon::parse($created_at)->format('d-m-Y') }}
            </div>
            <div
                class="{{ $estado ? 'bg-green-100 text-green-800 text-xs font-medium me-2 w-14 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-green-400 border border-green-400' : 'bg-red-100 text-red-800 text-xs w-16 font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-red-400 border border-red-400' }}">
                {{ $estado ? 'Activo' : 'Inactivo' }}</div>
        </div>
        <div class="ml-16">
            <ul class="space-y-1 text-gray-700 dark:text-gray-300">
                <li><span class="font-bold">Código:</span> {{$codigo}}</li>
                <li class="flex"><span class="font-bold">DNI: </span> {{$dni}}</li>
                <li><span class="font-bold">Género:</span> {{$sexo}}</li>
                <li><span class="font-bold">Teléfono:</span> {{$telefono}}</li>
                <li><span class="font-bold">Correo:</span> {{$correo}}</li>
            </ul>
        </div>
    </div>

    <!-- Clases asignadas -->
    <div class="mb-8 mt-4">
        <h5 id="drawer-right-label"
            class="inline-flex items-center mb-1 text-base font-semibold text-gray-800 dark:text-gray-300">
            Asignaturas actuales
        </h5>
        <!-- Tabla -->
        <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
            <table class="min-w-full bg-white dark:bg-gray-800">
                <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="py-2 px-4 border-b text-left">Periodo</th>
                        <th class="py-2 px-4 border-b text-left">Asignatura</th>
                        <th class="py-2 px-4 border-b text-left">Sección</th>
                        <th class="py-2 px-4 border-b text-left">Estudiantes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clasesDocente as $clase)
                        <tr class="overflow-x-auto cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600"> 
                            <td class="py-2 px-4 text-gray-600">{{ $clase->periodo->nombre }}</td>
                            <td class="py-2 px-4 text-gray-600">{{ $clase->asignatura->nombre }}</td>
                            <td class="py-2 px-4 text-gray-600">{{ $clase->seccion->nombre }}</td>
                            <td class="py-2 px-4 text-gray-600">{{ $clase->seccion->nombre }}</td>
                        </tr>
                    @empty  
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 text-gray-700" colspan="5">No hay clases asignadas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mb-8 mt-4">
        <h5 id="drawer-right-label"
            class="inline-flex items-center mb-1 text-base font-semibold text-gray-800 dark:text-gray-300">
            Historial de asignaturas
        </h5>
        <!-- Tabla -->
        <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
            <table class="min-w-full bg-white dark:bg-gray-800">
                <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="py-2 px-4 border-b text-left">Periodo</th>
                        <th class="py-2 px-4 border-b text-left">Asignatura</th>
                        <th class="py-2 px-4 border-b text-left">Sección</th>
                        <th class="py-2 px-4 border-b text-left">Estudiantes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clasesHistorial as $clasedada)
                        <tr class="overflow-x-auto cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-2 px-4 text-gray-400">{{ $clasedada->periodo->nombre }}</td>
                            <td class="py-2 px-4 text-gray-400">{{ $clasedada->asignatura->nombre }}</td>
                            <td class="py-2 px-4 text-gray-400">{{ $clasedada->seccion->nombre }}</td>
                            <td class="py-2 px-4 text-gray-600">{{ $clase->seccion->nombre }}</td>
                        </tr>
                    @empty  
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 text-gray-700" colspan="5">No hay clases asignadas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>