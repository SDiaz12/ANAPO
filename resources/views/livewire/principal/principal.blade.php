<div>
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <div class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400">
                  <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                    d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                 <path
                    d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                  </svg>
                  Principal
                </div>
              </li>
        </ol>
    </nav>
    @if(auth()->check())
        @if (auth()->user()->hasPermissionTo('ver-dashboard-admin'))
            @livewire('principal.inicioadmin')
        @endif

        @if (auth()->user()->hasPermissionTo('ver-dashboard-docente'))
            @livewire('principal.iniciodocente')
        @endif

        @if (auth()->user()->hasPermissionTo('ver-dashboard-estudiante'))
            @livewire('principal.inicioestudiante')
        @endif
        {{-- Fallback si ningún permiso coincide --}}
        @if(!auth()->user()->hasAnyPermission(['ver-dashboard-admin', 'ver-dashboard-docente', 'ver-dashboard-estudiante']))
            <div class="p-4">
                <h2 class="text-xl font-bold">Bienvenido al sistema</h2>
                <p>No tienes permisos específicos configurados.</p>

                {{-- Mostrar los permisos que tiene el usuario --}}
                <div class="mt-4">
                    <h3 class="font-bold">Tus permisos:</h3>
                    <ul>
                        @foreach(auth()->user()->getAllPermissions() as $permission)
                            <li>{{ $permission->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    @else
        <div>Por favor inicia sesión para acceder al sistema.</div>
    @endif


</div>