<x-app-layout>
    {{-- titulo --}}
    <x-slot name="title">
        Productos - TSM Sistemas Integrales
    </x-slot>
    
    <x-slot name="header">
        <div class="bg-white">
            <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
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

            <!-- Barra de búsqueda -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="🔍 Buscar por clave, descripción o marca..." 
                           value="{{ $search ?? '' }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <div id="searchResults" class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-300 rounded-lg shadow-lg hidden max-h-96 overflow-y-auto z-50"></div>
                </div>
                <p class="text-xs text-gray-500 mt-1">Busca en tiempo real en todos los productos</p>
            </div>

            <!-- Indicador de filtro activo -->
            @if($search)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 flex items-center justify-between">
                    <span class="text-sm text-blue-700">
                        <strong>Filtro activo:</strong> Mostrando resultados para "{{ $search }}"
                    </span>
                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm underline">
                        Limpiar filtro
                    </a>
                </div>
            @endif

            <!-- Barra de acciones -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <h3 class="text-lg font-semibold text-gray-900">Total de Productos: {{ $producto->total() }}</h3>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <a href="{{ route('products.create') }}" class="flex items-center justify-center gap-2 px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <span>➕</span> Agregar Producto
                    </a>
                    <a href="{{ route('inventory.index') }}" class="flex items-center justify-center gap-2 px-6 py-2 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-600 transition-colors">
                        <span>↕️</span> Entradas/Salidas
                    </a>
                </div>
            </div>

            <!-- Tabla de productos -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full" id="productsTable">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:bg-gray-100 transition-colors select-none" data-column="clave">
                                Clave <span class="text-gray-400 text-xs ml-1">↕</span>
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:bg-gray-100 transition-colors select-none" data-column="descripcion">
                                Descripción <span class="text-gray-400 text-xs ml-1">↕</span>
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:bg-gray-100 transition-colors select-none" data-column="marca">
                                Marca <span class="text-gray-400 text-xs ml-1">↕</span>
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:bg-gray-100 transition-colors select-none" data-column="stock">
                                Stock <span class="text-gray-400 text-xs ml-1">↕</span>
                            </th>
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
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700">
                                            🔴 Stock Bajo
                                        </span>
                                    @elseif($prod->stock <= 30)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                            🟡 Stock Medio
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
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
                                        <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'Delete product {{$prod->id}}')" 
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                                            🗑️
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @include ('products.partials.update-product-modal', ['prod' => $prod])
                            @include ('products.partials.delete-product-modal', ['prod' => $prod])
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
            <div class="flex items-center justify-between mt-6">
                <p class="text-sm text-gray-600">
                    Mostrando {{ $producto->firstItem() ?? 0 }} a {{ $producto->lastItem() ?? 0 }} de {{ $producto->total() }} productos
                </p>
                {{ $producto->links('vendor.pagination.bootstrap-4') }}
            </div>

        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        const tableRows = document.querySelectorAll('tbody tr');
        const columnHeaders = document.querySelectorAll('thead th[data-column]');
        let sortColumn = null;
        let sortDirection = 'asc';
        let searchTimeout;

        // Búsqueda AJAX en tiempo real
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length < 1) {
                searchResults.classList.add('hidden');
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`{{ route('products.search') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            searchResults.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500">No se encontraron productos</div>';
                        } else {
                            searchResults.innerHTML = data.map(producto => `
                                <div class="px-4 py-3 border-b border-gray-100 hover:bg-blue-50 cursor-pointer transition-colors flex justify-between items-center group" onclick="filtrarProducto('${producto.clave}')">
                                    <div>
                                        <p class="font-medium text-gray-900">${producto.clave}</p>
                                        <p class="text-xs text-gray-600">${producto.descripcion}</p>
                                        <p class="text-xs text-gray-500">${producto.marca} • Stock: ${producto.stock}</p>
                                    </div>
                                    <span class="text-blue-600 font-medium text-sm group-hover:underline">Ver →</span>
                                </div>
                            `).join('');
                        }
                        searchResults.classList.remove('hidden');
                    })
                    .catch(error => console.error('Error:', error));
            }, 300);
        });

        // Filtrar tabla por clave (búsqueda servidor-side)
        function filtrarProducto(clave) {
            searchInput.value = clave;
            searchResults.classList.add('hidden');
            
            // Redirigir con parámetro de búsqueda
            window.location.href = `{{ route('products.index') }}?search=${encodeURIComponent(clave)}`;
        }

        // Cerrar resultados al hacer click fuera
        document.addEventListener('click', function(event) {
            if (!event.target.closest('#searchInput') && !event.target.closest('#searchResults')) {
                searchResults.classList.add('hidden');
            }
        });

        // Ordenamiento de columnas
        columnHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const column = this.getAttribute('data-column');
                
                // Cambiar dirección si es la misma columna
                if (sortColumn === column) {
                    sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
                } else {
                    sortColumn = column;
                    sortDirection = 'asc';
                }

                // Actualizar indicadores visuales
                columnHeaders.forEach(h => {
                    const span = h.querySelector('span');
                    if (span) span.textContent = '↕';
                    h.classList.remove('bg-blue-50');
                });
                
                const activeSpan = this.querySelector('span');
                if (activeSpan) {
                    activeSpan.textContent = sortDirection === 'asc' ? '↑' : '↓';
                }
                this.classList.add('bg-blue-50');

                // Obtener filas visibles y ordenarlas
                const visibleRows = Array.from(tableRows).filter(row => {
                    return row.style.display !== 'none' && !row.querySelector('td[colspan]');
                });

                visibleRows.sort((a, b) => {
                    let aValue, bValue;
                    
                    if (column === 'stock') {
                        aValue = parseInt(a.cells[3]?.textContent) || 0;
                        bValue = parseInt(b.cells[3]?.textContent) || 0;
                    } else if (column === 'clave') {
                        aValue = a.cells[0]?.textContent.trim() || '';
                        bValue = b.cells[0]?.textContent.trim() || '';
                    } else if (column === 'descripcion') {
                        aValue = a.cells[1]?.textContent.trim() || '';
                        bValue = b.cells[1]?.textContent.trim() || '';
                    } else if (column === 'marca') {
                        aValue = a.cells[2]?.textContent.trim() || '';
                        bValue = b.cells[2]?.textContent.trim() || '';
                    }

                    if (typeof aValue === 'number') {
                        return sortDirection === 'asc' ? aValue - bValue : bValue - aValue;
                    } else {
                        return sortDirection === 'asc' 
                            ? aValue.localeCompare(bValue)
                            : bValue.localeCompare(aValue);
                    }
                });

                // Reorganizar filas en el DOM
                const tbody = document.querySelector('tbody');
                visibleRows.forEach(row => tbody.appendChild(row));
            });
        });
    </script>
</x-app-layout>