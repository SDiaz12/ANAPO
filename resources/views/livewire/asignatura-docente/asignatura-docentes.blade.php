<div>
    @if($isOpen)
    @include('livewire.asignatura-docente.create')
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
                <path
                              d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z" />
              </svg>
              Asignación Asignaturas
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
        <div class="relative overflow-x-auto">
    @if ($viewMode === 'table') <!-- If View Mode is Table -->
        <!-- Table View -->
        <div class="relative overflow-x-auto scrollbar-hidden">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">DNI</th>
                        <th scope="col" class="px-6 py-3">Nombre Docente</th>
                        <th scope="col" class="px-6 py-3">Asignatura</th>
                        <th scope="col" class="px-6 py-3">Estado</th>
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asignaturasDocentes as $asignaturaDocente)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $asignaturaDocente->id }}</td>
                        <td class="px-6 py-4">{{ $asignaturaDocente->docente->dni }}</td>
                        <td class="px-6 py-4">{{ $asignaturaDocente->docente->nombre }}</td>
                        <td class="px-6 py-4">{{ $asignaturaDocente->asignatura->nombre }}</td>
                        <td class="px-6 py-4">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer"
                                    wire:click="toggleEstado({{ $asignaturaDocente->id }})"
                                    {{ $asignaturaDocente->estado ? 'checked' : '' }}>
                                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 
                                    peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 
                                    peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full 
                                    peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 
                                    after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full 
                                    after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-500">
                                </div>
                            </label>
                        </td>
                        <td class="px-6 py-4">
                          
                        <button wire:click="confirmDelete({{ $asignaturaDocente->id }})"
                            class="mb-1 px-4 py-2 text-sm font-medium text-white bg-gray-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg dark:bg-gray-600 dark:hover:bg-red-600 dark:focus:ring-red-800 flex items-center transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6M12 18l-6-6m0 0l6-6" />
                            </svg>
                            Eliminar Asignación
                        </button>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if($viewMode === 'cards')
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 p-5">
            @foreach($asignaturasDocentes as $asignaturaDocente)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                    <div class="relative h-56 w-full">
                        <img class="h-full w-full object-cover"
                            src="https://ui-avatars.com/api/?name={{ $asignaturaDocente->docente->nombre }}&amp;color=000&amp;background=facc15">
                    </div>

                    <!-- Contenido de la tarjeta -->
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $asignaturaDocente->docente->nombre}}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-bold text-md text-gray-800 dark:text-gray-300">Asignatura: </span>{{ $asignaturaDocente->asignatura->nombre }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-bold text-md text-gray-800 dark:text-gray-300">Sección: </span>{{ $asignaturaDocente->seccion->nombre}}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-bold text-md text-gray-800 dark:text-gray-300">Periodo: </span>{{ $asignaturaDocente->periodo->nombre}}</p>
                        <div class="mt-2">
                           
                        <button wire:click="confirmDelete({{ $asignaturaDocente->id }})"
                            class="mb-1 px-3 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                           Eliminar Asignación
                        </button>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
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
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estás seguro de que deseas des-asignarle la clase al docente: "<strong>{{ $docenteAEliminar}}</strong>"? <br>Esta
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
    {{ $asignaturasDocentes->links() }}
    <br>
</div>
</div>
