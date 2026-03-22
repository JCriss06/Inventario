<div class="p-4 border-b">
    <input type="text" x-model="search" placeholder="Buscar por nombre o clave..." 
           class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">
</div>

<div class="flex-1 overflow-y-auto p-4">
    <div class="space-y-2">
        @foreach($productos as $prod)
        <div x-show="match('{{ strtolower($prod->descripcion) }}', '{{ strtolower($prod->clave) }}')"
             class="p-3 border rounded-md hover:bg-gray-50 flex justify-between items-center group">
            <div>
                <p class="font-bold text-gray-800">{{ $prod->descripcion }}</p>
                <p class="text-xs text-gray-500 uppercase">{{ $prod->clave }}</p>
                <p class="text-xs font-semibold text-indigo-600">Stock: {{ $prod->stock }}</p>
            </div>
            <button @click="agregar({{ json_encode($prod) }})" 
                    class="bg-indigo-600 text-white p-2 rounded-full hover:bg-indigo-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </button>
        </div>
        @endforeach
    </div>
</div>