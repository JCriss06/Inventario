<form action="{{ route('inventory.store') }}" method="POST" class="flex flex-col h-full">
    @csrf
    <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
        <h3 class="font-bold text-gray-700">Productos en Movimiento</h3>
        <span class="bg-gray-200 px-3 py-1 rounded-full text-sm font-bold" x-text="movimientos.length"></span>
    </div>

    <div class="flex-1 overflow-y-auto p-4">
        <!-- Mensaje cuando no hay productos -->
        <div x-show="movimientos.length === 0" class="flex flex-col items-center justify-center h-full text-gray-500">
            <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <p class="text-center text-sm font-medium">No hay productos agregados</p>
            <p class="text-center text-xs text-gray-400 mt-1">Selecciona productos de la izquierda para crear movimientos</p>
        </div>

        <!-- Tabla cuando hay productos -->
        <div x-show="movimientos.length > 0">
            <table class="w-full">
                <thead class="text-left text-xs text-gray-500 uppercase border-b">
                    <tr>
                        <th class="pb-2">Producto</th>
                        <th class="pb-2">Tipo</th>
                        <th class="pb-2 w-24">Cantidad</th>
                        <th class="pb-2 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(item, index) in movimientos" :key="index">
                        <tr class="border-b animate-in fade-in duration-200">
                            <td class="py-3">
                                <span x-text="item.descripcion" class="font-medium"></span>
                                <input type="hidden" :name="'items['+index+'][id]'" :value="item.id">
                            </td>
                            <td class="py-3">
                                <span x-text="item.tipo === 'entrada' ? 'Entrada ↓' : 'Salida ↑'"
                                      :class="item.tipo === 'entrada' ? 'text-green-600' : 'text-red-600'"
                                      class="text-xs font-bold px-2 py-1 bg-gray-100 rounded"></span>
                                <input type="hidden" :name="'items['+index+'][tipo]'" :value="item.tipo">
                            </td>
                            <td class="py-3 text-center">
                                <input type="number" :name="'items['+index+'][cantidad]'" x-model="item.cantidad" 
                                       class="w-20 p-1 border rounded text-center" min="1">
                            </td>
                            <td class="py-3 text-right">
                                <button type="button" @click="eliminar(index)" class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/></svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <div class="p-6 bg-gray-50 border-t" x-show="movimientos.length > 0">
        <x-primary-button class="w-full justify-center py-3 text-lg">
            Guardar Movimiento
        </x-primary-button>
    </div>
</form>