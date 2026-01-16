<x-app-layout>
    {{-- titulo --}}
    <x-slot name="title">
        Productos - TSM Sistemas Integrales
    </x-slot>
    
    <x-slot name="header">
        <div class="bg-gradient-to-r from-rose-100 to-pink-100">
            <h2 class="font-semibold text-2xl text-rose-900 leading-tight">
                {{ __('Productos') }}
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
                    <h3 class="text-lg font-semibold text-gray-900">Total de Productos: {{ $producto->total() }}</h3>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <a href="{{ route('products.create') }}" class="flex items-center justify-center gap-2 px-6 py-2 bg-rose-600 text-white font-medium rounded-lg hover:bg-rose-700 transition-colors">
                        <span>➕</span> Agregar Producto
                    </a>
                    <a href="{{ route('inventory.index') }}" class="flex items-center justify-center gap-2 px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <span>↕️</span> Entradas/Salidas
                    </a>
                </div>
            </div>

            <!-- Tabla de productos -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Clave</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Descripción</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Marca</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Stock</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Estado</th>
                            <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($producto as $prod)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $prod->clave }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $prod->descripcion }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $prod->marca ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $prod->stock }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if($prod->stock <= 10)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            🔴 Stock Bajo
                                        </span>
                                    @elseif($prod->stock <= 30)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            🟡 Stock Medio
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            🟢 Stock Alto
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'Update product {{$prod->id}}')" 
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Editar">
                                            ✏️
                                        </button>
                                        <form action="{{ route('products.destroy', $prod->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @include ('products.partials.update-product-modal', ['prod' => $prod])
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <p class="text-gray-500 text-sm">No hay productos registrados aún</p>
                                    <a href="{{ route('products.create') }}" class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-rose-600 text-white text-sm font-medium rounded-lg hover:bg-rose-700 transition-colors">
                                        <span>➕</span> Crear primer producto
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
                    Mostrando {{ $producto->firstItem() ?? 0 }} a {{ $producto->lastItem() ?? 0 }} de {{ $producto->total() }} productos
                </p>
                <div class="flex gap-2">
                    {{ $producto->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>