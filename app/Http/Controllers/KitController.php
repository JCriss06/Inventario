<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kit;
use App\Models\Product;

class KitController extends Controller
{
    /**
     * Display a listing of kits
     */
    public function index()
    {
        $kits = Kit::with('productos')->paginate(15);
        return view('kits.index', compact('kits'));
    }

    /**
     * Show the form for creating a new kit
     */
    public function create()
    {
        $productos = Product::orderBy('clave')->get();
        return view('kits.create', compact('productos'));
    }

    /**
     * Store a newly created kit in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:kits|max:255',
            'codigo_kit' => 'required|unique:kits|max:20',
            'descripcion' => 'nullable|max:255',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.cantidad' => 'required|integer|min:1',
        ]);

        $kit = Kit::create([
            'nombre' => $request->input('nombre'),
            'codigo_kit' => $request->input('codigo_kit'),
            'descripcion' => $request->input('descripcion'),
        ]);

        // Agregar productos al kit
        foreach ($request->input('items') as $item) {
            $kit->productos()->attach($item['product_id'], [
                'cantidad' => $item['cantidad']
            ]);
        }

        return redirect()->route('kits.index')->with('success', 'Kit creado exitosamente');
    }

    /**
     * Display the specified kit
     */
    public function show(Kit $kit)
    {
        $kit->load('productos');
        return view('kits.show', compact('kit'));
    }

    /**
     * Show the form for editing the specified kit
     */
    public function edit(Kit $kit)
    {
        $kit->load('productos');
        $productos = Product::orderBy('clave')->get();
        return view('kits.edit', compact('kit', 'productos'));
    }

    /**
     * Update the specified kit in storage
     */
    public function update(Request $request, Kit $kit)
    {
        $request->validate([
            'nombre' => "required|unique:kits,nombre,{$kit->id}|max:255",
            'codigo_kit' => "required|unique:kits,codigo_kit,{$kit->id}|max:20",
            'descripcion' => 'nullable|max:255',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.cantidad' => 'required|integer|min:1',
        ]);

        $kit->update([
            'nombre' => $request->input('nombre'),
            'codigo_kit' => $request->input('codigo_kit'),
            'descripcion' => $request->input('descripcion'),
        ]);

        // Actualizar productos del kit
        $kit->productos()->detach();
        foreach ($request->input('items') as $item) {
            $kit->productos()->attach($item['product_id'], [
                'cantidad' => $item['cantidad']
            ]);
        }

        return redirect()->route('kits.index')->with('success', 'Kit actualizado correctamente');
    }

    /**
     * Remove the specified kit from storage
     */
    public function destroy(Kit $kit)
    {
        $kit->productos()->detach();
        $kit->delete();
        return redirect()->route('kits.index')->with('success', 'Kit eliminado correctamente');
    }
}
