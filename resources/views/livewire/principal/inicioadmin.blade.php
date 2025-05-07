<div>
    <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 bg-gray-100 dark:bg-gray-900 p-1">
        <!-- Tarjeta -->
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

        <!-- Tarjeta -->
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

        <!-- Tarjeta -->
        <div
            class="relative flex items-center p-6 rounded-xl border border-gray-200 bg-white  dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-green-100 dark:bg-green-700">
                <svg class="w-8 h-8 text-green-600 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M9 6c0-1.65685 1.3431-3 3-3s3 1.34315 3 3-1.3431 3-3 3-3-1.34315-3-3Zm2 3.62992c-.1263-.04413-.25-.08799-.3721-.13131-1.33928-.47482-2.49256-.88372-4.77995-.8482C4.84875 8.66593 4 9.46413 4 10.5v7.2884c0 1.0878.91948 1.8747 1.92888 1.8616 1.283-.0168 2.04625.1322 2.79671.3587.29285.0883.57733.1863.90372.2987l.00249.0008c.11983.0413.24534.0845.379.1299.2989.1015.6242.2088.9892.3185V9.62992Zm2-.00374V20.7551c.5531-.1678 1.0379-.3374 1.4545-.4832.2956-.1034.5575-.1951.7846-.2653.7257-.2245 1.4655-.3734 2.7479-.3566.5019.0065.9806-.1791 1.3407-.4788.3618-.3011.6723-.781.6723-1.3828V10.5c0-.58114-.2923-1.05022-.6377-1.3503-.3441-.29904-.8047-.49168-1.2944-.49929-2.2667-.0352-3.386.36906-4.6847.83812-.1256.04539-.253.09138-.3832.13765Z" />
                </svg>
            </div>
            <div class="ml-5">
                <p class="text-base font-medium text-gray-600 dark:text-gray-400">Asignaturas</p>
                <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{$asignaturasCount}}</h4>
            </div>
        </div>

        <!-- Tarjeta -->
        <div
            class="relative flex items-center p-6 rounded-xl border border-gray-200 bg-white  dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-yellow-100 dark:bg-yellow-700">
                <svg class="w-8 h-8 text-yellow-600 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
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

        <!-- Tarjeta -->
        <div
            class="relative flex items-center p-6 rounded-xl border border-gray-200 bg-white  dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-purple-100 dark:bg-purple-700">
                <svg class="w-8 h-8 text-purple-600 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12.8638 3.49613C12.6846 3.18891 12.3557 3 12 3s-.6846.18891-.8638.49613l-3.49998 6c-.18042.30929-.1817.69147-.00336 1.00197S8.14193 11 8.5 11h7c.3581 0 .6888-.1914.8671-.5019.1784-.3105.1771-.69268-.0033-1.00197l-3.5-6ZM4 13c-.55228 0-1 .4477-1 1v6c0 .5523.44772 1 1 1h6c.5523 0 1-.4477 1-1v-6c0-.5523-.4477-1-1-1H4Zm12.5-1c-2.4853 0-4.5 2.0147-4.5 4.5s2.0147 4.5 4.5 4.5 4.5-2.0147 4.5-4.5-2.0147-4.5-4.5-4.5Z" />
                </svg>

            </div>
            <div class="ml-5">
                <p class="text-base font-medium text-gray-600 dark:text-gray-400">Programas</p>
                <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{$programasCount}}</h4>
            </div>
        </div>

        <!-- Tarjeta -->
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

    </div>
    <div class="mt-2 grid gap-4 sm:mt-2 lg:grid-cols-3 lg:grid-rows-2 p-1">
        <div class="relative lg:row-span-2">
            <div
                class="absolute inset-px rounded-lg border border-gray-200 bg-white  dark:border-gray-700 dark:bg-gray-800 lg:rounded-l-[2rem]">
            </div>
            <div
                class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)] lg:rounded-l-[calc(2rem+1px)]">
                <div class="px-8 pt-4 pb-3 sm:px-10 sm:pt-8 sm:pb-0">
                    <!-- Lista de últimas matrículas -->
                    <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white pe-1">Últimas Matrículas
                    </h5>
                    <ul class="max-w-md mt-6 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentMatriculas as $matricula)
                            <li class="pb-3 pt-3 sm:pb-4">
                                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                    <div class="shrink-0">
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
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ $matricula->estudiante->nombre ?? '' }}
                                            {{ $matricula->estudiante->apellido ?? '' }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            {{ $matricula->programaFormacion->nombre ?? 'N/A' }}
                                        </p>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($matricula->created_at)->format('d-m-Y') }}
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="text-gray-500 dark:text-gray-400">No se encontraron matrículas recientes.</li>
                        @endforelse
                    </ul>

                </div>
            </div>
            <div
                class="pointer-events-none absolute inset-px rounded-lg ring-1 shadow-sm ring-black/5 lg:rounded-l-[2rem]">
            </div>
        </div>
        <div class="relative max-lg:row-start-1">
            <div
                class="absolute inset-px rounded-lg border border-gray-200 bg-white  dark:border-gray-700 dark:bg-gray-800 max-lg:rounded-t-[2rem]">
            </div>
            <div
                class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)] max-lg:rounded-t-[calc(2rem+1px)]">

                <div class="max-w-sm w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">

                    <div class="flex justify-between mb-3">
                        <div class="flex justify-center items-center">
                            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white pe-1">Estudiantes
                            </h5>
                        </div>
                        <div>
                            <button type="button" data-tooltip-target="data-tooltip" data-tooltip-placement="bottom"
                                class="hidden sm:inline-flex items-center justify-center text-gray-500 w-8 h-8 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm"><svg
                                    class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 16 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 1v11m0 0 4-4m-4 4L4 8m11 4v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3" />
                                </svg><span class="sr-only">Download data</span>
                            </button>
                            <div id="data-tooltip" role="tooltip"
                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                Download CSV
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                    </div>
                    <!-- Donut Chart -->
                    <div class="py-6 text-white dark:text-gray-300" id="donut-chart"></div>
                </div>
            </div>
            <div
                class="pointer-events-none absolute inset-px rounded-lg ring-1 shadow-sm ring-black/5 max-lg:rounded-t-[2rem]">
            </div>
        </div>
        <div class="relative max-lg:row-start-3 lg:col-start-2 lg:row-start-2">
            <div
                class="absolute inset-px rounded-lg border border-gray-200 bg-white  dark:border-gray-700 dark:bg-gray-800">
            </div>
            <div class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)]">
                <div class="px-8 pt-8 sm:px-10 sm:pt-10">
                    <p class="mt-2 text-lg font-medium tracking-tight text-gray-900 dark:text-white max-lg:text-center">
                        Security</p>
                    <p class="mt-2 max-w-lg text-sm/6 text-gray-700 dark:text-gray-400 max-lg:text-center">Morbi viverra
                        dui mi arcu sed.
                        Tellus semper adipiscing suspendisse semper morbi.</p>
                </div>
                <div class="container flex flex-1 items-center max-lg:py-6 lg:pb-2">
                    <img class="h-[min(152px,40cqw)] object-cover"
                        src="https://tailwindcss.com/plus-assets/img/component-images/bento-03-security.png" alt="">
                </div>
            </div>
            <div class="pointer-events-none absolute inset-px rounded-lg ring-1 shadow-sm ring-black/5"></div>
        </div>
        <div class="relative lg:row-span-2">
            <div
                class="absolute inset-px rounded-lg border border-gray-200 bg-white  dark:border-gray-700 dark:bg-gray-800 max-lg:rounded-b-[2rem] lg:rounded-r-[2rem]">
            </div>
            <div
                class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)] max-lg:rounded-b-[calc(2rem+1px)] lg:rounded-r-[calc(2rem+1px)]">
                <div class="px-8 pt-8 pb-3 sm:px-10 sm:pt-10 sm:pb-0">
                    <p class="mt-2 text-lg font-medium tracking-tight text-gray-900 dark:text-white max-lg:text-center">
                        Powerful APIs
                    </p>
                    <p class="mt-2 max-w-lg text-sm/6 text-gray-700 dark:text-gray-400 max-lg:text-center">Sit quis amet
                        rutrum tellus
                        ullamcorper ultricies libero dolor eget sem sodales gravida.</p>
                </div>
            </div>
            <div
                class="pointer-events-none absolute inset-px rounded-lg ring-1 shadow-sm ring-black/5 max-lg:rounded-b-[2rem] lg:rounded-r-[2rem]">
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Obtener los datos de Livewire
            let femenino = @json($data['femenino']);
            let masculino = @json($data['masculino']);

            // Configuración del gráfico con datos dinámicos
            const getChartOptions = () => {
                return {
                    series: [femenino, masculino], // 🔹 Datos dinámicos desde Livewire
                    colors: ["#E74694", "#16BDCA"],
                    chart: {
                        height: 320,
                        width: "100%",
                        type: "donut",
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
                        enabled: false,
                    },
                    legend: {
                        position: "bottom",
                    },
                };
            };

            // Renderizar el gráfico
            if (document.getElementById("donut-chart")) {
                const chart = new ApexCharts(document.getElementById("donut-chart"), getChartOptions());
                chart.render();

                // Escuchar cambios en Livewire y actualizar el gráfico
                Livewire.on('chartUpdated', (newData) => {
                    chart.updateSeries([newData.femenino, newData.masculino]);
                });
            }
        });
    </script>
</div>