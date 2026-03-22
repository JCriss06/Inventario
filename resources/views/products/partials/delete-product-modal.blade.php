
    <x-modal name="Delete product {{$prod->id}}">
        <div class="px-6 py-4 border-b border-red-200 bg-red-50">
            <h2 class="text-lg font-semibold text-red-900">⚠️ Eliminar Producto</h2>
            <p class="text-sm text-red-700 mt-1">Esta acción no se puede deshacer</p>
        </div>

        <div class="px-6 py-4">
            <p class="text-sm text-gray-600 mb-4">¿Estás seguro de que deseas eliminar este producto?</p>

            <!-- Detalles del producto -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6 space-y-3 border border-gray-200">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Clave</p>
                    <p class="text-sm font-medium text-gray-900">{{ $prod->clave }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Descripción</p>
                    <p class="text-sm text-gray-700">{{ $prod->descripcion }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Marca</p>
                    <p class="text-sm text-gray-700">{{ $prod->marca ?? 'No especificada' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Stock Actual</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $prod->stock }} unidades</p>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <button type="button" @click="$dispatch('close-modal', 'Delete product {{$prod->id}}')" class="px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors">
                    Cancelar
                </button>
                <form action="{{ route('products.destroy', $prod->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                        Eliminar Producto
                    </button>
                </form>
            </div>
        </div>
    </x-modal>
