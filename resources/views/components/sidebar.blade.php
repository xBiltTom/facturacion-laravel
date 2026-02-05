<div x-data
    :class="{
        'translate-x-0': sidebarMobileOpen,
        '-translate-x-full': !sidebarMobileOpen,
        'lg:translate-x-0': sidebarOpen,
        'lg:-translate-x-full': !sidebarOpen
    }"
    class="fixed inset-y-0 left-0 z-30 w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 transform transition-transform duration-300 ease-in-out flex flex-col">
    <!-- An unexamined life is not worth living. - Socrates -->


    <!-- Logo y nombre de la app -->
    <div class="flex-shrink-0 flex items-center justify-center h-16 px-4 border-b border-gray-200 dark:border-gray-800 ">
        <a href="{{ route('dashboard.index') }}" class="flex items-center space-x-3">
            <!-- Icono de pollo/pollería -->
            {{-- <svg class="w-8 h-8 dark:text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg> --}}
            <img
                        src="{{ auth()->user()->empresa->urlLogoEmpresa }}"
                        alt="{{ auth()->user()->name }}"
                        class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-700"
                    >
            <span class="text-xl font-bold dark:text-white">{{auth()->user()->empresa->razonSocialEmpresa}}</span>
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto py-4 px-3">
        @foreach($menuItems as $group)
            @if(count($group['items'])>0)
                <div class="mb-6">
                    <h3 class="px-3 mb-2 text-xs font-semibold text-gray-800 dark:text-gray-300 uppercase tracking-wider">
                        {{ $group['group'] }}
                    </h3>
                    <ul class="space-y-1">
                        @foreach($group['items'] as $item)
                            <li>
                                <a
                                    href="{{ route($item['route'].'.index') }}"
                                    class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200
                                        {{ request()->routeIs($item['route'].'*')
                                            ? 'bg-gray-300 text-black dark:bg-gray-800 dark:text-white'
                                            : 'text-gray-500 hover:bg-gray-300 hover:text-black dark:text-gray-500 dark:hover:bg-gray-800 dark:hover:text-white' }}"
                                >
                                    <x-sidebar-icon :icon="$item['icon']" class="w-5 h-5 mr-3" />
                                    {{ $item['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endforeach
    </nav>

    <div class="flex-shrink-0 border-t border-gray-200 dark:border-gray-800 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                @if(auth()->user()->empresa->urlLogoEmpresa)
                    <img
                        src="{{ auth()->user()->empresa->urlLogoEmpresa }}"
                        alt="{{ auth()->user()->name }}"
                        class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-700"
                    >
                @else
                    <div class="w-10 h-10 rounded-full dark:bg-blue-800 bg-black flex items-center justify-center text-white font-semibold">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="ml-3 min-w-0 flex-1">
                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                    {{ auth()->user()->name ?? 'Usuario' }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                    {{-- {{ auth()->user()->email ?? '' }} --}}
                    Administrador de la empresa
                </p>
            </div>
        </div>
    </div>

</div>
