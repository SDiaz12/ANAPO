<div>
   <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
      <div class="px-3 py-3 lg:px-5 lg:pl-3">
         <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
               <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                  type="button"
                  class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                  <span class="sr-only">Open sidebar</span>
                  <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                     <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                     </path>
                  </svg>
               </button>
               <a href="/dashboard" class="flex ms-2 md:me-24">
                  <img src="{{ asset('Logo/LOGO.png') }}" alt="Logo" height="50px" width="50px" />
                  <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">Academia
                     Nacional</span>
               </a>

            </div>
            <div class="flex items-center">
               <div class="flex items-center ms-3">
                  <div>
                     <button id="theme-toggle" type="button"
                        class="text-gray-500 mr-3 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none rounded-lg text-sm p-2.5">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                           xmlns="http://www.w3.org/2000/svg">
                           <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                           xmlns="http://www.w3.org/2000/svg">
                           <path
                              d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                              fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                     </button>
                  </div>
                  <div>
                     <button type="button"
                        class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-yellow-300 dark:focus:ring-gray-600"
                        aria-expanded="false" data-dropdown-toggle="dropdown-user">
                        <span class="sr-only">Open user menu</span>
                        @if (Auth::user()->profile_photo_path)
                     <img class="w-9 h-9 rounded-full object-cover"
                        src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}">
                  @else
               <img class="w-9 h-9 rounded-full object-cover"
                  src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&amp;color=fff&amp;background=ef4444"
                  alt="{{ Auth::user()->name }}">
            @endif
                     </button>
                  </div>
                  <div
                     class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                     id="dropdown-user">
                     <div class="px-4 py-3" role="none">
                        <p class="text-sm text-gray-900 dark:text-white" role="none">
                           {{ Auth::user()->name }}
                        </p>
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                           {{ Auth::user()->email }}
                        </p>
                     </div>
                     <ul class="py-1" role="none">
                        <li>
                           <x-dropdown-link href="{{ route('profile.show') }}">
                              {{ __('Cuenta') }}
                           </x-dropdown-link>
                        </li>
                        <li>
                           <form method="POST" action="{{ route('logout') }}" x-data>
                              @csrf

                              <x-dropdown-link href="{{ route('estudiante') }}"
                                 class="text-red-800 dark:text-gray-100 hover:bg-red-100 "
                                 @click.prevent="$root.submit();">
                                 {{ __('Cerrar Sesión') }}
                              </x-dropdown-link>
                           </form>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </nav>

   <aside id="logo-sidebar"
      class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
      aria-label="Sidebar">
      <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
         <ul class="space-y-2 font-medium">
            @can('estudiante-admin-dashboard')
            <li>
               <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')"
                  class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-gray-700 group">
                  <x-activeIcons :active="request()->routeIs('dashboard')" class="w-6 h-6 text-gray-800 dark:text-white"
                     aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                     viewBox="0 0 24 24">
                     <path fill-rule="evenodd"
                        d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                        clip-rule="evenodd" />
                  </x-activeIcons>
                  <span class="ms-3">Inicio</span>
               </x-nav-link>
            </li>
            @endcan
            
            <li>
               <x-nav-link href="{{ route('principal') }}" :active="request()->routeIs('principal')"
                  class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-gray-700 group">
                  <x-activeIcons :active="request()->routeIs('principal')" class="w-6 h-6" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                     <path
                        d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                     <path
                        d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                  </x-activeIcons>
                  <span class="ms-3">Principal</span>
               </x-nav-link>
            </li>
            
            @can('admin-admin-matricula')
            <li>
               <x-nav-link href="{{ route('matricula') }}" :active="request()->routeIs('matricula')"
                  class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-gray-700 group">
                  <x-activeIcons :active="request()->routeIs('matricula')" class="w-6 h-6 text-gray-800 dark:text-white"
                     aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                     viewBox="0 0 24 24">
                     <path fill-rule="evenodd"
                        d="M4 4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm10 5a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-8-5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm1.942 4a3 3 0 0 0-2.847 2.051l-.044.133-.004.012c-.042.126-.055.167-.042.195.006.013.02.023.038.039.032.025.08.064.146.155A1 1 0 0 0 6 17h6a1 1 0 0 0 .811-.415.713.713 0 0 1 .146-.155c.019-.016.031-.026.038-.04.014-.027 0-.068-.042-.194l-.004-.012-.044-.133A3 3 0 0 0 10.059 14H7.942Z"
                        clip-rule="evenodd" />
                  </x-activeIcons>

                  <span class="flex-1 ms-3 whitespace-nowrap">Matriculas</span>

               </x-nav-link>
            </li>
            @endcan
            @can('admin-admin-asignaturaestudiante')
            <li>
               <x-nav-link href="{{ route('asignaturaEstudiante') }}"
                  :active="request()->routeIs('asignaturaEstudiante')"
                  class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-gray-700 group">
                  <x-activeIcons :active="request()->routeIs('asignaturaEstudiante')"
                     class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                     <path fill-rule="evenodd"
                        d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z"
                        clip-rule="evenodd" />
                  </x-activeIcons>
                  <span class="flex-1 ms-3 whitespace-nowrap">Matricular Asignatura</span>
               </x-nav-link>
            </li>
            @endcan

            @can('admin-admin-asignatura')
            <li>
               <x-nav-link href="{{ route('asignatura') }}" :active="request()->routeIs('asignatura')"
                  class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-gray-700 group">
                  <x-activeIcons :active="request()->routeIs('asignatura')" class="w-6 h-6" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                     <path
                        d="M9 6c0-1.65685 1.3431-3 3-3s3 1.34315 3 3-1.3431 3-3 3-3-1.34315-3-3Zm2 3.62992c-.1263-.04413-.25-.08799-.3721-.13131-1.33928-.47482-2.49256-.88372-4.77995-.8482C4.84875 8.66593 4 9.46413 4 10.5v7.2884c0 1.0878.91948 1.8747 1.92888 1.8616 1.283-.0168 2.04625.1322 2.79671.3587.29285.0883.57733.1863.90372.2987l.00249.0008c.11983.0413.24534.0845.379.1299.2989.1015.6242.2088.9892.3185V9.62992Zm2-.00374V20.7551c.5531-.1678 1.0379-.3374 1.4545-.4832.2956-.1034.5575-.1951.7846-.2653.7257-.2245 1.4655-.3734 2.7479-.3566.5019.0065.9806-.1791 1.3407-.4788.3618-.3011.6723-.781.6723-1.3828V10.5c0-.58114-.2923-1.05022-.6377-1.3503-.3441-.29904-.8047-.49168-1.2944-.49929-2.2667-.0352-3.386.36906-4.6847.83812-.1256.04539-.253.09138-.3832.13765Z" />

                  </x-activeIcons>
                  <span class="flex-1 ms-3 whitespace-nowrap">Asignaturas</span>
               </x-nav-link>
            </li>
            @endcan
            @can('docente-admin-notas')
            <li>
            <x-nav-link href="{{ route('notas') }}" :active="request()->routeIs('notas')"
               class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-gray-700 group">
               <x-activeIcons :active="request()->routeIs('notas')" class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                  width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                   <path fill-rule="evenodd" d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Zm-1 9a1 1 0 1 0-2 0v2a1 1 0 1 0 2 0v-2Zm2-5a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1Zm4 4a1 1 0 1 0-2 0v3a1 1 0 1 0 2 0v-3Z" clip-rule="evenodd"/>
               </x-activeIcons>
               <span class="flex-1 ms-3 whitespace-nowrap">Notas</span>
            </x-nav-link>
         </li>
         @endcan
         @can('admin-admin-promocion')
         <li>
            <x-nav-link href="{{ route('promocion') }}" :active="request()->routeIs('promocion')"
               class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-gray-700 group">
               <x-activeIcons :active="request()->routeIs('promocion')" class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                  width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12.4472 4.10557c-.2815-.14076-.6129-.14076-.8944 0L2.76981 8.49706l9.21949 4.39024L21 8.38195l-8.5528-4.27638Z"/>
                  <path d="M5 17.2222v-5.448l6.5701 3.1286c.278.1325.6016.1293.8771-.0084L19 11.618v5.6042c0 .2857-.1229.5583-.3364.7481l-.0025.0022-.0041.0036-.0103.009-.0119.0101-.0181.0152c-.024.02-.0562.0462-.0965.0776-.0807.0627-.1942.1465-.3405.2441-.2926.195-.7171.4455-1.2736.6928C15.7905 19.5208 14.1527 20 12 20c-2.15265 0-3.79045-.4792-4.90614-.9751-.5565-.2473-.98098-.4978-1.27356-.6928-.14631-.0976-.2598-.1814-.34049-.2441-.04036-.0314-.07254-.0576-.09656-.0776-.01201-.01-.02198-.0185-.02991-.0253l-.01038-.009-.00404-.0036-.00174-.0015-.0008-.0007s-.00004 0 .00978-.0112l-.00009-.0012-.01043.0117C5.12215 17.7799 5 17.5079 5 17.2222Zm-3-6.8765 2 .9523V17c0 .5523-.44772 1-1 1s-1-.4477-1-1v-6.6543Z"/>
               </x-activeIcons>
                  <span class="flex-1 ms-3 whitespace-nowrap">Promoción</span>
            </x-nav-link>
         </li>
         @endcan
         @can('estudiante-admin-matricularasignatura')
         <li>
            <x-nav-link href="{{ route('matricula-asignaturas') }}" :active="request()->routeIs('matricula-asignaturas')"
               class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-gray-700 group">
               <x-activeIcons :active="request()->routeIs('matricula-asignaturas')" class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                  width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z" clip-rule="evenodd"/>
               </x-activeIcons>
                  <span class="flex-1 ms-3 whitespace-nowrap">Matricula</span>
            </x-nav-link>
         </li>
         @endcan
         
            @can('admin-admin-personas')
            <li>
               <button type="button"
                  class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-red-500 dark:text-white dark:hover:bg-gray-700"
                  id="dropdown3">
                  <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                     <path fill-rule="evenodd"
                        d="M9.586 2.586A2 2 0 0 1 11 2h2a2 2 0 0 1 2 2v.089l.473.196.063-.063a2.002 2.002 0 0 1 2.828 0l1.414 1.414a2 2 0 0 1 0 2.827l-.063.064.196.473H20a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-.089l-.196.473.063.063a2.002 2.002 0 0 1 0 2.828l-1.414 1.414a2 2 0 0 1-2.828 0l-.063-.063-.473.196V20a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-.089l-.473-.196-.063.063a2.002 2.002 0 0 1-2.828 0l-1.414-1.414a2 2 0 0 1 0-2.827l.063-.064L4.089 15H4a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2h.09l.195-.473-.063-.063a2 2 0 0 1 0-2.828l1.414-1.414a2 2 0 0 1 2.827 0l.064.063L9 4.089V4a2 2 0 0 1 .586-1.414ZM8 12a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z"
                        clip-rule="evenodd" />
                  </svg>
                  <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Personas</span>
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                  </svg>
               </button>
               <ul id="dropdown-menu3" class="hidden py-2 space-y-2 rounded-md">
                  <li>
                     @can('admin-admin-docente')
                   <x-nav-link href="{{ route('docente') }}" :active="request()->routeIs('docente')"
                     class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-gray-700 group">
                     <x-activeIcons :active="request()->routeIs('docente')" class="w-6 h-6 text-gray-800 dark:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                          d="M6 2c-1.10457 0-2 .89543-2 2v4c0 .55228.44772 1 1 1s1-.44772 1-1V4h12v7h-2c-.5523 0-1 .4477-1 1v2h-1c-.5523 0-1 .4477-1 1s.4477 1 1 1h5c.5523 0 1-.4477 1-1V3.85714C20 2.98529 19.3667 2 18.268 2H6Z" />
                        <path
                          d="M6 11.5C6 9.567 7.567 8 9.5 8S13 9.567 13 11.5 11.433 15 9.5 15 6 13.433 6 11.5ZM4 20c0-2.2091 1.79086-4 4-4h3c2.2091 0 4 1.7909 4 4 0 1.1046-.8954 2-2 2H6c-1.10457 0-2-.8954-2-2Z" />
                     </x-activeIcons>
                     <span class="flex-1 ms-3 whitespace-nowrap">Docentes</span>
                   </x-nav-link>
                @endcan
                     @can('admin-admin-estudiante')
                   <x-nav-link href="{{ route('estudiante') }}" :active="request()->routeIs('estudiante')"
                     class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-gray-700 group">
                     <x-activeIcons :active="request()->routeIs('estudiante')" class="w-6 h-6" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path
                          d="M12.4472 2.10557c-.2815-.14076-.6129-.14076-.8944 0L5.90482 4.92956l.37762.11119c.01131.00333.02257.00687.03376.0106L12 6.94594l5.6808-1.89361.3927-.13363-5.6263-2.81313ZM5 10V6.74803l.70053.20628L7 7.38747V10c0 .5523-.44772 1-1 1s-1-.4477-1-1Zm3-1c0-.42413.06601-.83285.18832-1.21643l3.49538 1.16514c.2053.06842.4272.06842.6325 0l3.4955-1.16514C15.934 8.16715 16 8.57587 16 9c0 2.2091-1.7909 4-4 4-2.20914 0-4-1.7909-4-4Z" />
                        <path
                          d="M14.2996 13.2767c.2332-.2289.5636-.3294.8847-.2692C17.379 13.4191 19 15.4884 19 17.6488v2.1525c0 1.2289-1.0315 2.1428-2.2 2.1428H7.2c-1.16849 0-2.2-.9139-2.2-2.1428v-2.1525c0-2.1409 1.59079-4.1893 3.75163-4.6288.32214-.0655.65589.0315.89274.2595l2.34883 2.2606 2.3064-2.2634Z" />
                     </x-activeIcons>

                     <span class="flex-1 ms-3 whitespace-nowrap">Estudiantes</span>
                   </x-nav-link>
                @endcan
                     @can('admin-admin-users')
                   <x-nav-link href="{{ route('users') }}" :active="request()->routeIs('users')"
                     class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-gray-700 group">
                     <x-activeIcons :active="request()->routeIs('users')" class="flex-shrink-0 w-6 h-6" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                          d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z"
                          clip-rule="evenodd" />
                     </x-activeIcons>
                     <span class="flex-1 ms-3 whitespace-nowrap">Usuarios</span>
                   </x-nav-link>
                @endcan
                     @can('admin-admin-rol')
                   <x-nav-link href="{{ route('rol') }}" :active="request()->routeIs('rol')"
                     class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-gray-700 group">
                     <x-activeIcons :active="request()->routeIs('rol')" class="flex-shrink-0 w-6 h-6" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                          d="M17 10v1.126c.367.095.714.24 1.032.428l.796-.797 1.415 1.415-.797.796c.188.318.333.665.428 1.032H21v2h-1.126c-.095.367-.24.714-.428 1.032l.797.796-1.415 1.415-.796-.797a3.979 3.979 0 0 1-1.032.428V20h-2v-1.126a3.977 3.977 0 0 1-1.032-.428l-.796.797-1.415-1.415.797-.796A3.975 3.975 0 0 1 12.126 16H11v-2h1.126c.095-.367.24-.714.428-1.032l-.797-.796 1.415-1.415.796.797A3.977 3.977 0 0 1 15 11.126V10h2Zm.406 3.578.016.016c.354.358.574.85.578 1.392v.028a2 2 0 0 1-3.409 1.406l-.01-.012a2 2 0 0 1 2.826-2.83ZM5 8a4 4 0 1 1 7.938.703 7.029 7.029 0 0 0-3.235 3.235A4 4 0 0 1 5 8Zm4.29 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h6.101A6.979 6.979 0 0 1 9 15c0-.695.101-1.366.29-2Z"
                          clip-rule="evenodd" />
                     </x-activeIcons>
                     <span class="flex-1 ms-3 whitespace-nowrap">Roles</span>
                   </x-nav-link>
                @endcan
                  </li>
            
               </ul>
            </li>
            @endcan
            @can('admin-admin-administracion')
            <li>
               <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
            </li>
            <li>
               <button type="button"
                 class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-red-500 dark:text-white dark:hover:bg-gray-700"
                 id="dropdown2">
                 <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                   xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                   <path fill-rule="evenodd"
                     d="M9.586 2.586A2 2 0 0 1 11 2h2a2 2 0 0 1 2 2v.089l.473.196.063-.063a2.002 2.002 0 0 1 2.828 0l1.414 1.414a2 2 0 0 1 0 2.827l-.063.064.196.473H20a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-.089l-.196.473.063.063a2.002 2.002 0 0 1 0 2.828l-1.414 1.414a2 2 0 0 1-2.828 0l-.063-.063-.473.196V20a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-.089l-.473-.196-.063.063a2.002 2.002 0 0 1-2.828 0l-1.414-1.414a2 2 0 0 1 0-2.827l.063-.064L4.089 15H4a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2h.09l.195-.473-.063-.063a2 2 0 0 1 0-2.828l1.414-1.414a2 2 0 0 1 2.827 0l.064.063L9 4.089V4a2 2 0 0 1 .586-1.414ZM8 12a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z"
                     clip-rule="evenodd" />
                 </svg>
                 <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Administación</span>
                 <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                   viewBox="0 0 10 6">
                   <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="m1 1 4 4 4-4" />
                 </svg>
               </button>
               <ul id="dropdown-menu2" class="hidden py-2 space-y-2 rounded-md">
                 <li>
                   @can('admin-admin-asignaturaDocente')
                   <x-nav-link href="{{ route('asignaturaDocente') }}"
                     :active="request()->routeIs('asignaturaDocente')"
                     class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-gray-700 group">
                     <x-activeIcons :active="request()->routeIs('asignaturaDocente')"
                        class="flex-shrink-0 w-6 h-6 "
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                          d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z" />
                     </x-activeIcons>
                     <span class="flex-1 ms-3 whitespace-nowrap">Asignación Asignaturas</span>
                   </x-nav-link>
                   @endcan
                   @can('admin-admin-programas')
                  <li>
                   <x-nav-link href="{{ route('programas') }}" :active="request()->routeIs('programas')"
                     class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-gray-700 group">
                     <x-activeIcons :active="request()->routeIs('programas')" class="w-6 h-6" aria-hidden="true"
                       xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                       <path
                        d="M12.8638 3.49613C12.6846 3.18891 12.3557 3 12 3s-.6846.18891-.8638.49613l-3.49998 6c-.18042.30929-.1817.69147-.00336 1.00197S8.14193 11 8.5 11h7c.3581 0 .6888-.1914.8671-.5019.1784-.3105.1771-.69268-.0033-1.00197l-3.5-6ZM4 13c-.55228 0-1 .4477-1 1v6c0 .5523.44772 1 1 1h6c.5523 0 1-.4477 1-1v-6c0-.5523-.4477-1-1-1H4Zm12.5-1c-2.4853 0-4.5 2.0147-4.5 4.5s2.0147 4.5 4.5 4.5 4.5-2.0147 4.5-4.5-2.0147-4.5-4.5-4.5Z" />
                     </x-activeIcons>
                     <span class="flex-1 ms-3 whitespace-nowrap">Programas Formación</span>
                   </x-nav-link>
                  </li>
               @endcan
                @can('admin-admin-periodo')
                   <x-nav-link href="{{ route('periodo') }}" :active="request()->routeIs('periodo')"
                     class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-gray-700 group">
                     <x-activeIcons :active="request()->routeIs('periodo')"
                        class="flex-shrink-0 w-6 h-6"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z" clip-rule="evenodd"/>
                     </x-activeIcons>
                     <span class="flex-1 ms-3 whitespace-nowrap">Periodo</span>
                   </x-nav-link>
                   @endcan
                   @can('admin-admin-seccion')
                   <x-nav-link href="{{ route('seccion') }}" :active="request()->routeIs('seccion')"
                     class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-gray-700 group">
                     <x-activeIcons :active="request()->routeIs('seccion')"
                        class="flex-shrink-0 w-6 h-6"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M16 10c0-.55228-.4477-1-1-1h-3v2h3c.5523 0 1-.4477 1-1Z"/>
                        <path d="M13 15v-2h2c1.6569 0 3-1.3431 3-3 0-1.65685-1.3431-3-3-3h-2.256c.1658-.46917.256-.97405.256-1.5 0-.51464-.0864-1.0091-.2454-1.46967C12.8331 4.01052 12.9153 4 13 4h7c.5523 0 1 .44772 1 1v9c0 .5523-.4477 1-1 1h-2.5l1.9231 4.6154c.2124.5098-.0287 1.0953-.5385 1.3077-.5098.2124-1.0953-.0287-1.3077-.5385L15.75 16l-1.827 4.3846c-.1825.438-.6403.6776-1.0889.6018.1075-.3089.1659-.6408.1659-.9864v-2.6002L14 15h-1ZM6 5.5C6 4.11929 7.11929 3 8.5 3S11 4.11929 11 5.5 9.88071 8 8.5 8 6 6.88071 6 5.5Z"/>
                        <path d="M15 11h-4v9c0 .5523-.4477 1-1 1-.55228 0-1-.4477-1-1v-4H8v4c0 .5523-.44772 1-1 1s-1-.4477-1-1v-6.6973l-1.16797 1.752c-.30635.4595-.92722.5837-1.38675.2773-.45952-.3063-.5837-.9272-.27735-1.3867l2.99228-4.48843c.09402-.14507.2246-.26423.37869-.34445.11427-.05949.24148-.09755.3763-.10887.03364-.00289.06747-.00408.10134-.00355H15c.5523 0 1 .44772 1 1 0 .5523-.4477 1-1 1Z"/>
                     </x-activeIcons>
                     <span class="flex-1 ms-3 whitespace-nowrap">Sección</span>
                   </x-nav-link>
                   @endcan

                   @can('admin-admin-instituto')
                   <x-nav-link href="{{ route('instituto') }}" :active="request()->routeIs('instituto')"
                     class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-red-500 dark:hover:bg-gray-700 group">
                     <x-activeIcons :active="request()->routeIs('instituto')"
                        class="flex-shrink-0 w-6 h-6"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m6 10.5237-2.27075.6386C3.29797 11.2836 3 11.677 3 12.125V20c0 .5523.44772 1 1 1h2V10.5237Zm12 0 2.2707.6386c.4313.1213.7293.5147.7293.9627V20c0 .5523-.4477 1-1 1h-2V10.5237Z"/>
                          <path fill-rule="evenodd" d="M12.5547 3.16795c-.3359-.22393-.7735-.22393-1.1094 0l-6.00002 4c-.45952.30635-.5837.92722-.27735 1.38675.30636.45953.92723.5837 1.38675.27735L8 7.86853V21h8V7.86853l1.4453.96352c.0143.00957.0289.01873.0435.02746.1597.09514.3364.14076.5112.1406.3228-.0003.6395-.15664.832-.44541.3064-.45953.1822-1.0804-.2773-1.38675l-6-4ZM10 12c0-.5523.4477-1 1-1h2c.5523 0 1 .4477 1 1s-.4477 1-1 1h-2c-.5523 0-1-.4477-1-1Zm1-4c-.5523 0-1 .44772-1 1s.4477 1 1 1h2c.5523 0 1-.44772 1-1s-.4477-1-1-1h-2Z" clip-rule="evenodd"/>
                     </x-activeIcons>
                     <span class="flex-1 ms-3 whitespace-nowrap">Instituto</span>
                   </x-nav-link>
                   @endcan
                 </li>

               </ul>
            </li>
         @endcan

            {{-- <div id="dropdown-cta" class="p-4 mt-6 rounded-lg bg-yellow-50 dark:bg-blue-900" role="alert">
               <div class="flex items-center mb-3">
                  <span
                     class="bg-orange-100 text-orange-800 text-sm font-semibold me-2 px-2.5 py-0.5 rounded dark:bg-orange-200 dark:text-orange-900">¡Bienvenido!</span>
                  <button type="button"
                     class="ms-auto -mx-1.5 -my-1.5 bg-blue-50 inline-flex justify-center items-center w-6 h-6 text-blue-900 rounded-lg focus:ring-2 focus:ring-blue-400 p-1 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-400 dark:hover:bg-blue-800"
                     data-dismiss-target="#dropdown-cta" aria-label="Close">
                     <span class="sr-only">Close</span>
                     <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                           d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                     </svg>
                  </button>
               </div>
               <p class="mb-3 text-sm text-gray-800 dark:text-white">
                  Este es tu panel de control donde puedes ver y administrar tus eventos.
               </p>
               <x-nav-link
                  class="text-sm text-blue-800 underline font-medium hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                  href="{{ route('profile.show') }}"> Ver y administrar Perfil</x-nav-link>
            </div>--}}

         </ul>
      </div>
   </aside>

   <div class="p-4 sm:ml-64 dark:bg-gray-900">

   </div>
   <script>
      document.addEventListener('DOMContentLoaded', function () {
         const dropdownButton = document.getElementById('dropdown2');
         const dropdownMenu = document.getElementById('dropdown-menu2');

         dropdownButton.addEventListener('click', function () {
            dropdownMenu.classList.toggle('hidden');
         });
      });
   </script>
   <script>
      document.addEventListener('DOMContentLoaded', function () {
         const dropdownButton = document.getElementById('dropdown3');
         const dropdownMenu = document.getElementById('dropdown-menu3');

         dropdownButton.addEventListener('click', function () {
            dropdownMenu.classList.toggle('hidden');
         });
      });
   </script>
</div>