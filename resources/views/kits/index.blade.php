<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-purple-100 to-blue-100">
            <h2 class="font-semibold text-2xl text-purple-900 leading-tight">
                {{ __('Kits de Productos') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="rounded-lg bg-green-50 p-4 text-sm text-green-800 border border-green-200">
                    <span class="font-semibold">✓ Éxito:</span> {{ session('success') }}
                </div>
            @endif

            <!-- Barra de acciones -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <h3 class="text-lg font-semibold text-gray-900">Total de Kits: {{ $kits->total() }}</h3>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <a href="{{ route('kits.create') }}" class="flex items-center justify-center gap-2 px-6 py-2 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors">
                        <span>🎁</span> Nuevo Kit
                    </a>
                    <a href="{{ route('products.index') }}" class="flex items-center justify-center gap-2 px-6 py-2 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors">
                        <span>📦</span> Ver Productos
                    </a>
                </div>
            </div>

            <!-- Tabla de kits -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Código</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nombre</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Descripción</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Items</th>
                            <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($kits as $kit)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $kit->codigo_kit }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-purple-600">{{ $kit->nombre }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $kit->descripcion ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $kit->productos->count() }} productos
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('kits.show', $kit) }}" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Ver">
                                            👁️
                                        </a>
                                        <a href="{{ route('kits.edit', $kit) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Editar">
                                            ✏️
                                        </a>
                                        <form action="{{ route('kits.destroy', $kit) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este kit?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <p class="text-gray-500 text-sm">No hay kits creados aún</p>
                                    <a href="{{ route('kits.create') }}" class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors">
                                        <span>🎁</span> Crear primer kit
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">
                    Mostrando {{ $kits->firstItem() ?? 0 }} a {{ $kits->lastItem() ?? 0 }} de {{ $kits->total() }} kits
                </p>
                <div class="flex gap-2">
                    {{ $kits->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
