
    <x-modal name="Update product {{$prod->id}}">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Actualizar Producto</h2>
            <p class="text-sm text-gray-600 mt-1">Edita la información del producto</p>
        </div>

        <div class="px-6 py-4">
            <form action="{{route('products.update', $prod->id)}}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="clave_{{$prod->id}}" class="block text-sm font-medium text-gray-700 mb-1">Clave</label>
                    <input type="text" id="clave_{{$prod->id}}" name="clave" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                        value="{{$prod->clave}}" />
                    @error('clave')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="descripcion_{{$prod->id}}" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <input type="text" id="descripcion_{{$prod->id}}" name="descripcion" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                        value="{{$prod->descripcion}}" />
                    @error('descripcion')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="marca_{{$prod->id}}" class="block text-sm font-medium text-gray-700 mb-1">Marca</label>
                    <input type="text" id="marca_{{$prod->id}}" name="marca" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                        value="{{$prod->marca}}" />
                    @error('marca')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                    <button type="button" @click="$dispatch('close-modal', 'Update product {{$prod->id}}')" class="px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </x-modal>


