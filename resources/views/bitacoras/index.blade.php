<x-app-layout>
    {{-- titulo --}}
    <x-slot name="title">
        Bitácoras - InvenTrack
    </x-slot>
    
    <x-slot name="header">
        <div class="bg-gradient-to-r from-purple-100 to-indigo-100">
            <h2 class="font-semibold text-2xl text-purple-900 leading-tight">
                {{ __('Bitácoras') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            {{-- Estadísticas rápidas --}}
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 text-center">
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    <p class="text-xs text-gray-500">Total</p>
                </div>
                <div class="bg-green-50 rounded-lg shadow-sm border border-green-200 p-4 text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $stats['crear'] }}</p>
                    <p class="text-xs text-green-600">Creaciones</p>
                </div>
                <div class="bg-blue-50 rounded-lg shadow-sm border border-blue-200 p-4 text-center">
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['editar'] }}</p>
                    <p class="text-xs text-blue-600">Ediciones</p>
                </div>
                <div class="bg-red-50 rounded-lg shadow-sm border border-red-200 p-4 text-center">
                    <p class="text-2xl font-bold text-red-600">{{ $stats['eliminar'] }}</p>
                    <p class="text-xs text-red-600">Eliminaciones</p>
                </div>
                <div class="bg-purple-50 rounded-lg shadow-sm border border-purple-200 p-4 text-center">
                    <p class="text-2xl font-bold text-purple-600">{{ $stats['sesion'] }}</p>
                    <p class="text-xs text-purple-600">Sesiones</p>
                </div>
            </div>

            {{-- Filtros --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <form method="GET" action="{{ route('bitacoras.index') }}" class="flex flex-col md:flex-row gap-4">
                    {{-- Búsqueda --}}
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                        <input type="text" 
                               name="search" 
                               id="search"
                               value="{{ request('search') }}"
                               placeholder="Buscar en descripción..."
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>

                    {{-- Filtro por acción --}}
                    <div class="w-full md:w-48">
                        <label for="accion" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Acción</label>
                        <select name="accion" 
                                id="accion"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="">Todas</option>
                            <option value="crear" {{ request('accion') == 'crear' ? 'selected' : '' }}>Crear</option>
                            <option value="editar" {{ request('accion') == 'editar' ? 'selected' : '' }}>Editar</option>
                            <option value="eliminar" {{ request('accion') == 'eliminar' ? 'selected' : '' }}>Eliminar</option>
                            <option value="sesion" {{ request('accion') == 'sesion' ? 'selected' : '' }}>Sesión</option>
                        </select>
                    </div>

                    {{-- Filtro por usuario --}}
                    <div class="w-full md:w-48">
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
                        <select name="user_id" 
                                id="user_id"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="">Todos</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Botones --}}
                    <div class="flex items-end gap-2">
                        <button type="submit" 
                                class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors">
                            Filtrar
                        </button>
                        <a href="{{ route('bitacoras.index') }}" 
                           class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            {{-- Lista de bitácoras --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Historial de Actividades</h3>
                    <p class="text-sm text-gray-500 mt-1">Registro de todas las acciones realizadas en el sistema</p>
                </div>
                <div class="p-6">
                    @if($bitacoras->count() > 0)
                        <div class="space-y-3">
                            @foreach($bitacoras as $bitacora)
                                <div class="flex items-start gap-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    {{-- Ícono de acción --}}
                                    <div class="flex-shrink-0">
                                        @switch($bitacora->accion)
                                            @case('crear')
                                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                    </svg>
                                                </div>
                                                @break
                                            @case('editar')
                                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </div>
                                                @break
                                            @case('eliminar')
                                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </div>
                                                @break
                                            @case('sesion')
                                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                </div>
                                                @break
                                            @default
                                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                </div>
                                        @endswitch
                                    </div>

                                    {{-- Contenido --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="font-medium text-gray-900">{{ $bitacora->user->name ?? 'Usuario desconocido' }}</span>
                                            @switch($bitacora->accion)
                                                @case('crear')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Crear
                                                    </span>
                                                    @break
                                                @case('editar')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        Editar
                                                    </span>
                                                    @break
                                                @case('eliminar')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Eliminar
                                                    </span>
                                                    @break
                                                @case('sesion')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                        Sesión
                                                    </span>
                                                    @break
                                            @endswitch
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">{{ $bitacora->descripcion ?? 'Sin descripción' }}</p>
                                        <p class="text-xs text-gray-400 mt-2">
                                            {{ $bitacora->created_at->format('d/m/Y H:i:s') }} 
                                            <span class="mx-1">•</span>
                                            {{ $bitacora->created_at->diffForHumans() }}
                                        </p>
                                    </div>

                                    {{-- ID del registro --}}
                                    @if($bitacora->registro_id)
                                        <div class="flex-shrink-0 text-right">
                                            <span class="text-xs text-gray-400">Registro #{{ $bitacora->registro_id }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        {{-- Paginación --}}
                        <div class="mt-6">
                            {{ $bitacoras->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">No hay registros</h3>
                            <p class="text-gray-500">No se encontraron actividades en la bitácora</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-center md:text-left">
                    <p class="text-sm font-medium text-gray-900">Sistema de Inventario InvenTrack</p>
                    <p class="text-xs text-gray-500 mt-1">Desarrollado con dedicación para gestionar tu inventario de manera eficiente</p>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-sm font-medium text-gray-900">Contacto de Desarrollo</p>
                    <p class="text-xs text-gray-500 mt-1">Email: desarrollo@inventrackteam.com</p>
                    <p class="text-xs text-gray-500">Tel: +52 (555) 123-4567</p>
                </div>
            </div>
            <div class="border-t border-gray-200 mt-4 pt-4 text-center">
                <p class="text-xs text-gray-500">
                    © {{ date('Y') }} InvenTrack Team. Todos los derechos reservados. | Versión 1.0.0
                </p>
            </div>
        </div>
    </footer>
</x-app-layout>
