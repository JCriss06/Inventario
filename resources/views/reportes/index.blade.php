<x-app-layout>
    {{-- titulo --}}
    <x-slot name="title">
        Reportes - TSM Sistemas Integrales
    </x-slot>
    
    <x-slot name="header">
        <div class="bg-white">
            <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
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

            <!-- TABS NAVIGATION -->
            <div class="bg-white rounded-t-lg border border-b-0 border-gray-200 shadow-sm">
                <div class="flex border-b border-gray-200">
                    <button id="tab-movimientos" onclick="cambiarTab('movimientos')" 
                            class="tab-btn active px-6 py-4 text-sm font-medium text-gray-900 border-b-2 border-blue-600 transition-colors hover:text-gray-600">
                        📋 Historial de Movimientos
                    </button>
                    <button id="tab-stock" onclick="cambiarTab('stock')" 
                            class="tab-btn px-6 py-4 text-sm font-medium text-gray-500 border-b-2 border-transparent transition-colors hover:text-gray-900">
                        📦 Stock Actual
                    </button>
                </div>
            </div>

            <!-- TAB 1: HISTORIAL DE MOVIMIENTOS -->
            <div id="contenido-movimientos" class="tab-content block">
                <!-- Tarjetas de Resumen - Movimientos -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 bg-white rounded-b-lg shadow-sm p-6 border border-gray-200 border-t-0">
                    <!-- Total Movimientos -->
                    <div class="rounded-lg p-4 border-l-4 border-blue-500 bg-blue-50">
                        <p class="text-gray-600 text-xs font-medium">Total Movimientos</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $reportes->count() }}</h3>
                        <p class="text-xs text-gray-500 mt-1">Registros en el período</p>
                    </div>

                    <!-- Total Entradas -->
                    <div class="rounded-lg p-4 border-l-4 border-green-500 bg-green-50">
                        <p class="text-gray-600 text-xs font-medium">Total Entradas</p>
                        <h3 class="text-2xl font-bold text-green-600 mt-1">+{{ $reportes->where('tipo_reporte', 'entrada')->sum('cantidad') }}</h3>
                        <p class="text-xs text-gray-500 mt-1">Unidades ingresadas</p>
                    </div>

                    <!-- Total Salidas -->
                    <div class="rounded-lg p-4 border-l-4 border-red-500 bg-red-50">
                        <p class="text-gray-600 text-xs font-medium">Total Salidas</p>
                        <h3 class="text-2xl font-bold text-red-600 mt-1">-{{ $reportes->where('tipo_reporte', 'salida')->sum('cantidad') }}</h3>
                        <p class="text-xs text-gray-500 mt-1">Unidades retiradas</p>
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

                    <form action="{{ route('reportes.index') }}" method="GET" class="space-y-3">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                            <!-- Período Rápido -->
                            <div>
                                <label for="periodo" class="block text-xs font-medium text-gray-700 mb-1">Período</label>
                                <select name="periodo" id="periodo" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Todo</option>
                                    <option value="hoy" {{ request('periodo') == 'hoy' ? 'selected' : '' }}>Hoy</option>
                                    <option value="semana" {{ request('periodo') == 'semana' ? 'selected' : '' }}>Semana</option>
                                    <option value="mes" {{ request('periodo') == 'mes' ? 'selected' : '' }}>Mes</option>
                                    <option value="año" {{ request('periodo') == 'año' ? 'selected' : '' }}>Año</option>
                                </select>
                            </div>

                            <!-- Producto -->
                            <div>
                                <label for="producto" class="block text-xs font-medium text-gray-700 mb-1">Producto</label>
                                <select name="producto" id="producto" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Todos</option>
                                    @foreach($productos as $prod)
                                        <option value="{{ $prod->id }}" {{ request('producto') == $prod->id ? 'selected' : '' }}>
                                            {{ $prod->clave }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tipo de Movimiento -->
                            <div>
                                <label for="tipo" class="block text-xs font-medium text-gray-700 mb-1">Tipo</label>
                                <select name="tipo" id="tipo" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Todos</option>
                                    <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                                    <option value="salida" {{ request('tipo') == 'salida' ? 'selected' : '' }}>Salida</option>
                                </select>
                            </div>

                            <!-- Fecha Inicio -->
                            <div>
                                <label for="fecha_inicio" class="block text-xs font-medium text-gray-700 mb-1">Desde</label>
                                <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Fecha Fin -->
                            <div>
                                <label for="fecha_fin" class="block text-xs font-medium text-gray-700 mb-1">Hasta</label>
                                <input type="date" id="fecha_fin" name="fecha_fin" value="{{ request('fecha_fin') }}" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <div class="flex gap-2 justify-end">
                            <button type="submit" class="px-4 py-1.5 bg-blue-600 text-white font-medium text-sm rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Filtrar
                            </button>
                            <a href="{{ route('reportes.export.pdf') . '?' . http_build_query(array_filter(request()->only(['periodo', 'producto', 'tipo', 'fecha_inicio', 'fecha_fin']))) }}" class="px-4 py-1.5 bg-red-600 text-white font-medium text-sm rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8m0 8l-9-2m9 2l9-2m-9-8l9 2m-9-2l-9 2"></path>
                                </svg>
                                Exportar PDF
                            </a>
                            @if(request()->anyFilled(['periodo', 'producto', 'tipo', 'fecha_inicio', 'fecha_fin']))
                                <a href="{{ route('reportes.index') }}" class="px-4 py-1.5 bg-gray-200 text-gray-700 font-medium text-sm rounded-lg hover:bg-gray-300 transition-colors">
                                    Limpiar
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Tabla de Reportes -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Historial de Movimientos</h3>
                            <p class="text-sm text-gray-600 mt-1">Mostrando <span class="font-semibold text-blue-600">{{ $reportes->count() }}</span> movimientos</p>
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
            <!-- FIN TAB 1: HISTORIAL DE MOVIMIENTOS -->

            <!-- TAB 2: STOCK ACTUAL -->
            <div id="contenido-stock" class="tab-content hidden">
                <!-- Stock Actual por Producto -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">📦 Stock Disponible en Tiempo Real</h3>
                        <p class="text-sm text-gray-600 mt-1">Inventario actualizado (Entradas - Salidas)</p>
                    </div>

                    @if(count($stocks) > 0)
                        <!-- ALERTAS: Productos con stock crítico -->
                        @if(count($alertas) > 0)
                            <div class="p-6 bg-white border-b border-gray-200">
                                <h4 class="text-sm font-bold text-red-900 mb-4 flex items-center gap-2">
                                    🚨 PRODUCTOS EN ALERTA ({{ count($alertas) }})
                                </h4>
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700">Producto</th>
                                                <th class="px-4 py-2 text-center text-xs font-semibold text-gray-700">Stock</th>
                                                <th class="px-4 py-2 text-center text-xs font-semibold text-gray-700">Entrada/Salida</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($alertas as $productId => $stock)
                                                @php
                                                    $neto = $stock['neto'];
                                                @endphp
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                                        {{ $stock['product']->clave }} - {{ $stock['product']->descripcion }}
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <span class="inline-flex px-3 py-1 text-xs font-bold rounded-lg bg-red-600 text-white">
                                                            {{ $neto <= 0 ? '🚨 ' : '⚠️ ' }} {{ $neto }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 text-center text-xs">
                                                        <span class="text-green-600 font-semibold">+{{ $stock['entradas'] }}</span>
                                                        <span class="text-gray-400">/</span>
                                                        <span class="text-red-600 font-semibold">-{{ $stock['salidas'] }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <!-- BÚSQUEDA Y TOGGLE -->
                        <div class="p-4 bg-gray-50 border-b border-gray-200 flex gap-3 flex-wrap items-center">
                            <input type="text" id="searchStock" placeholder="🔍 Buscar producto..." 
                                   class="flex-1 min-w-[200px] px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button type="button" id="toggleAllStock" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                Ver Todo ({{ count($normales) }})
                            </button>
                        </div>

                        <!-- STOCK NORMAL (Colapsable por defecto) -->
                        <div id="stockNormalContainer" class="hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50 border-b border-gray-200">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Clave</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Descripción</th>
                                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Entradas</th>
                                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Salidas</th>
                                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Stock Neto</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200" id="stockNormalBody">
                                        @foreach($normales as $productId => $stock)
                                            @php
                                                $neto = $stock['neto'];
                                            @endphp
                                            <tr class="hover:bg-gray-50 transition-colors stock-row">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                    {{ $stock['product']->clave }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-600">
                                                    {{ $stock['product']->descripcion }}
                                                </td>
                                                <td class="px-6 py-4 text-center text-sm font-semibold text-green-600">
                                                    +{{ $stock['entradas'] }}
                                                </td>
                                                <td class="px-6 py-4 text-center text-sm font-semibold text-red-600">
                                                    -{{ $stock['salidas'] }}
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <span class="inline-flex px-4 py-2 text-sm font-bold rounded-lg bg-green-50 text-green-600">
                                                        +{{ $neto }} ✅
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- TABLA DE BÚSQUEDA (Visible cuando busca) -->
                        <div id="searchResultsContainer" class="hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-blue-50 border-b border-blue-200">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-blue-900 uppercase tracking-wider">Clave</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-blue-900 uppercase tracking-wider">Descripción</th>
                                            <th class="px-6 py-3 text-center text-xs font-semibold text-blue-900 uppercase tracking-wider">Entradas</th>
                                            <th class="px-6 py-3 text-center text-xs font-semibold text-blue-900 uppercase tracking-wider">Salidas</th>
                                            <th class="px-6 py-3 text-center text-xs font-semibold text-blue-900 uppercase tracking-wider">Stock Neto</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-blue-200" id="searchResultsBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Sin resultados -->
                        <div id="noResults" class="hidden p-6 text-center text-gray-500 italic">
                            📭 No se encontró producto con ese criterio.
                        </div>
                    @else
                        <div class="p-6 text-center text-gray-500 italic">
                            📭 Sin datos de productos registrados aún.
                        </div>
                    @endif
                </div>
            </div>
            <!-- FIN TAB 2: STOCK ACTUAL -->

            <!-- SCRIPTS PARA TABS Y BÚSQUEDA -->
            <script>
                function cambiarTab(tab) {
                    // Ocultar ambos tabs
                    document.getElementById('contenido-movimientos').classList.add('hidden');
                    document.getElementById('contenido-stock').classList.add('hidden');
                    
                    // Remover clases de ambos botones (remover todo)
                    document.getElementById('tab-movimientos').classList.remove('border-blue-600', 'text-gray-900');
                    document.getElementById('tab-movimientos').classList.add('border-transparent', 'text-gray-500');
                    
                    document.getElementById('tab-stock').classList.remove('border-blue-600', 'text-gray-900');
                    document.getElementById('tab-stock').classList.add('border-transparent', 'text-gray-500');
                    
                    // Mostrar tab seleccionado y marcar botón
                    if (tab === 'movimientos') {
                        document.getElementById('contenido-movimientos').classList.remove('hidden');
                        document.getElementById('tab-movimientos').classList.remove('border-transparent', 'text-gray-500');
                        document.getElementById('tab-movimientos').classList.add('border-blue-600', 'text-gray-900');
                    } else {
                        document.getElementById('contenido-stock').classList.remove('hidden');
                        document.getElementById('tab-stock').classList.remove('border-transparent', 'text-gray-500');
                        document.getElementById('tab-stock').classList.add('border-blue-600', 'text-gray-900');
                    }
                }

                // Datos de todos los productos (para búsqueda)
                const todosProductos = {!! json_encode(array_merge($alertas, $normales)) !!};
                const searchInput = document.getElementById('searchStock');
                const toggleBtn = document.getElementById('toggleAllStock');
                const stockNormalContainer = document.getElementById('stockNormalContainer');
                const searchResultsContainer = document.getElementById('searchResultsContainer');
                const noResults = document.getElementById('noResults');
                const searchResultsBody = document.getElementById('searchResultsBody');

                // Toggle Ver Todo
                if (toggleBtn) {
                    toggleBtn.addEventListener('click', function() {
                        const isHidden = stockNormalContainer.classList.contains('hidden');
                        stockNormalContainer.classList.toggle('hidden');
                        searchResultsContainer.classList.add('hidden');
                        noResults.classList.add('hidden');
                        searchInput.value = '';
                        toggleBtn.textContent = isHidden ? 'Ocultar Stock Normal' : 'Ver Todo (' + Object.keys(todosProductos).filter(k => todosProductos[k].neto > 2).length + ')';
                    });
                }

                // Búsqueda en tiempo real
                if (searchInput) {
                    searchInput.addEventListener('input', function() {
                        const query = this.value.toLowerCase().trim();
                        
                        if (query === '') {
                            searchResultsContainer.classList.add('hidden');
                            stockNormalContainer.classList.add('hidden');
                            noResults.classList.add('hidden');
                            return;
                        }

                        const resultados = [];
                        for (const [productId, stock] of Object.entries(todosProductos)) {
                            const searchText = (stock.product.clave + ' ' + stock.product.descripcion).toLowerCase();
                            if (searchText.includes(query)) {
                                resultados.push({ productId, stock });
                            }
                        }

                        if (resultados.length === 0) {
                            searchResultsContainer.classList.add('hidden');
                            noResults.classList.remove('hidden');
                            return;
                        }

                        // Mostrar resultados
                        searchResultsBody.innerHTML = '';
                        resultados.forEach(({ productId, stock }) => {
                            const neto = stock.neto;
                            const statusColor = neto <= 0 ? 'bg-red-50 text-red-600' : (neto <= 2 ? 'bg-yellow-50 text-yellow-600' : 'bg-green-50 text-green-600');
                            const statusIcon = neto <= 0 ? '🚨' : (neto <= 2 ? '⚠️' : '✅');
                            
                            const row = document.createElement('tr');
                            row.className = 'hover:bg-blue-50 transition-colors';
                            row.innerHTML = `
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">${stock.product.clave}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">${stock.product.descripcion}</td>
                                <td class="px-6 py-4 text-center text-sm font-semibold text-green-600">+${stock.entradas}</td>
                                <td class="px-6 py-4 text-center text-sm font-semibold text-red-600">-${stock.salidas}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex px-4 py-2 text-sm font-bold rounded-lg ${statusColor}">
                                        ${neto > 0 ? '+' : ''}${neto} ${statusIcon}
                                    </span>
                                </td>
                            `;
                            searchResultsBody.appendChild(row);
                        });

                        searchResultsContainer.classList.remove('hidden');
                        stockNormalContainer.classList.add('hidden');
                        noResults.classList.add('hidden');
                    });
                }
            </script>

        </div>
    </div>
</x-app-layout>