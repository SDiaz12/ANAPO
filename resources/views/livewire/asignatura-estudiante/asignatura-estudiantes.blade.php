<div>
    @if($isOpen)
        @include('livewire.asignatura-estudiante.create')
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
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <div class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400">
                  <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z"
                        clip-rule="evenodd" />
                  </svg>
                  Matricular Asignatura
                </div>
              </li>
        </ol>
    </nav>
    <div class="flex flex-column bg-white rounded-t-lg dark:bg-gray-800 p-5 sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
        <div class="flex items-center space-x-2">
            <button wire:click="create()"
                class="bg-red-600 mr-2 flex hover:bg-red-700 text-white font-bold py-2 px-2 rounded my-3">
                <svg class="w-6 h-6 mr-1 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z" clip-rule="evenodd"/>
                  </svg>
                   Nuevo
            </button>
            
            <!-- Dropdown menu -->
            <div id="dropdownRadio"
                class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow-xl border dark:border-gray-600 dark:bg-gray-700 dark:divide-gray-600"
                data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="top"
                style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(522.5px, 3847.5px, 0px);">
                <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200"
                    aria-labelledby="dropdownRadioButton">
                    <li>
                        <div class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input wire:click="loadMore({{10}})" checked="" id="filter-radio-example-2" type="radio" value="" name="filter-radio"
                                class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-radio-example-2"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">10 docentes</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input wire:click="loadMore({{20}})" id="filter-radio-example-3" type="radio" value="" name="filter-radio"
                                class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-radio-example-3"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">20 docentes</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex rounded-lg items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input wire:click="loadMore({{30}})" id="filter-radio-example-4" type="radio" value="" name="filter-radio"
                                class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-radio-example-4"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">30 docentes</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex rounded-lg items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input wire:click="loadMore({{$asignaturaestudianteCount}})" id="filter-radio-example-4" type="radio" value="" name="filter-radio"
                                class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-radio-example-4"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">Todos</label>
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
                placeholder="Buscar por asignatura o estudiante" aria-placeholder="Buscar por asignatura o estudiante">
        </div>
    </div>
    <div class="relative overflow-x-auto scrollbar-hidden">
       
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-2">
                        Código
                    </th>
                    <th scope="col" class="px-6 py-2">
                        Asignatura
                    </th>
                    <th scope="col" class="px-6 py-2">
                        Periodo
                    </th>
                    <th scope="col" class="px-6 py-2">
                        Estudiante
                    </th>
                    <th scope="col" class="px-6 py-2">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($asignaturaestudiantes as $asignaturaestudiante)
                <tr
                    class=" overflow-x-auto bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        {{ $asignaturaestudiante->asignatura->codigo }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $asignaturaestudiante->asignatura->nombre }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $asignaturaestudiante->periodo->nombre }}
                    </td>
                    <td scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                        @if($asignaturaestudiante->estudiante->foto)
                        <img src="{{ asset('storage/' . $asignaturaestudiante->estudiante->foto) }}" alt="foto estudiante" class="w-10 h-10 rounded-full object-cover">
                    @else
                        <img class="w-10 h-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ $asignaturaestudiante->estudiante->nombre }}&amp;color=000&amp;background=facc15">
                    @endif
                    <div class="ps-3">
                        <div class="text-base font-semibold">{{ $asignaturaestudiante->estudiante->nombre }} {{ $asignaturaestudiante->estudiante->apellido }}</div>
                        <div class="font-normal text-gray-500">Código: {{ $asignaturaestudiante->estudiante->codigo }}</div>
                    </div>
                    </td>
                    <td class="px-6 py-4">
                        <button wire:click="edit({{ $asignaturaestudiante->id }})"
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
                        <button wire:click="confirmDelete({{ $asignaturaestudiante->id }})"
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
            @endforeach
            </tbody>
        </table>

    @if (session()->has('error'))
    <div class="fixed z-50 inset-0 flex items-center justify-center overflow-y-auto ease-out duration-400">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
    
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <button wire:click="$set('confirmingDelete', false)" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 animate-bounce text-red-600 w-12 h-12 dark:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m6 6 12 12m3-6a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                      </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"><p>{{ session('error') }}</p></h3>
                    
                    <button wire:click="$set('confirmingDelete', false)" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
        @elseif ($confirmingDelete)
            <div class="fixed z-50 inset-0 flex items-center justify-center overflow-y-auto ease-out duration-400">
                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
    
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                        <button wire:click="$set('confirmingDelete', false)" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-4 md:p-5 text-center">
                            <svg class="mx-auto mb-4 animate-bounce text-red-600 w-12 h-12 dark:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estás seguro de que deseas eliminar la matricula de: "<strong>{{ $nombreAEliminar }}</strong>"? <br>Esta
                                acción no se puede deshacer.</h3>
                            <button wire:click="delete" type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Eliminar
                            </button>
                            <button wire:click="$set('confirmingDelete', false)" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-800 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="px-5 bg-white border-t rounded-b-lg dark:bg-gray-800 dark:border-gray-600 border-gray-200">
        <br>
        {{ $asignaturaestudiantes->links() }}
        <br>
    </div>
</div>


