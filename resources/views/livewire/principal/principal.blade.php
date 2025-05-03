<div>
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