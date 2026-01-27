<x-app-layout>
    {{-- titulo --}}
    <x-slot name="title">
        Entradas/Salidas - TSM Sistemas Integrales
    </x-slot> 
<div class="my-2 max-w-7xl mx-auto w-full">

@if(session('success'))
    <x-alert type="success">
        <x-slot name="message"> ¡Éxito! </x-slot>
        {{ session('success') }}
    </x-alert>
@endif


@if($errors->has('error'))
    <x-alert type="warning"> {{-- O type="error" según tu componente --}}
        <x-slot name="message"> ¡Error! </x-slot>
        {{ $errors->first('error') }}
    </x-alert>
@endif
</div>

<div x-data="inventoryManager()" class="py-6 h-screen flex flex-col">
        
        <div class="max-w-7xl mx-auto w-full px-4 mb-4">
            <div class="bg-white p-4 rounded-lg shadow flex items-center gap-6">
                <h2 class="text-xl font-bold text-gray-800">Movimientos de Inventario</h2>
                
                <div class="flex items-center gap-4 bg-white p-2 rounded-md">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" x-model="tipoGlobal" value="entrada" class="text-green-600">
                        <span class="font-semibold text-green-700">Entrada ↓</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" x-model="tipoGlobal" value="salida" class="text-red-600">
                        <span class="font-semibold text-red-700">Salida ↑</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex-1 max-w-7xl mx-auto w-full px-4 grid grid-cols-12 gap-6 overflow-hidden">
            
            <div class="col-span-4 bg-white rounded-lg shadow flex flex-col overflow-hidden">
               @include('inventario.partials.lista_productos')
            </div>

            <div class="col-span-8 bg-white rounded-lg shadow flex flex-col overflow-hidden">
                @include('inventario.partials.carrito')
            </div>

        </div>
    </div>
</x-app-layout>

<script>
    function inventoryManager() {
        return {
            movimientos: [],
            tipoGlobal: 'entrada',
            search: '',
            mostrarConfirmacion: false,
            
            // Función de búsqueda (Nombre o Clave)
            match(desc, clave) {
                const s = this.search.toLowerCase();
                return desc.includes(s) || clave.includes(s);
            },

            // Agregar a la lista de la derecha
            agregar(producto) {
                // Evitar duplicados: Si ya está, mejor avisar o sumar
                const existe = this.movimientos.find(m => m.id === producto.id && m.tipo === this.tipoGlobal);
                
                if (existe) {
                    existe.cantidad++;
                } else {
                    this.movimientos.push({
                        id: producto.id,
                        descripcion: producto.descripcion,
                        cantidad: 1,
                        tipo: this.tipoGlobal
                    });
                }
            },

            eliminar(index) {
                this.movimientos.splice(index, 1);
            }
        }
    }
</script>