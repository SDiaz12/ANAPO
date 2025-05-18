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
    </style>
    @if($isOpenDatos)
        @include('livewire.estudiant.datosEstudiante')
    @endif
    <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 bg-gray-100 dark:bg-gray-900 pb-1">
        <!-- Tarjeta -->
        <a href="{{route('estudiante')}}">
            <div
                class="relative flex items-center p-6 rounded-xl border border-gray-200 bg-white  dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-blue-100 dark:bg-blue-700">
                    <svg class="w-8 h-8 text-blue-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12.4472 2.10557c-.2815-.14076-.6129-.14076-.8944 0L5.90482 4.92956l.37762.11119c.01131.00333.02257.00687.03376.0106L12 6.94594l5.6808-1.89361.3927-.13363-5.6263-2.81313ZM5 10V6.74803l.70053.20628L7 7.38747V10c0 .5523-.44772 1-1 1s-1-.4477-1-1Zm3-1c0-.42413.06601-.83285.18832-1.21643l3.49538 1.16514c.2053.06842.4272.06842.6325 0l3.4955-1.16514C15.934 8.16715 16 8.57587 16 9c0 2.2091-1.7909 4-4 4-2.20914 0-4-1.7909-4-4Z" />
                        <path
                            d="M14.2996 13.2767c.2332-.2289.5636-.3294.8847-.2692C17.379 13.4191 19 15.4884 19 17.6488v2.1525c0 1.2289-1.0315 2.1428-2.2 2.1428H7.2c-1.16849 0-2.2-.9139-2.2-2.1428v-2.1525c0-2.1409 1.59079-4.1893 3.75163-4.6288.32214-.0655.65589.0315.89274.2595l2.34883 2.2606 2.3064-2.2634Z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-base font-medium text-gray-600 dark:text-gray-400">Estudiantes</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{$estudiantesCount}}</h4>
                </div>
            </div>
        </a>
        
        <!-- Tarjeta -->
        <a href="{{route('docente')}}">
            <div
                class="relative flex items-center p-6 rounded-xl border border-gray-200 bg-white  dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-red-100 dark:bg-red-700">
                    <svg class="w-8 h-8 text-red-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M6 2c-1.10457 0-2 .89543-2 2v4c0 .55228.44772 1 1 1s1-.44772 1-1V4h12v7h-2c-.5523 0-1 .4477-1 1v2h-1c-.5523 0-1 .4477-1 1s.4477 1 1 1h5c.5523 0 1-.4477 1-1V3.85714C20 2.98529 19.3667 2 18.268 2H6Z" />
                        <path
                            d="M6 11.5C6 9.567 7.567 8 9.5 8S13 9.567 13 11.5 11.433 15 9.5 15 6 13.433 6 11.5ZM4 20c0-2.2091 1.79086-4 4-4h3c2.2091 0 4 1.7909 4 4 0 1.1046-.8954 2-2 2H6c-1.10457 0-2-.8954-2-2Z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-base font-medium text-gray-600 dark:text-gray-400">Docentes</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{$docentesCount}}</h4>
                </div>
            </div>
        </a>
        
        <!-- Tarjeta -->
        <a href="{{route('asignatura')}}">
            <div
                class="relative flex items-center p-6 rounded-xl border border-gray-200 bg-white  dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-green-100 dark:bg-green-700">
                    <svg class="w-8 h-8 text-green-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M9 6c0-1.65685 1.3431-3 3-3s3 1.34315 3 3-1.3431 3-3 3-3-1.34315-3-3Zm2 3.62992c-.1263-.04413-.25-.08799-.3721-.13131-1.33928-.47482-2.49256-.88372-4.77995-.8482C4.84875 8.66593 4 9.46413 4 10.5v7.2884c0 1.0878.91948 1.8747 1.92888 1.8616 1.283-.0168 2.04625.1322 2.79671.3587.29285.0883.57733.1863.90372.2987l.00249.0008c.11983.0413.24534.0845.379.1299.2989.1015.6242.2088.9892.3185V9.62992Zm2-.00374V20.7551c.5531-.1678 1.0379-.3374 1.4545-.4832.2956-.1034.5575-.1951.7846-.2653.7257-.2245 1.4655-.3734 2.7479-.3566.5019.0065.9806-.1791 1.3407-.4788.3618-.3011.6723-.781.6723-1.3828V10.5c0-.58114-.2923-1.05022-.6377-1.3503-.3441-.29904-.8047-.49168-1.2944-.49929-2.2667-.0352-3.386.36906-4.6847.83812-.1256.04539-.253.09138-.3832.13765Z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-base font-medium text-gray-600 dark:text-gray-400">Asignaturas</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{$asignaturasCount}}</h4>
                </div>
            </div>
        </a>
        
        <!-- Tarjeta -->
        <a href="{{route('promocion')}}">
            <div
                class="relative flex items-center p-6 rounded-xl border border-gray-200 bg-white  dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-yellow-100 dark:bg-yellow-700">
                    <svg class="w-8 h-8 text-yellow-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12.4472 4.10557c-.2815-.14076-.6129-.14076-.8944 0L2.76981 8.49706l9.21949 4.39024L21 8.38195l-8.5528-4.27638Z" />
                        <path
                            d="M5 17.2222v-5.448l6.5701 3.1286c.278.1325.6016.1293.8771-.0084L19 11.618v5.6042c0 .2857-.1229.5583-.3364.7481l-.0025.0022-.0041.0036-.0103.009-.0119.0101-.0181.0152c-.024.02-.0562.0462-.0965.0776-.0807.0627-.1942.1465-.3405.2441-.2926.195-.7171.4455-1.2736.6928C15.7905 19.5208 14.1527 20 12 20c-2.15265 0-3.79045-.4792-4.90614-.9751-.5565-.2473-.98098-.4978-1.27356-.6928-.14631-.0976-.2598-.1814-.34049-.2441-.04036-.0314-.07254-.0576-.09656-.0776-.01201-.01-.02198-.0185-.02991-.0253l-.01038-.009-.00404-.0036-.00174-.0015-.0008-.0007s-.00004 0 .00978-.0112l-.00009-.0012-.01043.0117C5.12215 17.7799 5 17.5079 5 17.2222Zm-3-6.8765 2 .9523V17c0 .5523-.44772 1-1 1s-1-.4477-1-1v-6.6543Z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-base font-medium text-gray-600 dark:text-gray-400">Promociones</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $promocionesCount}}</h4>
                </div>
            </div>
        </a>
        
        <!-- Tarjeta -->
        <a href="{{route('programas')}}">
            <div
                class="relative flex items-center p-6 rounded-xl border border-gray-200 bg-white  dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-purple-100 dark:bg-purple-700">
                    <svg class="w-8 h-8 text-purple-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12.8638 3.49613C12.6846 3.18891 12.3557 3 12 3s-.6846.18891-.8638.49613l-3.49998 6c-.18042.30929-.1817.69147-.00336 1.00197S8.14193 11 8.5 11h7c.3581 0 .6888-.1914.8671-.5019.1784-.3105.1771-.69268-.0033-1.00197l-3.5-6ZM4 13c-.55228 0-1 .4477-1 1v6c0 .5523.44772 1 1 1h6c.5523 0 1-.4477 1-1v-6c0-.5523-.4477-1-1-1H4Zm12.5-1c-2.4853 0-4.5 2.0147-4.5 4.5s2.0147 4.5 4.5 4.5 4.5-2.0147 4.5-4.5-2.0147-4.5-4.5-4.5Z" />
                    </svg>
        
                </div>
                <div class="ml-5">
                    <p class="text-base font-medium text-gray-600 dark:text-gray-400">Programas</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{$programasCount}}</h4>
                </div>
            </div>
        </a>
        
        <!-- Tarjeta -->
        <a href="{{route('matricula')}}">
            <div
                class="relative flex items-center p-6 rounded-xl border border-gray-200 bg-white  dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-teal-100 dark:bg-teal-700">
                    <svg class="w-8 h-8 text-teal-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm10 5a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-8-5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm1.942 4a3 3 0 0 0-2.847 2.051l-.044.133-.004.012c-.042.126-.055.167-.042.195.006.013.02.023.038.039.032.025.08.064.146.155A1 1 0 0 0 6 17h6a1 1 0 0 0 .811-.415.713.713 0 0 1 .146-.155c.019-.016.031-.026.038-.04.014-.027 0-.068-.042-.194l-.004-.012-.044-.133A3 3 0 0 0 10.059 14H7.942Z"
                            clip-rule="evenodd" />
                    </svg>
        
                </div>
                <div class="ml-5">
                    <p class="text-base font-medium text-gray-600 dark:text-gray-400">Matricula</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{$matriculasCount}}</h4>
                </div>
            </div>
        </a>
        </div>

    <!-- otra seccion -->
    <main>
        <div class="mx-auto pt-3 md:pt-3">
            <div class="grid grid-cols-12 gap-4 md:gap-4">
                <div class="col-span-12 space-y-4 xl:col-span-8">
                    <!-- ====== Chart Fourteen Start -->
                    <div
                        class="rounded-2xl border border-gray-200 bg-white px-5 pb-5 pt-5 dark:border-gray-700 dark:bg-gray-800 sm:px-6 sm:pt-5">
                        <div class="flex flex-col gap-5 mb-6 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                    Estudiantes por programa
                                </h3>
                                <p class="mt-1 text-gray-500 text-theme-sm dark:text-gray-400">
                                    Aquí prodrás ver la demanda de cada programa
                                </p>
                            </div>
                            <div x-data="{selected: 'optionOne'}"
                                class="inline-flex w-fit items-center gap-0.5 rounded-lg bg-gray-100 p-0.5 dark:bg-gray-900">
                                <button @click="selected = 'optionOne'" :class="selected === 'optionOne' ? 'shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800' : 'text-gray-500 dark:text-gray-400'"
                                    class="px-3 py-2 font-medium transition-colors rounded-md text-theme-sm hover:text-gray-900 dark:hover:bg-gray-800 dark:hover:text-white shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800">
                                    Gráfico
                                </button>
                                <a href="{{route('estudiante')}}">
                                    <button @click="selected = 'optionTwo'" :class="selected === 'optionTwo' ? 'shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800' : 'text-gray-500 dark:text-gray-400'"
                                        class="px-3 py-2 font-medium transition-colors rounded-md text-theme-sm hover:text-gray-900 dark:hover:bg-gray-800 dark:hover:text-white text-gray-500 dark:text-gray-400">
                                        Estudiantes
                                    </button>
                                </a>
                                <a href="{{route('programas')}}">
                                    <button @click="selected = 'optionThree'" :class="selected === 'optionThree' ? 'shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800' : 'text-gray-500 dark:text-gray-400'"
                                        class="px-3 py-2 font-medium transition-colors rounded-md text-theme-sm hover:text-gray-900 dark:hover:bg-gray-800 dark:hover:text-white text-gray-500 dark:text-gray-400">
                                        Programas
                                    </button>
                                </a>
                            </div>

                        </div>
                        <div class="max-w-full overflow-x-auto barra dark:barra">
                            <div id="chart-programas" class="w-full" style="min-height: 320px;"></div>
                        </div>
                    </div>
                    <!-- ====== Chart Fourteen End -->
                    <div class="col-span-12">
                        <!-- Table Five -->
                        <div
                            class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-700 dark:bg-gray-800">
                            <div
                                class="mb-4 flex flex-col gap-2 px-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                        Últimas matrículas
                                    </h3>
                                </div>

                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                                    <form>
                                        <div class="relative">
                                            <span class="pointer-events-none absolute top-1/2 left-4 -translate-y-1/2">
                                                <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20"
                                                    viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z"
                                                        fill=""></path>
                                                </svg>
                                            </span>
                                            <input wire:model.live="search" type="text" id="table-search"
                                                class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                                                placeholder="Buscar matricula">
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="barra dark:barra max-w-full overflow-x-auto px-5 sm:px-6">
                                <table class="min-w-full">
                                    <thead class="border-y border-gray-100 py-3 dark:border-gray-700">
                                        <tr>
                                            <th class="py-3 font-normal whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">Nombre</p>
                                                </div>
                                            </th>
                                            <th class="py-3 font-normal whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">Programa
                                                    </p>
                                                </div>
                                            </th>
                                            <th class="py-3 font-normal whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">Fecha</p>
                                                </div>
                                            </th>
                                            <th class="py-3 font-normal whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">Estado</p>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                        @forelse($recentMatriculas as $matricula)
                                            <tr>
                                                <td class="py-3 whitespace-nowrap">
                                                    <div class="col-span-3 flex items-center">
                                                        <div class="flex items-center gap-3">
                                                            <div class="h-8 w-8">
                                                                @if ($matricula->estudiante->foto)
                                                                    <img class="w-9 h-9 rounded-full object-cover"
                                                                        alt="{{$matricula->estudiante->nombre}}"
                                                                        src="{{ asset('storage/' . $matricula->estudiante->foto) }}">
                                                                @else
                                                                    <img class="w-9 h-9 rounded-full object-cover"
                                                                        alt="{{$matricula->estudiante->nombre}}"
                                                                        src="https://ui-avatars.com/api/?name={{ $matricula->estudiante->nombre }}&amp;color=000&amp;background=#dc2626">
                                                                @endif
                                                            </div>

                                                            <div>
                                                                <span
                                                                    class="text-theme-sm block font-medium text-gray-700 dark:text-gray-400">
                                                                    {{ $matricula->estudiante->nombre ?? '' }}
                                                                    {{ $matricula->estudiante->apellido ?? '' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                                            {{ $matricula->programaFormacion->nombre ?? 'N/A' }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="py-3 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                                            {{ \Carbon\Carbon::parse($matricula->created_at)->format('d-m-Y') }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="py-3 whitespace-nowrap">
                                                    @if ($matricula->estado == 1)
                                                        <div class="flex items-center">
                                                            <p
                                                                class="bg-green-50 text-theme-xs text-green-600 dark:bg-green-500/15 dark:text-green-500 rounded-full px-2 py-0.5 font-medium">
                                                                activo
                                                            </p>
                                                        </div>
                                                    @else
                                                        <div class="flex items-center">
                                                            <p
                                                                class="bg-red-50 text-theme-xs text-red-600 dark:bg-green-500/15 dark:text-red-500 rounded-full px-2 py-0.5 font-medium">
                                                                Inactivo
                                                            </p>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="py-3 whitespace-nowrap">
                                                    <div class="flex items-center justify-center">
                                                        <div x-data="{openDropDown: false}" class="relative">
                                                            <button @click="openDropDown = !openDropDown"
                                                                class="text-gray-500 dark:text-gray-400">
                                                                <svg class="fill-current" width="24" height="24"
                                                                    viewBox="0 0 24 24" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z"
                                                                        fill=""></path>
                                                                </svg>
                                                            </button>
                                                            <div x-show="openDropDown" @click.outside="openDropDown = false"
                                                                class="shadow-theme-lg dark:bg-gray-dark absolute top-full right-0 z-40 w-40 space-y-1 rounded-2xl border border-gray-200 bg-white p-2 dark:border-gray-700 dark:bg-gray-800 shadow-xl"
                                                                style="display: none;">
                                                                <button
                                                                    wire:click="mostrarDatos({{ $matricula->estudiante->id }})"
                                                                    class="text-theme-xs flex w-full rounded-lg px-3 py-2 text-left font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                                                    Ver más
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 text-gray-700"
                                                    colspan="5">No
                                                    hay matriculas recientes</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-700">
                                <div class="flex items-center justify-between">
                                    {{$recentMatriculas->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="rounded-2xl border border-gray-200 bg-white p-5 mt-6 dark:border-gray-800 dark:bg-gray-800">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-2">
                            Estudiantes por departamento de residencia
                        </h3>
                        <div id="grafico-residencia" style="min-height: 320px;"></div>
                    </div>
                </div>

                <div class="col-span-12 space-y-4 xl:col-span-4">
                    <div
                        class="rounded-2xl border border-gray-200 bg-white px-5 pt-5 dark:border-gray-700 dark:bg-gray-800 sm:px-6 sm:pt-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                Estudiantes
                            </h3>
                        </div>
                        <div>
                            <div id="chartFifteen" class="-ml-5" style="min-height: 215px;">
                                <!-- Donut Chart -->
                                <div class="py-6 text-white dark:text-gray-300" id="donut-chart"></div>
                            </div>
                        </div>
                    </div>
                    <!-- ====== Chart Fifteen End -->

                    <!-- ====== Chart Sixteen Start -->
                    <div
                        class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-gray-800">
                        <div class="flex items-start justify-between">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white/90">
                                Usuarios Conectados
                            </h3>
                        </div>
                        <div class="max-w-sm w-full bg-gray-50 rounded-lg dark:bg-white/[0.03] p-5 md:p-7">
                            <div class="flex justify-between">
                                <div class="flex items-center">
                                    <span class="relative flex h-4 w-4 mr-2">
                                        <span
                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 dark:bg-green-500 opacity-75"></span>
                                        <span
                                            class="relative inline-flex rounded-full h-4 w-4 bg-green-500 dark:bg-green-600"></span>
                                    </span>


                                    <h5
                                        class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2 inline">
                                        {{ $usuariosActivos }}
                                    </h5>
                                    <p class="ml-3 text-base font-normal text-gray-500 dark:text-gray-400 inline">
                                        Conectados</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ====== Chart Fifteen End -->

                    <!-- ====== Chart Fifteen Start -->
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-800">
                        <div class="mb-6 flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                Estudiantes destacados
                            </h3>
                        </div>

                        <div class="flex h-[372px] flex-col">
                            <div class="barra dark:barra flex h-auto flex-col overflow-y-auto pr-3">
                                <!-- item -->
                                @forelse($destacados as $item)
                                    <div
                                        class="flex items-center justify-between border-b border-gray-200 pb-4 pt-4 first:pt-0 last:border-b-0 last:pb-0 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10">
                                                @if ($item['estudiante']->foto)
                                                    <img class="w-10 h-10 rounded-full object-cover"
                                                        alt="{{ $item['estudiante']->nombre }}"
                                                        src="{{ asset('storage/' . $item['estudiante']->foto) }}">
                                                @else
                                                    <img class="w-10 h-10 rounded-full object-cover"
                                                        alt="{{ $item['estudiante']->nombre }}"
                                                        src="https://ui-avatars.com/api/?name={{ urlencode($item['estudiante']->nombre . ' ' . $item['estudiante']->apellido) }}&color=fff&background=dc2626">
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3
                                                    class="text-base font-semibold text-gray-800 dark:text-white/90 truncate">
                                                    {{ $item['estudiante']->nombre }} {{ $item['estudiante']->apellido }}
                                                </h3>
                                                <span class="block text-gray-500 dark:text-gray-400 truncate">
                                                    {{ $item['estudiante']->matricula->programaFormacion->nombre ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </div>

                                        <div>
                                            <span
                                                class="flex items-center justify-end gap-1 text-theme-xs font-medium text-green-600 dark:text-green-500">
                                                <svg class="fill-current" width="12" height="12" viewBox="0 0 12 12"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.56462 1.62394C5.70193 1.47073 5.90135 1.37433 6.12329 1.37433C6.1236 1.37433 6.12391 1.37433 6.12422 1.37433C6.31631 1.37416 6.50845 1.44732 6.65505 1.59381L9.65514 4.59181C9.94814 4.8846 9.94831 5.35947 9.65552 5.65247C9.36273 5.94546 8.88785 5.94563 8.59486 5.65284L6.87329 3.93248L6.87329 10.125C6.87329 10.5392 6.53751 10.875 6.12329 10.875C5.70908 10.875 5.37329 10.5392 5.37329 10.125L5.37329 3.93579L3.65516 5.65282C3.36218 5.94562 2.8873 5.94547 2.5945 5.65249C2.3017 5.3595 2.30185 4.88463 2.59484 4.59183L5.56462 1.62394Z"
                                                        fill=""></path>
                                                </svg>
                                                {{ $item['indice'] }}%
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-2 text-gray-500">No hay estudiantes destacados.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <!-- ====== Chart Fifteen End -->

                </div>

            </div>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let femenino = @json($data['femenino']);
            let masculino = @json($data['masculino']);

            // Detectar modo oscuro
            function isDarkMode() {
                return document.documentElement.classList.contains('dark');
            }

            function getChartOptions(dark) {
                return {
                    series: [femenino, masculino],
                    colors: ["#E74694", "#16BDCA"],
                    chart: {
                        height: 320,
                        width: "100%",
                        type: "donut",
                        background: "transparent",
                        toolbar: {
                            show: true,
                            tools: {
                                download: true, 
                                selection: false,
                                zoom: false,
                                zoomin: false,
                                zoomout: false,
                                pan: false,
                                reset: false,
                                customIcons: []
                            }
                        }
                    },
                    stroke: {
                        colors: ["transparent"],
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: "Total",
                                        color: dark ? '#d1d5db' : '#374151',
                                        formatter: function (w) {
                                            return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                        },
                                    },
                                },
                                size: "80%",
                            },
                        },
                    },
                    labels: ["Femenino", "Masculino"],
                    dataLabels: {
                        enabled: true,
                        style: {
                            colors: [dark ? '#d1d5db' : '#d1d5db']
                        }
                    },
                    legend: {
                        position: "bottom",
                        labels: {
                            colors: dark ? '#d1d5db' : '#6B7280',
                            useSeriesColors: false,
                        },
                    },
                    theme: {
                        mode: dark ? 'dark' : 'light'
                    }
                };
            }

            if (document.getElementById("donut-chart")) {
                let chart = new ApexCharts(
                    document.getElementById("donut-chart"),
                    getChartOptions(isDarkMode())
                );
                chart.render();

         
                Livewire.on('chartUpdated', (newData) => {
                    chart.updateSeries([newData.femenino, newData.masculino]);
                });
                const observer = new MutationObserver(() => {
                    chart.updateOptions(getChartOptions(isDarkMode()));
                });
                observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let labelsProgramas = @json($labelsProgramas);
            let dataActivos = @json($dataActivos);
            let dataBajas = @json($dataBajas);

            function isDarkMode() {
                return document.documentElement.classList.contains('dark');
            }

            function getChartOptions(dark) {
                return {
                    series: [
                        {
                            name: 'Activos',
                            data: dataActivos
                        },
                        {
                            name: 'Bajas',
                            data: dataBajas,
                        }
                    ],
                    chart: {
                        type: 'bar',
                        height: 320,
                        stacked: false,
                        background: 'transparent',
                        toolbar: {
                            show: true,
                            tools: {
                                download: true, 
                                selection: false,
                                zoom: false,
                                zoomin: false,
                                zoomout: false,
                                pan: false,
                                reset: false,
                                customIcons: []
                            }
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        }
                    },
                    dataLabels: {
                        enabled: true
                    },
                    xaxis: {
                        categories: labelsProgramas,
                        labels: {
                            rotate: -45,
                            style: {
                                fontSize: '12px',
                                colors: dark ? '#d1d5db' : '#374151'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: dark ? '#d1d5db' : '#374151'
                            }
                        }
                    },
                    grid: {
                        borderColor: dark ? '#374151' : '#e5e7eb'
                    },
                    colors: ['#22c55e', '#dc2626'],
                    legend: {
                        position: 'top',
                        labels: {
                            colors: dark ? '#d1d5db' : '#374151'
                        }
                    },
                    theme: {
                        mode: dark ? 'dark' : 'light'
                    },
                    title: {
                        text: 'Activos vs Bajas',
                        align: 'center',
                        style: {
                            fontSize: '16px',
                            fontWeight: 'bold',
                            color: dark ? '#d1d5db' : '#000000'
                        }
                    }
                };
            }

            // Renderizar gráfico
            if (document.getElementById("chart-programas")) {
                let chartProgramas = new ApexCharts(
                    document.getElementById("chart-programas"),
                    getChartOptions(isDarkMode())
                );
                chartProgramas.render();

                const observer = new MutationObserver(() => {
                    chartProgramas.updateOptions(getChartOptions(isDarkMode()));
                });
                observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let departamentos = @json($departamentos);
            let cantidad = @json($cantidadPorDepartamento);

            function isDarkMode() {
                return document.documentElement.classList.contains('dark');
            }

            function getOptions(dark) {
                return {
                    chart: {
                        type: 'bar',
                        height: 320,
                        background: 'transparent',
                        toolbar: {
                            show: true,
                            tools: {
                                download: true
                            }
                        }
                    },
                    series: [{
                        name: 'Estudiantes',
                        data: cantidad
                    }],
                    xaxis: {
                        categories: departamentos,
                        labels: {
                            rotate: -45,
                            style: {
                                colors: dark ? '#d1d5db' : '#374151'
                            }
                        },
                        title: {
                            text: 'Departamento',
                            style: {
                                color: dark ? '#d1d5db' : '#374151'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: dark ? '#d1d5db' : '#374151'
                            }
                        },
                        title: {
                            text: 'Cantidad',
                            style: {
                                color: dark ? '#d1d5db' : '#374151'
                            }
                        }
                    },
                    grid: {
                        borderColor: dark ? '#374151' : '#e5e7eb'
                    },
                    colors: ['#eab308'],
                    theme: {
                        mode: dark ? 'dark' : 'light'
                    }
                };
            }

            if (document.getElementById("grafico-residencia")) {
                let chart = new ApexCharts(
                    document.getElementById("grafico-residencia"),
                    getOptions(isDarkMode())
                );
                chart.render();

                // Soporte para modo oscuro
                const observer = new MutationObserver(() => {
                    chart.updateOptions(getOptions(isDarkMode()));
                });
                observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
            }
        });
    </script>
</div>