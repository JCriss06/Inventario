<x-modal name="Add product"   > 
    <div class="bg-slate-100 border-b border-black px-4 py-3 flex justify-between items-center">
   <h2 class = "text-lg font-semibold text-gray-900 mx-4 my-4 "> Nuevo Producto </h2>

</div>
    <form method="POST" action="{{ route('products.store') }}" class="mt-6 space-y-6 m-6 bg-gray-100 p-4 rounded-lg">
        @csrf

        <div>
            <x-input-label for="clave" :value="__('Clave')" />
            <x-text-input id="clave" name="clave" type="text" class="mt-1 block w-full" required autofocus autocomplete="clave" />
            <x-input-error class="mt-2" :messages="$errors->get('clave')" />
        </div>


        <div>
            <x-input-label for="descripcion" :value="__('Descripción')" />
            <x-text-input id="descripcion" name="descripcion" type="text" class="mt-1 block w-full" autofocus autocomplete="descripcion" />
            <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
        </div>

        <div>
            <x-input-label for="marca" :value="__('Marca')" />
            <x-text-input id="marca" name="marca" type="text" class="mt-1 block w-full" autofocus autocomplete="marca" />
            <x-input-error class="mt-2" :messages="$errors->get('marca')" />
        </div>

        <div>
            <x-input-label for="stock" :value="__('Stock')" />
            <x-text-input id="stock" name="stock" type="text" class="mt-1 block w-full" value="0" autofocus autocomplete="stock" />
            <x-input-error class="mt-2" :messages="$errors->get('stock')" />
        </div>

        <div class="flex justify-end items-center gap-4">

        <a href="{{ route('products.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Cancelar') }}
            </a>

            <x-primary-button>{{ __('Guardar') }}</x-primary-button>
        </div>
    </form>
</x-modal>