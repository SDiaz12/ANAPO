<div>
    @if($isOpen)
        @include('livewire.docente.create')
    @endif

    @if ($isOpenDatos)
        @include('livewire.docente.datosDocentes')
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
                    d="M6 2c-1.10457 0-2 .89543-2 2v4c0 .55228.44772 1 1 1s1-.44772 1-1V4h12v7h-2c-.5523 0-1 .4477-1 1v2h-1c-.5523 0-1 .4477-1 1s.4477 1 1 1h5c.5523 0 1-.4477 1-1V3.85714C20 2.98529 19.3667 2 18.268 2H6Z" />
                 <path
                    d="M6 11.5C6 9.567 7.567 8 9.5 8S13 9.567 13 11.5 11.433 15 9.5 15 6 13.433 6 11.5ZM4 20c0-2.2091 1.79086-4 4-4h3c2.2091 0 4 1.7909 4 4 0 1.1046-.8954 2-2 2H6c-1.10457 0-2-.8954-2-2Z" />
                  </svg>
                  Docentes
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
                            <input wire:click="loadMore({{$docentesCount}})" id="filter-radio-example-4" type="radio" value="" name="filter-radio"
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
                placeholder="Buscar docente">
        </div>
    </div>
    <div class="relative overflow-x-auto scrollbar-hidden">
        @if($viewMode === 'table')
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Código
                        </th>
                        <th scope="col" class="px-6 py-3">
                            DNI
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Foto
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nacimiento
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Sexo
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Residencia
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Teléfono
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Correo
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($docentes as $docente)
                    <tr
                        class=" overflow-x-auto cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td wire:click="mostrarDatos({{ $docente->id }})" class="px-6 py-4">
                            {{ $docente->codigo }}
                        </td>
                        <td wire:click="mostrarDatos({{ $docente->id }})" class="px-6 py-4">
                            {{ $docente->dni }}
                        </td>
                        <td wire:click="mostrarDatos({{ $docente->id }})" class="px-6 py-4">
                            @if($docente->foto)
                                <img src="{{ asset('storage/' . $docente->foto) }}"
                                alt="foto docente" class="w-12 h-12 rounded-full object-cover">
                            @else
                            <img class="w-12 h-12 object-cover rounded-full"
                                src="https://ui-avatars.com/api/?name={{ $docente->nombre }}&amp;color=000&amp;background=facc15">
                            @endif
                        </td>
                        <td wire:click="mostrarDatos({{ $docente->id }})" class="px-6 py-4">
                            {{ $docente->nombre }} {{ $docente->apellido }}
                        </td>
                        <td wire:click="mostrarDatos({{ $docente->id }})" class="px-6 py-4">
                            {{ $docente->fecha_nacimiento }}
                        </td>
                        <td wire:click="mostrarDatos({{ $docente->id }})" class="px-6 py-4">
                            {{ $docente->sexo }}
                        </td>
                        <td wire:click="mostrarDatos({{ $docente->id }})" class="px-6 py-4">
                            {{ $docente->residencia }}
                        </td>
                        <td wire:click="mostrarDatos({{ $docente->id }})" class="px-6 py-4">
                            {{ $docente->telefono }}
                        </td>
                        <td wire:click="mostrarDatos({{ $docente->id }})" class="px-6 py-4">
                            {{ $docente->correo }}
                        </td>
                        <td class="px-6 py-4">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer"
                                    wire:click="toggleEstado({{ $docente->id }})"
                                    {{ $docente->estado ? 'checked' : '' }}>
                                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 
                                    peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-700 
                                    peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full 
                                    peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 
                                    after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full 
                                    after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600">
                                </div>
                                <span class="ml-3 text-gray-700 dark:text-gray-400">
                                    {{ $docente->estado ? 'Activo' : 'Inactivo' }}
                            </label>
                        </td>
                        <td class="px-6 py-4">
                            <button wire:click="edit({{ $docente->id }})"
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
                            <button wire:click="confirmDelete({{ $docente->id }})"
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
                        <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 text-gray-700" colspan="5">No hay docentes registrados</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        @endif
    
    
        @if($viewMode === 'cards')
        <!-- Tarjetas en lugar de la tabla -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 p-5">
            @foreach($docentes as $docente)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                    <!-- Contenedor de la imagen -->
                    <div class="relative h-56 w-full">
                        @if($docente->foto)
                            <img src="{{ asset('storage/' . $docente->foto) }}" alt="foto docente" class="w-full h-full object-cover">
                        @else
                            <img class="h-full w-full object-cover"
                                src="https://ui-avatars.com/api/?name={{ $docente->nombre }}&amp;color=000&amp;background=facc15">
                        @endif
                        <!-- Toggle encima de la imagen -->
                        <label class="absolute top-2 right-2 inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer"
                                wire:click="toggleEstado({{ $docente->id }})"
                                {{ $docente->estado ? 'checked' : '' }}>
                            <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 
                                peer-focus:ring-4 peer-focus:ring-red-500 dark:peer-focus:ring-red-700 
                                peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full 
                                peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 
                                after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full 
                                after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600">
                            </div>
                        </label>
                    </div>
        
                    <!-- Contenido de la tarjeta -->
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $docente->nombre }} {{ $docente->apellido }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-bold text-md text-gray-800 dark:text-gray-300">Código: </span>{{ $docente->codigo }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-bold text-md text-gray-800 dark:text-gray-300">DNI:</span> {{ $docente->dni }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-bold text-md text-gray-800 dark:text-gray-300">Nacimiento:</span> {{ $docente->fecha_nacimiento }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-bold text-md text-gray-800 dark:text-gray-300">Sexo:</span> {{ $docente->sexo }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-bold text-md text-gray-800 dark:text-gray-300">Residencia:</span> {{ $docente->residencia }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-bold text-md text-gray-800 dark:text-gray-300">Teléfono:</span> {{ $docente->telefono }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-bold text-md text-gray-800 dark:text-gray-300">Correo:</span> {{ $docente->correo }}</p>
                    </div>
        
                    <!-- Botones de acción -->
                    <div class="px-4 pb-4 flex space-x-2">
                        <button wire:click="edit({{ $docente->id }})"
                            class="flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                            </svg>
                            Editar
                        </button>
                        <button wire:click="confirmDelete({{ $docente->id }})"
                            class="flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                            <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                            </svg>
                            Borrar
                        </button>
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
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estás seguro de que deseas eliminar al docente: "<strong>{{ $nombreAEliminar }}</strong>"? <br>Esta
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
        {{ $docentes->links() }}
        <br>
    </div>
</div>

