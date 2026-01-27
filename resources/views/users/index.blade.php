<x-app-layout>
    {{-- Titulo de la pestaña del navegador --}}
    <x-slot name="title">
        Usuarios - TSM Sistemas Integrales
    </x-slot>
    
    <x-slot name="header">
        <div class="bg-white">
            <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
                {{ __('Gestión de Usuarios') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Mensajes de Éxito/Error --}}
            @if(session('success'))
                <div class="rounded-lg bg-green-50 p-4 text-sm text-green-800 border border-green-200">
                    <span class="font-semibold">✓ Éxito:</span> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="rounded-lg bg-red-50 p-4 text-sm text-red-800 border border-red-200">
                    <span class="font-semibold">Error:</span> {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <input type="text" id="searchInput" placeholder="🔍 Buscar por nombre, email o puesto..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-rose-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">Filtra rápidamente los usuarios en pantalla</p>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <h3 class="text-lg font-semibold text-gray-900">Total de Usuarios: {{ $users->total() }}</h3>
                </div>
                
                {{-- Botón Agregar: Solo visible si tiene permiso 'crear usuarios' --}}
                @can('crear usuarios')
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <a href="{{ route('users.create') }}" class="flex items-center justify-center gap-2 px-6 py-2 bg-rose-500 text-white font-medium rounded-lg hover:bg-rose-700 transition-colors">
                        <span>➕</span> Agregar Usuario
                    </a>
                </div>
                @endcan
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full" id="usersTable">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:bg-gray-100 transition-colors select-none" data-column="name">
                                Nombre <span class="text-gray-400 text-xs ml-1">↕</span>
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:bg-gray-100 transition-colors select-none" data-column="email">
                                Email <span class="text-gray-400 text-xs ml-1">↕</span>
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:bg-gray-100 transition-colors select-none" data-column="puesto">
                                Puesto <span class="text-gray-400 text-xs ml-1">↕</span>
                            </th>
                            <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $user->puesto ?? 'General' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        
                                        {{-- Botón Editar: Solo si tiene permiso 'editar usuarios' --}}
                                        @can('editar usuarios')
                                        <a href="{{ route('users.edit', $user) }}" 
                                           class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" 
                                           title="Editar Usuario">
                                            ✏️
                                        </a>
                                        @endcan

                                        {{-- Botón Eliminar: Solo si tiene permiso 'eliminar usuarios' --}}
                                        @can('eliminar usuarios')
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" 
                                                    title="Eliminar Usuario"
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar a {{ $user->name }}? Esta acción no se puede deshacer.')">
                                                🗑️
                                            </button>
                                        </form>
                                        @endcan

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <p class="text-gray-500 text-sm">No hay usuarios registrados aún</p>
                                    
                                    {{-- Mostrar botón de crear primer usuario solo si tiene permiso --}}
                                    @can('crear usuarios')
                                    <a href="{{ route('users.create') }}" class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-rose-600 text-white text-sm font-medium rounded-lg hover:bg-rose-700 transition-colors">
                                        <span>➕</span> Crear primer usuario
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">
                    Mostrando {{ $users->firstItem() ?? 0 }} a {{ $users->lastItem() ?? 0 }} de {{ $users->total() }} usuarios
                </p>
                <div class="flex gap-2">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>

    {{-- Script para búsqueda y ordenamiento en cliente --}}
    <script>
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('tbody tr');
        const columnHeaders = document.querySelectorAll('thead th[data-column]');
        let sortColumn = null;
        let sortDirection = 'asc';

        // Búsqueda
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            let visibleCount = 0;

            tableRows.forEach(row => {
                // Saltar fila de "No hay usuarios"
                if (row.querySelector('td[colspan="4"]')) return;

                const name = row.cells[0]?.textContent.toLowerCase() || '';
                const email = row.cells[1]?.textContent.toLowerCase() || '';
                const puesto = row.cells[2]?.textContent.toLowerCase() || '';

                const matches = name.includes(query) || email.includes(query) || puesto.includes(query);

                if (query === '' || matches) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Manejo de mensaje "No hay resultados"
            let noResultsRow = document.querySelector('tbody tr[data-no-results]');
            if (visibleCount === 0 && query !== '') {
                if (!noResultsRow) {
                    noResultsRow = document.createElement('tr');
                    noResultsRow.setAttribute('data-no-results', 'true');
                    noResultsRow.innerHTML = '<td colspan="4" class="px-6 py-12 text-center"><p class="text-gray-500 text-sm">📭 No se encontraron usuarios con ese criterio.</p></td>';
                    document.querySelector('tbody').appendChild(noResultsRow);
                }
                noResultsRow.style.display = '';
            } else if (noResultsRow) {
                noResultsRow.style.display = 'none';
            }
        });

        // Ordenamiento de columnas
        columnHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const column = this.getAttribute('data-column');
                
                if (sortColumn === column) {
                    sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
                } else {
                    sortColumn = column;
                    sortDirection = 'asc';
                }

                // Resetear indicadores
                columnHeaders.forEach(h => {
                    const span = h.querySelector('span');
                    if (span) span.textContent = '↕';
                    h.classList.remove('bg-gray-100');
                });
                
                const activeSpan = this.querySelector('span');
                if (activeSpan) activeSpan.textContent = sortDirection === 'asc' ? '↑' : '↓';
                this.classList.add('bg-gray-100');

                // Ordenar filas
                const visibleRows = Array.from(tableRows).filter(row => {
                    return row.style.display !== 'none' && !row.querySelector('td[colspan]');
                });

                visibleRows.sort((a, b) => {
                    let aValue = '', bValue = '';
                    
                    if (column === 'name') {
                        aValue = a.cells[0].textContent.trim();
                        bValue = b.cells[0].textContent.trim();
                    } else if (column === 'email') {
                        aValue = a.cells[1].textContent.trim();
                        bValue = b.cells[1].textContent.trim();
                    } else if (column === 'puesto') {
                        aValue = a.cells[2].textContent.trim();
                        bValue = b.cells[2].textContent.trim();
                    }

                    return sortDirection === 'asc' 
                        ? aValue.localeCompare(bValue)
                        : bValue.localeCompare(aValue);
                });

                const tbody = document.querySelector('tbody');
                visibleRows.forEach(row => tbody.appendChild(row));
            });
        });
    </script>
</x-app-layout>