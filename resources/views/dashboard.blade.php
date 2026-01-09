<x-app-layout>
    {{-- titulo --}}
    <x-slot name="title">
        Dashboard - InvenTrack
    </x-slot>
    
    <x-slot name="header">
        <div class="bg-gradient-to-r from-rose-100 to-pink-100">
            <h2 class="font-semibold text-2xl text-rose-900 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Total Productos --}}
                <a href="{{ route('products.index') }}" class="block">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow cursor-pointer">
                        <div class="flex items-center justify-between pb-2">
                            <h3 class="text-sm font-medium text-gray-500">Total Productos</h3>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div class="text-3xl font-bold text-gray-900">{{ number_format($totalProducts) }}</div>
                        <p class="text-xs text-gray-500 mt-1">
                            <span class="text-emerald-600">Productos registrados</span>
                        </p>
                    </div>
                </a>

                {{-- Stock Bajo --}}
                <a href="{{ route('products.index') }}" class="block">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow cursor-pointer">
                        <div class="flex items-center justify-between pb-2">
                            <h3 class="text-sm font-medium text-gray-500">Stock Bajo</h3>
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="text-3xl font-bold text-gray-900">{{ $lowStockCount }}</div>
                        <p class="text-xs text-gray-500 mt-1">
                            <span class="text-orange-600">Requieren atención</span>
                        </p>
                    </div>
                </a>

                {{-- Stock Total --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between pb-2">
                        <h3 class="text-sm font-medium text-gray-500">Stock Total</h3>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ number_format($totalStockValue) }}</div>
                    <p class="text-xs text-gray-500 mt-1">
                        <span class="text-emerald-600">Unidades en inventario</span>
                    </p>
                </div>

                {{-- Movimientos Hoy --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between pb-2">
                        <h3 class="text-sm font-medium text-gray-500">Movimientos Hoy</h3>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ $todayMovements }}</div>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $todayEntradas }} entradas, {{ $todaySalidas }} salidas
                    </p>
                </div>
            </div>

            {{-- Alertas de Stock Bajo --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Alertas de Stock Bajo</h3>
                            <p class="text-sm text-gray-500 mt-1">Productos que requieren reabastecimiento</p>
                        </div>
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
                <div class="p-6">
                    @if($lowStockProducts->count() > 0)
                        <div class="space-y-3">
                            @foreach($lowStockProducts as $product)
                                <a href="{{ route('products.index') }}" class="block">
                                    <div class="flex items-center justify-between p-4 border border-orange-200 bg-orange-50 rounded-lg hover:shadow-md transition-shadow cursor-pointer">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-sm text-gray-900">{{ $product->descripcion ?? $product->clave }}</h4>
                                            <p class="text-xs text-gray-500">{{ $product->marca ?? 'Sin marca' }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-orange-600">{{ $product->stock }} unidades</p>
                                            <p class="text-xs text-gray-500">Clave: {{ $product->clave }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-gray-500">¡Todos los productos tienen stock suficiente!</p>
                        </div>
                    @endif
                    <a href="{{ route('products.index') }}" class="block w-full mt-4">
                        <button class="w-full py-2 px-4 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            Ver todas las alertas
                        </button>
                    </a>
                </div>
            </div>

            {{-- Productos Recientes --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Productos Recientes</h3>
                    <p class="text-sm text-gray-500 mt-1">Últimos productos agregados o modificados</p>
                </div>
                <div class="p-6">
                    @if($recentProducts->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentProducts as $product)
                                <a href="{{ route('products.index') }}" class="block">
                                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                                        <div class="flex items-center gap-4 flex-1">
                                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900">{{ $product->descripcion ?? $product->clave }}</h4>
                                                <p class="text-sm text-gray-500">{{ $product->marca ?? 'Sin marca' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <div class="text-right">
                                                <p class="text-sm font-medium text-gray-900">Stock: {{ $product->stock }}</p>
                                                @if($product->stock <= 10)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-1">
                                                        Stock Bajo
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mt-1">
                                                        Normal
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <p class="text-gray-500">No hay productos registrados aún</p>
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 mt-3 bg-rose-600 text-white text-sm font-medium rounded-lg hover:bg-rose-700 transition-colors">
                                Agregar primer producto
                            </a>
                        </div>
                    @endif
                    <a href="{{ route('products.index') }}" class="block w-full mt-4">
                        <button class="w-full py-2 px-4 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            Ver todos los productos
                        </button>
                    </a>
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
