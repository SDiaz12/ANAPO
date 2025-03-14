<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    @if (session()->has('message'))
        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
            <div class="flex">
                <div>
                    <p class="text-sm">{{ session('message') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if($isOpen)
        @include('livewire.matricula.create')
    @endif

    <!-- Contenedor principal -->
    <div class="lg:flex lg:items-start lg:justify-start">
        <!-- Tabla de matrículas -->
        <div class="w-full relative overflow-x-auto">
            <div class="shadow-md sm:rounded-lg">
                <div class="flex rounded-t-lg items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 p-4 bg-white dark:bg-gray-800">
                    <div class="flex items-center space-x-2">
                        <button wire:click="create()"
                            class="bg-red-600 mr-2 flex hover:bg-red-700 text-white font-bold py-2 px-2 rounded my-3">
                            <svg class="w-6 h-6 mr-1 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z" clip-rule="evenodd"/>
                              </svg>
                               Nueva Matricula
                        </button>
                        
                        <button id="dropdownRadioButton" data-dropdown-toggle="dropdownRadio"
                            class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                            type="button">
                            {{ $perPage }}
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 4 4 4-4" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdownRadio"
                            class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600"
                            data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="top"
                            style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(522.5px, 3847.5px, 0px);">
                            <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownRadioButton">
                                <li>
                                    <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <input wire:click="loadMore({{10}})" checked="" id="filter-radio-example-2" type="radio" value="" name="filter-radio"
                                            class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="filter-radio-example-2"
                                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">10 matriculas</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <input wire:click="loadMore({{20}})" id="filter-radio-example-3" type="radio" value="" name="filter-radio"
                                            class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="filter-radio-example-3"
                                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">20 matriculas</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <input wire:click="loadMore({{30}})" id="filter-radio-example-4" type="radio" value="" name="filter-radio"
                                            class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="filter-radio-example-4"
                                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">30 matriculas</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <input wire:click="loadMore({{$matriculasCount}})" id="filter-radio-example-4" type="radio" value="" name="filter-radio"
                                            class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="filter-radio-example-4"
                                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">Todas matriculas</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="table-search-users" wire:model.live="search"
                            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                            placeholder="Buscar matricula">
                    </div>
                </div>
                <div class="relative overflow-x-auto scrollbar-hidden">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Estudiante</th>
                                <th scope="col" class="px-6 py-3">Fecha</th>
                                <th scope="col" class="px-6 py-3">Programa</th>
                                <th scope="col" class="px-6 py-3">Instituto</th>
                                <th scope="col" class="px-6 py-3">Estado</th>
                                <th scope="col" class="px-6 py-3">Motivo</th>
                                <th scope="col" class="px-6 py-3">Observaciones</th>
                                <th scope="col" class="px-6 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($matriculas as $matricula)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                    @if($matricula->estudiante->foto)
                                        <img src="{{ asset('storage/' . $matricula->estudiante->foto) }}" alt="foto estudiante" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <img class="w-10 h-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ $matricula->estudiante->nombre }}&amp;color=000&amp;background=facc15">
                                    @endif
                                    <div class="ps-3">
                                        <div class="text-base font-semibold">{{ $matricula->estudiante->nombre }} {{ $matricula->estudiante->apellido }}</div>
                                        <div class="font-normal text-gray-500">Código: {{ $matricula->estudiante->codigo }}</div>
                                        <div class="font-normal text-gray-500">DNI: {{ $matricula->estudiante->dni }}</div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">{{ $matricula->fecha_matricula }}</td>
                                <td class="px-6 py-4">{{ $matricula->programaFormacion->nombre }}</td>
                                <td class="px-6 py-4">{{ $matricula->instituto }}</td>
                                <td class="px-6 py-4">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer" wire:click="toggleEstado({{ $matricula->id }})" {{ $matricula->estado ? 'checked' : '' }}>
                                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-500"></div>
                                        <span class="ml-3 text-gray-700 dark:text-gray-400">{{ $matricula->estado ? 'Habilitada' : 'Desabilitada' }}</span>
                                    </label>
                                </td>
                                <td class="px-6 py-4">{{ $matricula->motivo }}</td>
                                <td class="px-6 py-4">{{ $matricula->observaciones }}</td>
                                <td class="px-6 py-4">
                                    <button wire:click="edit({{ $matricula->id }})"
                                        class="mb-1 px-3 py-2 text-sm font-medium text-white inline-flex items-center bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                        </svg>
                                        Editar
                                    </button>
                                    <button wire:click="confirmDelete({{ $matricula->id }})"
                                        class="px-3 py-2 text-sm font-medium text-white inline-flex items-center bg-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg text-center dark:bg-gray-700 dark:hover:bg-gray-800 dark:focus:ring-gray-800">
                                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                        Borrar
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="py-2 px-4 border-y border-gray-200 dark:border-gray-700 dark:text-gray-400 text-gray-700" colspan="7">No hay matrículas registradas</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="px-5 bg-white border-t rounded-b-lg dark:bg-gray-800 dark:border-gray-600 border-gray-200">
                <br>
                {{ $matriculas->links() }}
                <br>
            </div>
        </div>
    </div>
</div>