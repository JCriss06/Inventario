<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-rose-100 to-pink-100">
            <h2 class="font-semibold text-2xl text-rose-900 leading-tight">
                {{ __('Reportes de Inventario') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <x-alert type="success">
                    <x-slot name="message">¡Éxito!</x-slot>
                    {{ session('success') }}
                </x-alert>
            @endif

            <!-- Tarjetas de Resumen -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Total Movimientos -->
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Movimientos</p>
                            <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $reportes->count() }}</h3>
                            <p class="text-xs text-gray-400 mt-1">Registros en el período</p>
                        </div>
                        <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Total Entradas -->
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Entradas</p>
                            <h3 class="text-3xl font-bold text-green-600 mt-2">+{{ $reportes->where('tipo_reporte', 'entrada')->sum('cantidad') }}</h3>
                            <p class="text-xs text-gray-400 mt-1">Unidades ingresadas</p>
                        </div>
                        <svg class="w-12 h-12 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Total Salidas -->
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Salidas</p>
                            <h3 class="text-3xl font-bold text-red-600 mt-2">-{{ $reportes->where('tipo_reporte', 'salida')->sum('cantidad') }}</h3>
                            <p class="text-xs text-gray-400 mt-1">Unidades retiradas</p>
                        </div>
                        <svg class="w-12 h-12 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 14l6-6m-6 6l-6-6m6 6v6m0-13V4m0 0l6 6m-6-6l-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filtros de Búsqueda
                </h3>

                <form action="{{ route('reportes.index') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Período Rápido -->
                        <div>
                            <label for="periodo" class="block text-sm font-medium text-gray-700 mb-1">Período</label>
                            <select name="periodo" id="periodo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent">
                                <option value="">Todo el tiempo</option>
                                <option value="hoy" {{ request('periodo') == 'hoy' ? 'selected' : '' }}>Hoy</option>
                                <option value="semana" {{ request('periodo') == 'semana' ? 'selected' : '' }}>Esta semana</option>
                                <option value="mes" {{ request('periodo') == 'mes' ? 'selected' : '' }}>Este mes</option>
                                <option value="año" {{ request('periodo') == 'año' ? 'selected' : '' }}>Este año</option>
                            </select>
                        </div>

                        <!-- Tipo de Movimiento -->
                        <div>
                            <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                            <select name="tipo" id="tipo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent">
                                <option value="">Todos</option>
                                <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entradas</option>
                                <option value="salida" {{ request('tipo') == 'salida' ? 'selected' : '' }}>Salidas</option>
                            </select>
                        </div>

                        <!-- Fecha Inicio -->
                        <div>
                            <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent">
                        </div>

                        <!-- Fecha Fin -->
                        <div>
                            <label for="fecha_fin" class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                            <input type="date" id="fecha_fin" name="fecha_fin" value="{{ request('fecha_fin') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="flex gap-2 justify-end">
                        <button type="submit" class="px-6 py-2 bg-rose-600 text-white font-medium rounded-lg hover:bg-rose-700 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filtrar
                        </button>
                        @if(request()->anyFilled(['periodo', 'tipo', 'fecha_inicio', 'fecha_fin']))
                            <a href="{{ route('reportes.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Tabla de Reportes -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Historial de Movimientos</h3>
                            <p class="text-sm text-gray-600 mt-1">Mostrando <span class="font-semibold text-rose-600">{{ $reportes->count() }}</span> movimientos</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha y Hora</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Usuario</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Producto</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($reportes as $reporte)
                                <tr class="hover:bg-gray-50 transition-colors {{ $loop->odd ? 'bg-white' : 'bg-gray-50/50' }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <div class="font-medium text-gray-900">{{ $reporte->created_at->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $reporte->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">{{ $reporte->user->name ?? 'Sistema' }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <div class="font-semibold text-gray-900">{{ $reporte->product->clave }}</div>
                                        <div class="text-xs text-gray-500">{{ $reporte->product->descripcion }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($reporte->tipo_reporte === 'entrada')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                ↓ Entrada
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                ↑ Salida
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <span class="font-bold text-lg {{ $reporte->tipo_reporte === 'entrada' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $reporte->tipo_reporte === 'entrada' ? '+' : '-' }} {{ $reporte->cantidad }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                                        📊 No se encontraron movimientos con los filtros seleccionados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>