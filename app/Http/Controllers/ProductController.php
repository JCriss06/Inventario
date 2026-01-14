<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Kit;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
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
            return $this->storeKit($request);
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
            'stock' => 'required|integer|min:0',
        ]);

        Product::create($request->only(['clave', 'descripcion', 'marca', 'stock']));

        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente');
    }

    /**
     * Guardar un kit con múltiples productos (nuevos)
     */
    private function storeKit(Request $request)
    {
        $request->validate([
            'nombre_kit' => 'required|unique:kits,nombre|max:255',
            'codigo_kit' => 'required|unique:kits,codigo_kit|max:20',
            'descripcion_kit' => 'nullable|max:255',
            'productos.*.clave' => 'required|unique:products,clave|max:20',
            'productos.*.marca' => 'required|max:255',
            'productos.*.descripcion' => 'required|max:255',
            'productos.*.stock' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Crear el kit
            $kit = Kit::create([
                'nombre' => $request->input('nombre_kit'),
                'codigo_kit' => $request->input('codigo_kit'),
                'descripcion' => $request->input('descripcion_kit'),
            ]);

            // Crear productos y agregarlos al kit
            foreach ($request->input('productos') as $item) {
                $producto = Product::create([
                    'clave' => $item['clave'],
                    'marca' => $item['marca'],
                    'descripcion' => $item['descripcion'],
                    'stock' => $item['stock'],
                ]);

                // Agregar el producto al kit con cantidad 1
                $kit->productos()->attach($producto->id, ['cantidad' => 1]);
            }

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Kit creado exitosamente con ' . count($request->input('productos')) . ' productos nuevos');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Error al crear el kit: ' . $e->getMessage()]);
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
        
       
        $producto->update($request->only(['clave', 'descripcion', 'marca']));

        return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Product::findOrFail($id);
        $producto->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado correctamente');
    }
}

