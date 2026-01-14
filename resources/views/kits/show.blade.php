<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-purple-100 to-blue-100">
            <h2 class="font-semibold text-2xl text-purple-900 leading-tight">
                {{ __('Ver Kit') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Información del Kit -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $kit->nombre }}</h2>
                        <p class="text-sm text-gray-600 mt-1">Código: <span class="font-mono font-semibold">{{ $kit->codigo_kit }}</span></p>
                    </div>
                    <a href="{{ route('kits.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                        ← Volver
                    </a>
                </div>

                @if($kit->descripcion)
                    <p class="text-gray-700 mb-6">{{ $kit->descripcion }}</p>
                @endif

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <p class="text-sm text-gray-600">Total de Productos</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $kit->productos->count() }}</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                        <p class="text-sm text-gray-600">Items Totales</p>
                        <p class="text-2xl font-bold text-green-600">{{ $kit->productos->sum('pivot.cantidad') }}</p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('kits.edit', $kit) }}" class="flex items-center gap-2 px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        ✏️ Editar
                    </a>
                    <form action="{{ route('kits.destroy', $kit) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center gap-2 px-6 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                            🗑️ Eliminar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Productos en el Kit -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 border-b border-gray-200 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-900">Productos incluidos</h3>
                </div>

                @if($kit->productos->count() > 0)
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Clave</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Descripción</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Marca</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Cantidad en Kit</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($kit->productos as $producto)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $producto->clave }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $producto->descripcion }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $producto->marca ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-center">
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                            {{ $producto->pivot->cantidad }} unid.
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="px-6 py-12 text-center">
                        <p class="text-gray-500 text-sm">Este kit no contiene productos</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
