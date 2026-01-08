<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;
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
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'clave' => 'required | unique:products | max:20',
            'descripcion' => 'nullable | max:255',
            'marca' => 'nullable | max:255',
            'stock' => 'required | integer | min:0',
        ]);

        Product::create($request->all());


        return redirect()->route('products.index');
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
            'clave' => "required | unique:products,clave,{$producto->id} | max:20",
            'descripcion' => 'nullable | max:255',
            'marca' => 'nullable | max:255',
        ]);
        
       
        $producto->update($request->only(['clave', 'descripcion', 'marca']));

        return redirect()->route('products.index');
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
