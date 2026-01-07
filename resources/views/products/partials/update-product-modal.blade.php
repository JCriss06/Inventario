
    <x-modal name="Update product {{$prod->id}}" >

    <div class="bg-slate-100 border-b border-black px-4 py-3 flex justify-between items-center">
   <h2 class = "text-lg font-semibold text-gray-900 mx-4 my-4 "> Nuevo Producto </h2>

</div>

<div class="m-6 bg-gray-200 py-4 px-4">
    <form action="{{route('products.update', $prod->id)}}" method="POST">
        @csrf
        @method('PUT')

       <div class="m-2">
            <x-input-label for="clave" :value="__('Clave')" />
            <x-text-input id="clave" name="clave" type="text" class="mt-1 block w-full" value="{{$prod->clave}}" />
            <x-input-error class="mt-2" :messages="$errors->get('clave')" />
        </div>


        <div class="m-2">
            <x-input-label for="descripcion" :value="__('Descripción')" />
            <x-text-input id="descripcion" name="descripcion" type="text" class="mt-1 block w-full" value="{{$prod->descripcion}}" />
            <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
        </div>

        <div class="m-2">
            <x-input-label for="marca" :value="__('Marca')" />
            <x-text-input id="marca" name="marca" type="text" class="mt-1 block w-full" value="{{$prod->marca}}" />
            <x-input-error class="mt-2" :messages="$errors->get('marca')" />
        </div>



    <div class="flex justify-end my-2 mr-2">
    <x-primary-button> Actualizar </x-primary-button>
      </div>
    </form>
</div>
    </x-modal>


