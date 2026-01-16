<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Helpers\BitacoraHelper;
use Illuminate\Support\Facades\DB;
use App\Models\Reporte;
class InventoryController extends Controller
{
    public function index(){
        $productos = Product::orderBy('clave', 'asc')->get();

        return view('inventario.index', compact('productos'));
    }

    public function store(Request $request){

        $request->validate([
            'items.*.id' => 'required|exists:products,id',
            'items.*.cantidad' => 'required|integer|min:1',
            'items.*.tipo' => 'required|in:entrada,salida',
        ]);


        DB::beginTransaction();
        try{
            foreach($request->items as $item){
                $producto = Product::findOrFail($item['id']);
                if($item['tipo'] === 'entrada'){
                    $producto->increment('stock', $item['cantidad']);
                }
                elseif($item['tipo'] === 'salida' && $producto->stock < $item['cantidad']){
                    throw new \Exception('No hay suficiente stock para el producto: ' . $producto->descripcion);
                }  
                else{
                    $producto->decrement('stock', $item['cantidad']);
                }
                //creamos un reporte por cada producto que se agrega o sale
                Reporte::create([
                    'product_id' => $producto->id,
                    'user_id' => auth()->id(),
                    'cantidad' => $item['cantidad'],
                    'tipo_reporte' => $item['tipo'],
                ]);
                
                // Registrar en bitácora
                $tipo_texto = $item['tipo'] === 'entrada' ? 'entrada' : 'salida';
                BitacoraHelper::registrarMovimiento(
                    $tipo_texto,
                    $producto,
                    $item['cantidad']
                );
            }
            DB::commit();
            return redirect()->route('inventory.index')->with('success', 'Stock Actualizado');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('inventory.index')->withErrors(['error' => 'Error al actualizar el stock '. $e->getMessage()]);
        }
    }
}
