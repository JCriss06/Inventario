<nav x-data="{ open: false, showNotifications: false, showUserMenu: false }" class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <img src="{{ asset('img/logo.png') }}" alt="TSM Logo" class="h-8 w-auto">
                        <span class="font-semibold text-lg text-gray-900">TSM Sistemas Integrales</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden sm:flex items-center gap-1">
                    <a href="{{ route('dashboard') }}" 
                       class="px-4 py-2 text-sm font-medium rounded-none transition-colors
                              {{ request()->routeIs('dashboard') 
                                 ? 'text-rose-600 border-b-2 border-rose-600' 
                                 : 'text-gray-500 hover:text-gray-700' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('products.index') }}" 
                       class="px-4 py-2 text-sm font-medium rounded-none transition-colors
                              {{ request()->routeIs('products.*') 
                                 ? 'text-rose-600 border-b-2 border-rose-600' 
                                 : 'text-gray-500 hover:text-gray-700' }}">
                        Productos
                    </a>
                    <a href="{{ route('bitacoras.index') }}" 
                       class="px-4 py-2 text-sm font-medium rounded-none transition-colors
                              {{ request()->routeIs('bitacoras.*') 
                                 ? 'text-rose-600 border-b-2 border-rose-600' 
                                 : 'text-gray-500 hover:text-gray-700' }}">
                        Bitácoras
                    </a>
                    <a href="{{ route('reportes.index') }}" 
                       class="px-4 py-2 text-sm font-medium rounded-none transition-colors
                              {{ request()->routeIs('reportes.*') 
                                 ? 'text-rose-600 border-b-2 border-rose-600' 
                                 : 'text-gray-500 hover:text-gray-700' }}">
                        Reportes
                    </a>
                </nav>
            </div>

            <!-- Usuario y notificaciones -->
            <div class="hidden sm:flex sm:items-center gap-3">
                <!-- Notificaciones -->
                <div class="relative">
                    <button @click="showNotifications = !showNotifications" 
                            @click.away="showNotifications = false"
                            class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>

                    <!-- Dropdown de notificaciones -->
                    <div x-show="showNotifications" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 top-12 w-80 bg-white border border-gray-200 rounded-lg shadow-lg p-4 z-50">
                        <h3 class="font-semibold text-gray-900 mb-3">Notificaciones</h3>
                        <div class="space-y-2">
                            <div class="p-3 bg-orange-50 border border-orange-200 rounded-lg">
                                <p class="text-sm font-medium text-gray-900">Stock bajo detectado</p>
                                <p class="text-xs text-gray-500 mt-1">Algunos productos necesitan reabastecimiento</p>
                            </div>
                            <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-sm font-medium text-gray-900">Sistema actualizado</p>
                                <p class="text-xs text-gray-500 mt-1">TSM Sistemas Integrales v1.0.0 está funcionando correctamente</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usuario Dropdown -->
                <div class="relative">
                    <button @click="showUserMenu = !showUserMenu"
                            @click.away="showUserMenu = false"
                            class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown de usuario -->
                    <div x-show="showUserMenu"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 top-12 w-48 bg-white border border-gray-200 rounded-lg shadow-lg p-2 z-50">
                        <a href="{{ route('profile.edit') }}" 
                           class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg text-left">
                            Mi Perfil
                        </a>
                        <div class="border-t border-gray-200 my-2"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="block w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg text-left">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" 
               class="block px-4 py-2 text-base font-medium {{ request()->routeIs('dashboard') ? 'text-rose-600 bg-rose-50 border-l-4 border-rose-600' : 'text-gray-600 hover:bg-gray-50' }}">
                Dashboard
            </a>
            <a href="{{ route('products.index') }}" 
               class="block px-4 py-2 text-base font-medium {{ request()->routeIs('products.*') ? 'text-rose-600 bg-rose-50 border-l-4 border-rose-600' : 'text-gray-600 hover:bg-gray-50' }}">
                Productos
            </a>
            <a href="{{ route('bitacoras.index') }}" 
               class="block px-4 py-2 text-base font-medium {{ request()->routeIs('bitacoras.*') ? 'text-rose-600 bg-rose-50 border-l-4 border-rose-600' : 'text-gray-600 hover:bg-gray-50' }}">
                Bitácoras
            </a>
            <a href="{{ route('reportes.index') }}" 
               class="block px-4 py-2 text-base font-medium {{ request()->routeIs('reportes.*') ? 'text-rose-600 bg-rose-50 border-l-4 border-rose-600' : 'text-gray-600 hover:bg-gray-50' }}">
                Reportes
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" 
                   class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50">
                    Mi Perfil
                </a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="block w-full text-left px-4 py-2 text-base font-medium text-red-600 hover:bg-red-50">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
