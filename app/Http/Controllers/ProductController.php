<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Kit;
use App\Helpers\BitacoraHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class ProductController extends Controller implements HasMiddleware
{

public static function middleware(): array
    {
        return [
            // Ver lista
            new Middleware('can:ver productos', only: ['index', 'show']),
            
            // Crear
            new Middleware('can:crear productos', only: ['create', 'store']),

            // Editar
            new Middleware('can:editar productos', only: ['edit', 'update']),

            // Eliminar
            new Middleware('can:eliminar productos', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $producto = Product::orderBy('clave','asc')
        ->select('id','clave','descripcion','marca','stock')->paginate();


        return view('products.index', compact('producto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Product::orderBy('clave')->get();
        return view('products.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tipo = $request->input('tipo', 'individual');

        if ($tipo === 'individual') {
            return $this->storeProductoIndividual($request);
        } else {
            return $this->storeProductosMasivos($request);
        }
    }

    /**
     * Guardar un producto individual
     */
    private function storeProductoIndividual(Request $request)
    {
        $request->validate([
            'clave' => 'required|unique:products|max:20',
            'descripcion' => 'nullable|max:255',
            'marca' => 'nullable|max:255',
            'stock' => 'required|numeric|integer|min:0|max:999999',
        ]);

        $producto = Product::create($request->only(['clave', 'descripcion', 'marca', 'stock']));
        
        // Registrar en bitácora
        BitacoraHelper::registrarCrearProducto($producto);

        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente');
    }

    /**
     * Guardar múltiples productos a la vez (carga masiva para inventario)
     */
    private function storeProductosMasivos(Request $request)
    {
        $request->validate([
            'productos.*.clave' => 'required|unique:products,clave|max:20',
            'productos.*.marca' => 'required|max:255',
            'productos.*.descripcion' => 'required|max:255',
            'productos.*.stock' => 'required|numeric|integer|min:0|max:999999',
        ]);

        DB::beginTransaction();
        try {
            $productosAgregados = 0;

            // Crear cada producto
            foreach ($request->input('productos') as $item) {
                $producto = Product::create([
                    'clave' => $item['clave'],
                    'marca' => $item['marca'],
                    'descripcion' => $item['descripcion'],
                    'stock' => $item['stock'],
                ]);

                // Registrar creación de cada producto en bitácora
                BitacoraHelper::registrarCrearProducto($producto);
                $productosAgregados++;
            }

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Se agregaron ' . $productosAgregados . ' productos exitosamente');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Error al agregar productos: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $producto = Product::findOrFail($id);
         $request->validate([
            'clave' => "required|unique:products,clave,{$producto->id}|max:20",
            'descripcion' => 'nullable|max:255',
            'marca' => 'nullable|max:255',
        ]);
        
        // Capturar cambios antes de actualizar
        $cambios = [];
        if ($producto->clave !== $request->clave) $cambios['clave'] = $request->clave;
        if ($producto->descripcion !== $request->descripcion) $cambios['descripcion'] = $request->descripcion;
        if ($producto->marca !== $request->marca) $cambios['marca'] = $request->marca;
        
        $producto->update($request->only(['clave', 'descripcion', 'marca']));
        
        // Registrar en bitácora si hubo cambios
        if (!empty($cambios)) {
            BitacoraHelper::registrarEditarProducto($producto, $cambios);
        }

        return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Product::findOrFail($id);
        
        // Eliminar primero todos los reportes relacionados (entradas/salidas)
        \App\Models\Reporte::where('product_id', $producto->id)->delete();
        
        // Registrar eliminación en bitácora
        BitacoraHelper::registrarEliminarProducto($producto);
        
        $producto->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado correctamente');
    }
}

