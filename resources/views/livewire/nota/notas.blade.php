<div>
    @if($isOpen)
        @include('livewire.nota.create')
    @endif

    @if (session()->has('message'))
    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
        <div class="flex">
            <div>
                <p class="text-sm">{{ session('message') }}</p>
            </div>
        </div>
    </div>
@endif
    <div class="flex flex-column bg-white rounded-t-lg dark:bg-gray-800 p-5 sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
        <div class="flex items-center space-x-2">
            
            
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
            
            <button wire:click="toggleViewMode"
            class="inline-flex items-center ml-2 text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
            type="button">
                    <!-- Icono y texto cambian según la vista -->
                    @if ($viewMode === 'table')
                      <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6Zm2 8v-2h7v2H4Zm0 2v2h7v-2H4Zm9 2h7v-2h-7v2Zm7-4v-2h-7v2h7Z" clip-rule="evenodd"/>
                      </svg>  
                    @else
                    <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M4.857 3A1.857 1.857 0 0 0 3 4.857v4.286C3 10.169 3.831 11 4.857 11h4.286A1.857 1.857 0 0 0 11 9.143V4.857A1.857 1.857 0 0 0 9.143 3H4.857Zm10 0A1.857 1.857 0 0 0 13 4.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 9.143V4.857A1.857 1.857 0 0 0 19.143 3h-4.286Zm-10 10A1.857 1.857 0 0 0 3 14.857v4.286C3 20.169 3.831 21 4.857 21h4.286A1.857 1.857 0 0 0 11 19.143v-4.286A1.857 1.857 0 0 0 9.143 13H4.857Zm10 0A1.857 1.857 0 0 0 13 14.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 19.143v-4.286A1.857 1.857 0 0 0 19.143 13h-4.286Z" clip-rule="evenodd"/>
                      </svg>  
                    @endif
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
                            <input wire:click="loadMore({{9}})" checked="" id="filter-radio-example-2" type="radio" value="" name="filter-radio"
                                class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-radio-example-2"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">9 asignaturas</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input wire:click="loadMore({{15}})" id="filter-radio-example-3" type="radio" value="" name="filter-radio"
                                class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-radio-example-3"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">15 asignaturas</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input wire:click="loadMore({{24}})" id="filter-radio-example-4" type="radio" value="" name="filter-radio"
                                class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-radio-example-4"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">24 asignaturas</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input wire:click="loadMore({{36}})" id="filter-radio-example-4" type="radio" value="" name="filter-radio"
                                class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-radio-example-4"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">36 asignaturas</label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <input wire:model.live="search" type="text" id="table-search"
                class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                placeholder="Buscar asignatura">
        </div>
    </div>

    @if ($viewMode === 'table')
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                   
                        <th class="py-2 px-4">Código</th>
                        <th class="py-2 px-4">Nombre</th>
                        <th class="py-2 px-4">UV</th>
                        <th class="py-2 px-4">Docente</th>
                        <th class="py-2 px-4">Duración</th>
                        <th class="py-2 px-4">Estudiantes</th>
                        <th class="py-2 px-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asignaturas as $asignatura)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                           
                            <td class="py-2 px-4">{{ $asignatura->asignaturadocente->asignatura->codigo }}</td>
                            <td class="py-2 px-4">{{ $asignatura->asignaturadocente->asignatura->nombre }}</td>
                            <td class="py-2 px-4">{{ $asignatura->asignaturadocente->asignatura->creditos }}</td>
                            <td class="py-2 px-4">{{ $asignatura->asignaturadocente->docente->nombre }}</td>
                            <td class="py-2 px-4">{{ $asignatura->asignaturadocente->asignatura->horas }}</td>
                            <td class="py-2 px-4">{{ $asignatura->estudiantes_count }}</td>
                            <td class="py-2 px-4 flex space-x-1">
                            <button wire:click="create('{{ $asignatura->asignaturadocente->asignatura->codigo }}', '{{ $asignatura->asignaturadocente->docente->codigo }}')" 
                                    class="bg-blue-500 text-white px-2 py-1 rounded-md text-xs hover:bg-blue-600 shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105">
                                ✏️ Agregar
                            </button>
                                <button wire:click="verNotas({{ $asignatura->id }})" class="bg-gray-600 text-white px-2 py-1 rounded-md text-xs hover:bg-gray-700 shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105">
                                    📖 Ver
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-5">
            @foreach ($asignaturas as $asignatura)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                    <div class="flex items-center justify-center w-16 h-16 bg-blue-500 text-white text-xl font-bold rounded-full mx-auto">
                        {{ substr($asignatura->asignaturadocente->asignatura->nombre, 0, 2) }}
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white text-center mt-2">{{ $asignatura->asignaturadocente->asignatura->nombre }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">UV: {{ $asignatura->asignaturadocente->asignatura->creditos }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Docente: {{ $asignatura->asignaturadocente->docente->nombre }} horas</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Duración: {{ $asignatura->asignaturadocente->asignatura->horas }} horas</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Estudiantes: {{ $asignatura->estudiantes_count }}</p>
                    <div class="mt-3 flex space-x-1">
                        <button wire:click="create('{{ $asignatura->asignaturadocente->asignatura->codigo }}', '{{ $asignatura->asignaturadocente->docente->codigo }}')" 
                                    class="bg-blue-500 text-white px-2 py-1 rounded-md text-xs hover:bg-blue-600 shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105">
                                ✏️ Agregar
                            </button>
                                <button wire:click="verNotas({{ $asignatura->id }})" class="bg-gray-600 text-white px-2 py-1 rounded-md text-xs hover:bg-gray-700 shadow-sm transition-all duration-200 ease-in-out transform hover:scale-105">
                                    📖 Ver
                                </button>
                            </td>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="px-5 bg-white border-t rounded-b-lg dark:bg-gray-800 dark:border-gray-600 border-gray-200">
        <br>
        {{ $asignaturas->links() }}
        <br>
    </div>
</div>
