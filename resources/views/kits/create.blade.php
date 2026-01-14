<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-purple-100 to-blue-100">
            <h2 class="font-semibold text-2xl text-purple-900 leading-tight">
                {{ __('Crear Kit') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold mb-2 text-gray-900">Nuevo Kit de Productos</h2>
                <p class="text-sm text-gray-600 mb-6">Agrupa múltiples productos en un kit</p>

                <form action="{{ route('kits.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Información del Kit -->
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4 border border-gray-200">
                        <h3 class="font-semibold text-gray-900">Información del Kit</h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nombre del Kit <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nombre" name="nombre" placeholder="Ej: Kit Gaming Completo"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('nombre') border-red-500 @enderror"
                                    required value="{{ old('nombre') }}">
                                @error('nombre')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="codigo_kit" class="block text-sm font-medium text-gray-700 mb-2">
                                    Código del Kit <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="codigo_kit" name="codigo_kit" placeholder="Ej: KIT-001"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('codigo_kit') border-red-500 @enderror"
                                    required value="{{ old('codigo_kit') }}">
                                @error('codigo_kit')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción del Kit
                            </label>
                            <textarea id="descripcion" name="descripcion" rows="2" placeholder="Describe qué contiene este kit"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('descripcion') }}</textarea>
                        </div>
                    </div>

                    <!-- Productos del Kit -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-gray-900">Productos del Kit</h3>
                            <button type="button" onclick="agregarFilaProducto()" class="flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors text-sm font-medium">
                                ➕ Agregar Producto
                            </button>
                        </div>
                        <div id="productos-container" class="space-y-3">
                            <!-- Las filas se agregan dinámicamente aquí -->
                        </div>
                    </div>

                    <!-- Resumen -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm text-blue-800">
                            Total de productos en el kit: <span id="total-productos" class="font-semibold">0</span>
                        </p>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('kits.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" class="px-6 py-2 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors">
                            Guardar Kit
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        const productosDisponibles = {!! json_encode($productos->map(function($p) { 
            return ['id' => $p->id, 'clave' => $p->clave, 'descripcion' => $p->descripcion]; 
        })) !!};
        
        let contadorFilas = 0;

        function agregarFilaProducto() {
            contadorFilas++;
            const id = contadorFilas;
            
            const html = `
                <div class="flex items-end gap-3 p-4 bg-gray-50 border border-gray-200 rounded-lg" id="fila-${id}">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Producto</label>
                        <select name="items[${id}][product_id]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                            <option value="">-- Seleccionar producto --</option>
                            ${productosDisponibles.map(p => `<option value="${p.id}">${p.clave} - ${p.descripcion}</option>`).join('')}
                        </select>
                    </div>

                    <div class="w-32">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad</label>
                        <input type="number" name="items[${id}][cantidad]" min="1" value="1" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                    </div>

                    <button type="button" onclick="eliminarFila(${id})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                        ❌
                    </button>
                </div>
            `;

            document.getElementById('productos-container').insertAdjacentHTML('beforeend', html);
            actualizarTotal();
        }

        function eliminarFila(id) {
            document.getElementById('fila-' + id).remove();
            actualizarTotal();
        }

        function actualizarTotal() {
            const filas = document.querySelectorAll('[id^="fila-"]').length;
            document.getElementById('total-productos').textContent = filas;
        }

        document.addEventListener('DOMContentLoaded', function() {
            agregarFilaProducto();
        });
    </script>
</x-app-layout>
