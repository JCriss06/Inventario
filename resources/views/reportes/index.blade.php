<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reportes de Inventario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('reportes.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                        <div>
                            <x-input-label for="periodo" :value="__('Periodo Rápido')" />
                            <select name="periodo" id="periodo" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Todo el tiempo</option>
                                <option value="hoy" {{ request('periodo') == 'hoy' ? 'selected' : '' }}>Hoy</option>
                                <option value="semana" {{ request('periodo') == 'semana' ? 'selected' : '' }}>Esta semana</option>
                                <option value="mes" {{ request('periodo') == 'mes' ? 'selected' : '' }}>Este mes</option>
                                <option value="año" {{ request('periodo') == 'año' ? 'selected' : '' }}>Este año</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="fecha_inicio" :value="__('Desde')" />
                            <x-text-input id="fecha_inicio" name="fecha_inicio" type="date" class="mt-1 block w-full" :value="request('fecha_inicio')" />
                        </div>

                        <div>
                            <x-input-label for="fecha_fin" :value="__('Hasta')" />
                            <x-text-input id="fecha_fin" name="fecha_fin" type="date" class="mt-1 block w-full" :value="request('fecha_fin')" />
                        </div>

                        <div class="flex gap-2">
                            <x-primary-button>
                                {{ __('Filtrar') }}
                            </x-primary-button>
                            
                            @if(request()->anyFilled(['periodo', 'fecha_inicio', 'fecha_fin']))
                                <a href="{{ route('reportes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 transition ease-in-out duration-150">
                                    {{ __('Limpiar') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha y Hora</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Movimiento</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($reportes as $reporte)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $reporte->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $reporte->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            <span class="font-bold text-gray-800">{{ $reporte->product->clave }}</span> - {{ $reporte->product->descripcion }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($reporte->tipo_reporte === 'entrada')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Entrada ↓
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Salida ↑
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold {{ $reporte->tipo_reporte === 'entrada' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $reporte->tipo_reporte === 'entrada' ? '+' : '-' }} {{ $reporte->cantidad }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                                            No se encontraron movimientos con los filtros seleccionados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>