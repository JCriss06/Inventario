<x-app-layout>
    {{-- titulo --}}
    <x-slot name="title">
        Bitácoras - TSM Sistemas Integrales
    </x-slot>
    
    <x-slot name="header">
        <div class="bg-white">
            <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
                {{ __('Bitácoras') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            {{-- Estadísticas rápidas mejoradas --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                {{-- Total Registros --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total de Registros</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Acciones Hoy --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Acciones Hoy</p>
                            <p class="text-3xl font-bold text-emerald-600 mt-2">
                                {{ $stats['acciones_hoy'] }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Usuarios Activos --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Usuarios Activos</p>
                            <p class="text-3xl font-bold text-blue-600 mt-2">
                                {{ $stats['usuarios_activos'] }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m4 0H9m4 0a4 4 0 11-8 0 4 4 0 018 0zM9 16h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Última Actividad --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Última Actividad</p>
                            <p class="text-lg font-bold text-purple-600 mt-2">
                                @if($bitacoras->count() > 0)
                                    {{ $bitacoras->first()->created_at->diffForHumans() }}
                                @else
                                    Sin registros
                                @endif
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filtros mejorados --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Historial de Actividades</h3>
                    <p class="text-sm text-gray-600">Registro completo de todas las acciones en el sistema</p>
                </div>

                <form method="GET" action="{{ route('bitacoras.index') }}" class="space-y-4">
                    {{-- Búsqueda --}}
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" 
                                   name="search" 
                                   id="search"
                                   value="{{ request('search') }}"
                                   placeholder="Buscar por usuario, acción o descripción..."
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    {{-- Filtros en grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        {{-- Filtro por acción --}}
                        <div>
                            <label for="accion" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Acción</label>
                            <select name="accion" 
                                    id="accion"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Todas las acciones</option>
                                <option value="crear" {{ request('accion') == 'crear' ? 'selected' : '' }}>✓ Crear</option>
                                <option value="editar" {{ request('accion') == 'editar' ? 'selected' : '' }}>✏ Editar</option>
                                <option value="eliminar" {{ request('accion') == 'eliminar' ? 'selected' : '' }}>🗑 Eliminar</option>
                                <option value="sesion" {{ request('accion') == 'sesion' ? 'selected' : '' }}>👤 Sesión</option>
                                <option value="entrada" {{ request('accion') == 'entrada' ? 'selected' : '' }}>⬇ Entrada</option>
                                <option value="salida" {{ request('accion') == 'salida' ? 'selected' : '' }}>⬆ Salida</option>
                            </select>
                        </div>

                        {{-- Filtro por usuario --}}
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Usuario</label>
                            <select name="user_id" 
                                    id="user_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Todos los usuarios</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="flex items-end gap-2">
                            <button type="submit" 
                                    class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                🔍 Filtrar
                            </button>
                            <a href="{{ route('bitacoras.index') }}" 
                               class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                                🔄 Limpiar
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Lista de bitácoras mejorada --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                @if($bitacoras->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($bitacoras as $bitacora)
                            <div class="p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start gap-4">
                                    {{-- Ícono de acción --}}
                                    <div class="flex-shrink-0">
                                        @switch($bitacora->accion)
                                            @case('crear')
                                                <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                    </svg>
                                                </div>
                                                @break
                                            @case('editar')
                                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </div>
                                                @break
                                            @case('eliminar')
                                                <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </div>
                                                @break
                                            @case('sesion')
                                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                </div>
                                                @break
                                            @case('entrada')
                                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                </div>
                                                @break
                                            @case('salida')
                                                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                </div>
                                                @break
                                            @default
                                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                </div>
                                        @endswitch
                                    </div>

                                    {{-- Contenido principal --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap mb-1">
                                            <span class="font-semibold text-gray-900">{{ $bitacora->user->name ?? 'Usuario desconocido' }}</span>
                                            @switch($bitacora->accion)
                                                @case('crear')
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                                        ✓ Crear
                                                    </span>
                                                    @break
                                                @case('editar')
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                                        ✏ Editar
                                                    </span>
                                                    @break
                                                @case('eliminar')
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                                        🗑 Eliminar
                                                    </span>
                                                    @break
                                                @case('sesion')
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                                                        👤 Sesión
                                                    </span>
                                                    @break
                                                @case('entrada')
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                                        ⬇ Entrada
                                                    </span>
                                                    @break
                                                @case('salida')
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">
                                                        ⬆ Salida
                                                    </span>
                                                    @break
                                            @endswitch
                                        </div>
                                        <p class="text-sm text-gray-600">{{ $bitacora->descripcion ?? 'Sin descripción' }}</p>
                                        <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                            <div class="flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                {{ $bitacora->created_at->format('d/m/Y H:i:s') }}
                                            </div>
                                            <span>•</span>
                                            <div class="text-xs">
                                                {{ $bitacora->created_at->diffForHumans() }}
                                            </div>
                                            @if($bitacora->registro_id)
                                                <span>•</span>
                                                <div class="text-xs font-medium text-gray-600">
                                                    #{{ $bitacora->registro_id }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Paginación --}}
                    @if($bitacoras->hasPages())
                        <div class="border-t border-gray-200 p-4">
                            {{ $bitacoras->withQueryString()->links() }}
                        </div>
                    @endif
                @else
                    <div class="p-12 text-center">
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
</x-app-layout>
