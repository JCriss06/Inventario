<x-app-layout>
    <x-slot name="header">
        <div class="bg-white">
            <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
                {{ __("Agregar Productos") }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Tabs Navigation -->
            <div class="mb-6">
                <div class="border-b border-gray-200">
                    <nav class="flex gap-8" aria-label="Tabs">
                        <button type="button" onclick="cambiarTab('individual')" id="tab-individual" 
                            class="tab-button active py-4 px-1 border-b-2 border-rose-600 font-medium text-sm text-rose-600">
                            Producto Individual
                        </button>
                        <button type="button" onclick="cambiarTab('kit')" id="tab-kit"
                            class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Kit (Varios productos)
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Formulario Individual -->
            <div id="content-individual" class="tab-content">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold mb-2 text-gray-900">Nuevo Producto Individual</h2>
                    <p class="text-sm text-gray-600 mb-6">Agrega un producto al inventario</p>

                    <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="tipo" value="individual">

                        <div>
                            <label for="clave" class="block text-sm font-medium text-gray-700 mb-2">
                                Clave <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="clave" name="clave" placeholder="Ej: PROD-001"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent @error('clave') border-red-500 @enderror"
                                required autofocus>
                            @error('clave')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción
                            </label>
                            <textarea id="descripcion" name="descripcion" rows="3" placeholder="Descripción detallada del producto"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="marca" class="block text-sm font-medium text-gray-700 mb-2">
                                    Marca
                                </label>
                                <input type="text" id="marca" name="marca" placeholder="Ej: Dell"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent">
                            </div>

                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                                    Stock Inicial <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="stock" name="stock" min="0" placeholder="0"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent @error('stock') border-red-500 @enderror"
                                    required>
                                @error('stock')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('products.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                                Cancelar
                            </a>
                            <button type="submit" class="px-6 py-2 bg-rose-600 text-white font-medium rounded-lg hover:bg-rose-700 transition-colors">
                                Guardar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Formulario Kit -->
            <div id="content-kit" class="tab-content hidden">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <form action="{{ route('products.store') }}" method="POST" class="space-y-6" id="form-kit">
                        @csrf
                        <input type="hidden" name="tipo" value="kit">

                        <!-- Información del Kit -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-4">
                            <h3 class="font-semibold text-gray-900 text-lg">Información del Kit</h3>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="nombre_kit" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nombre del Kit <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="nombre_kit" name="nombre_kit" placeholder="Ej: Kit Gaming"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent"
                                        required>
                                </div>

                                <div>
                                    <label for="codigo_kit" class="block text-sm font-medium text-gray-700 mb-2">
                                        Código del Kit <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="codigo_kit" name="codigo_kit" placeholder="Ej: KIT-001"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent"
                                        required>
                                </div>
                            </div>

                            <div>
                                <label for="descripcion_kit" class="block text-sm font-medium text-gray-700 mb-2">
                                    Descripción del Kit
                                </label>
                                <textarea id="descripcion_kit" name="descripcion_kit" rows="2" placeholder="Describe qué contiene este kit"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent"></textarea>
                            </div>
                        </div>

                        <!-- Productos del Kit -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-gray-900 text-lg">Productos del Kit</h3>
                                <button type="button" onclick="agregarFila()" class="flex items-center gap-2 px-4 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 transition-colors text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Agregar Fila
                                </button>
                            </div>
                            <div id="filas-container" class="space-y-4"></div>
                        </div>

                        <!-- Total de Productos -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-sm text-blue-800">Total de productos: <span id="total-filas" class="font-semibold">0</span></p>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('products.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50">
                                Cancelar
                            </a>
                            <button type="submit" class="px-6 py-2 bg-rose-600 text-white font-medium rounded-lg hover:bg-rose-700">
                                Guardar Kit Completo
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        let contadorFilas = 0;

        function cambiarTab(tab) {
            document.querySelectorAll(".tab-content").forEach(el => el.classList.add("hidden"));
            document.querySelectorAll(".tab-button").forEach(el => {
                el.classList.remove("border-rose-600", "text-rose-600");
                el.classList.add("border-transparent", "text-gray-500");
            });

            document.getElementById("content-" + tab).classList.remove("hidden");
            document.getElementById("tab-" + tab).classList.remove("border-transparent", "text-gray-500");
            document.getElementById("tab-" + tab).classList.add("border-rose-600", "text-rose-600");

            if (tab === "kit" && document.querySelectorAll("[id^='fila-']").length === 0) {
                agregarFila();
            }
        }

        function agregarFila() {
            contadorFilas++;
            const id = contadorFilas;
            
            const html = `
                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50" id="fila-${id}">
                    <div class="flex items-start justify-between mb-4">
                        <h4 class="text-sm font-medium text-gray-700">Producto #${document.querySelectorAll("[id^='fila-']").length + 1}</h4>
                        <button type="button" onclick="eliminarFila(${id})" class="text-red-600 hover:bg-red-50 p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Clave <span class="text-red-500">*</span></label>
                            <input type="text" name="productos[${id}][clave]" placeholder="Ej: PROD-001"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Marca <span class="text-red-500">*</span></label>
                            <input type="text" name="productos[${id}][marca]" placeholder="Ej: Dell"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent"
                                required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción <span class="text-red-500">*</span></label>
                            <textarea name="productos[${id}][descripcion]" rows="2" placeholder="Descripción detallada del producto"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent"
                                required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Stock Inicial <span class="text-red-500">*</span></label>
                            <input type="number" name="productos[${id}][stock]" min="0" placeholder="0"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent"
                                required>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById("filas-container").insertAdjacentHTML("beforeend", html);
            actualizarTotal();
        }

        function eliminarFila(id) {
            const fila = document.getElementById("fila-" + id);
            if (fila) {
                fila.remove();
                actualizarTotal();
            }
        }

        function actualizarTotal() {
            const filas = document.querySelectorAll("[id^='fila-']").length;
            document.getElementById("total-filas").textContent = filas;
        }

        document.addEventListener("DOMContentLoaded", function() {
            agregarFila();
        });
    </script>
</x-app-layout>
