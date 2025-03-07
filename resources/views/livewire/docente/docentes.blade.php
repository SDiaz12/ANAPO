<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    @if($isOpen)
        @include('livewire.docente.create')
    @endif
    <div class="flex flex-column bg-white dark:bg-gray-800 p-5 sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
        <div>
            <button wire:click="create()"
                class="bg-red-500 mr-4 hover:bg-red-600 text-white font-bold py-2 px-4 rounded my-3">Nuevo</button>

            <button id="dropdownRadioButton" data-dropdown-toggle="dropdownRadio"
                class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                type="button">
                <svg class="w-3 h-3 text-gray-500 dark:text-gray-400 me-3" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z" />
                </svg>
                Mostrar
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
                            <input  wire:click="loadMore({{5}})" id="filter-radio-example-1" type="radio" value="" name="filter-radio"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-radio-example-1"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">5 docentes</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input wire:click="loadMore({{10}})" checked="" id="filter-radio-example-2" type="radio" value="" name="filter-radio"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-radio-example-2"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">10 docentes</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input wire:click="loadMore({{15}})" id="filter-radio-example-3" type="radio" value="" name="filter-radio"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-radio-example-3"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">15 docentes</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input wire:click="loadMore({{25}})" id="filter-radio-example-4" type="radio" value="" name="filter-radio"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-radio-example-4"
                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">25 docentes</label>
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
                class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Buscar docente">
        </div>
    </div>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    #
                </th>
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
            @foreach($docentes as $docente)
            <tr
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $docente->id }}
                </th>
                <td class="px-6 py-4">
                    {{ $docente->codigo }}
                </td>
                <td class="px-6 py-4">
                    {{ $docente->dni }}
                </td>
                <td class="px-6 py-4">
                    {{ $docente->foto }}
                </td>
                <td class="px-6 py-4">
                    {{ $docente->nombre }} {{ $docente->apellido }}
                </td>
                <td class="px-6 py-4">
                    {{ $docente->fecha_nacimiento }}
                </td>
                <td class="px-6 py-4">
                    {{ $docente->sexo }}
                </td>
                <td class="px-6 py-4">
                    {{ $docente->residencia }}
                </td>
                <td class="px-6 py-4">
                    {{ $docente->telefono }}
                </td>
                <td class="px-6 py-4">
                    {{ $docente->correo }}
                </td>
                <td class="px-6 py-4">
                    <label class="inline-flex items-center me-5 cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer" wire:model.live="estado" checked>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-orange-300 dark:peer-focus:ring-orange-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-orange-500 dark:peer-checked:bg-orange-500"></div>
                        <span class="ms-3 text-sm font-medium">Activo</span>
                    </label>
                </td>
                <td class="px-6 py-4">
                    <x-button wire:click="edit({{ $docente->id }})"
                        class="mb-1 px-3 py-2 text-sm font-medium text-white inline-flex items-center bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-300 rounded-lg text-center dark:bg-yellow-500 dark:hover:bg-yellow-600 dark:focus:ring-yellow-800">
                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                        </svg>


                        Editar
                    </x-button>
                    <x-button wire:click="confirmDelete({{ $docente->id }})"
                        class="px-3 py-2 text-sm font-medium text-white inline-flex items-center bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800">
                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                        </svg>

                        Borrar
                    </x-button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="p-5 bg-white border-t dark:bg-gray-800 dark:border-gray-600 border-gray-200">
        <br>
        {{ $docentes->links() }}
        <br>
    </div>
</div>