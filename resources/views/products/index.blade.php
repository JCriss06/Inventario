<x-app-layout>
@include ('products.partials.create-product-modal')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Productos') }}
        </h2>
</x-slot>
{{-- <h1><b>Lista de Productos</b></h1>--}}

<div class="mx-auto py-4 ">
    <div class="flex justify-end my-4 mb-4 mr-24 gap-6"> 
       
        <x-primary-button x-data=""  x-on:click.prevent="$dispatch('open-modal', 'Add product')" class="bg-red-600 hover:bg-red-300"> Agregar Producto 
        </x-primary-button>
        <x-primary-button class="bg-red-600 hover:bg-red-300"> Entradas/Salidas </x-primary-button>
    </div>

</div>
<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default bg-white mx-24">
    <table class="w-full text-sm text-left rtl:text-right text-body">
        <thead class="bg-neutral-secondary-soft border-b border-default">
            <tr>
                <th scope="col" class="px-6 py-3 font-medium">
                    clave
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Descripción
                </th>
                 <th scope="col" class="px-6 py-3 font-medium">
                    Marca
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Stock
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($producto as $prod)
            <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-default">
                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                    {{$prod->clave}}
                </th>
                <td class="px-6 py-4">
                    {{$prod->descripcion}}
                </td>
                 <td class="px-6 py-4">
                    {{$prod->marca}}
                </td>
                <td class="px-6 py-4">
                    {{$prod->stock}}
                </td>
                <td class="px-6 py-4">
                    <div class ="flex gap-2 items-center"> 
                        <a href="#">
                            <x-icon name="icon-edit" stroke="1.5" class="h-4 w-4"> </x-icon>
                        </a>
                        <button type="button"> 
                            <x-icon name="icon-delete" stroke="1.5" class="h-4 w-4"> </x-icon>
                         </button>
                    </div>
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
 

</x-app-layout>