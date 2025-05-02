<div class="fixed z-50 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full dark:bg-gray-900"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="flex justify-between items-center p-4 md:p-5 mb-1 rounded-t border-b dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $docente_id ? 'Editar docente' : 'Crear docente' }}
                </h3>
                <button wire:click="closeModal()" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form class="p-4 md:p-5">
                <div class="mb-5">
                    <div class="flex">
                        <label class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300"
                            for="file_input">Fotografía del docente:</label>
                        @if ($foto instanceof \Illuminate\Http\UploadedFile)
                            <img class="rounded-sm p-2 ml-8 w-42 h-36 object-cover " src="{{ $foto->temporaryUrl() }}"
                                alt="Extra large avatar">
                        @else
                            <p></p>
                        @endif
                    </div>
                    <input wire:model="foto"
                        class="block w-full text-lg text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        aria-describedby="file_input_help" id="file_input" type="file">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG ó JPG (MAX.
                        800x400px).
                    </p>

                </div>
<!-- Campos del usuario -->
<div class="mb-4">
    <label for="user_email" class="block text-gray-700 text-sm font-bold mb-2">Email del usuario:</label>
    <input type="email" wire:model="user_email" id="user_email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    @error('user_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
</div>

<div class="mb-4">
    <label for="user_password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña:</label>
    <input type="password" wire:model="user_password" id="user_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    @error('user_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
</div>

<div class="mb-4">
    <label for="user_password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirmar contraseña:</label>
    <input type="password" wire:model="user_password_confirmation" id="user_password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
</div>
                <div class="-mx-3 flex flex-wrap">
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label for="date" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                                Código:
                            </label>
                            <input type="text" name="codigo" id="codigo" placeholder="Código de docente"
                                wire:model="codigo"
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            @error('codigo') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label for="time" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                                DNI:
                            </label>
                            <input type="text" name="dni" id="dni" placeholder="DNI del docente" wire:model="dni"
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            @error('dni') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-5">
                    <label for="nombre" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                        Nombres:
                    </label>
                    <input type="text" name="nombre" id="nombre" placeholder="Nombres del docente" wire:model="nombre"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('nombre') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mb-5">
                    <label for="email" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                        Apellidos:
                    </label>
                    <input type="apellido" name="apellido" id="apellido" placeholder="Apellidos del docente"
                        wire:model="apellido"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('apellido') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="-mx-3 flex flex-wrap">
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label for="date" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                                Fecha Nacimiento:
                            </label>
                            <input type="date" name="date" id="date" wire:model="fecha_nacimiento"
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            @error('fecha_nacimiento') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label class="block text-sm mb-4 font-medium text-gray-700 dark:text-gray-300">Sexo:</label>
                            <select
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md"
                                id="sexo" name="sexo" wire:model.live="sexo" required>
                                <option value="">Seleccione el sexo</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Maculino">Masculino</option>
                            </select>
                            @error('sexo') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label for="date" class="mb-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Teléfono:
                            </label>
                            <input type="text" name="area" id="area" placeholder="Ingrese teléfono"
                                wire:model="telefono"
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            @error('telefono') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                            <label for="date" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                                Correo electrónico:
                            </label>
                            <input type="email" name="correo" id="correo" placeholder="Ingrese correo" wire:model="correo"
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            @error('correo') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <label for="email" class="mb-3 block text-base font-medium text-gray-700 dark:text-gray-300">
                        Residencia:
                    </label>
                    <textarea type="email" name="email" id="email" placeholder="Residencia del docente"
                        wire:model="residencia"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-6 text-base font-medium text-gray-700 dark:text-gray-300 outline-none focus:border-[#6A64F1] focus:shadow-md"></textarea>
                    @error('residencia') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <x-button wire:click.prevent="store()" wire:loading.attr="disabled" wire:target="foto" type="button" class="w-full">
                        {{ $docente_id ? 'Editar docente' : 'Crear docente' }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>