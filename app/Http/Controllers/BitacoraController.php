<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use Illuminate\Http\Request;

class BitacoraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Bitacora::with('user')->orderBy('created_at', 'desc');

        // Filtro por tipo de acción
        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }

        // Filtro por usuario
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Búsqueda por descripción
        if ($request->filled('search')) {
            $query->where('descripcion', 'like', '%' . $request->search . '%');
        }

        $bitacoras = $query->paginate(15);

        // Estadísticas
        $stats = [
            'total' => Bitacora::count(),
            'crear' => Bitacora::where('accion', 'crear')->count(),
            'editar' => Bitacora::where('accion', 'editar')->count(),
            'eliminar' => Bitacora::where('accion', 'eliminar')->count(),
            'sesion' => Bitacora::where('accion', 'sesion')->count(),
        ];

        // Usuarios para el filtro
        $users = \App\Models\User::all();

        return view('bitacoras.index', compact('bitacoras', 'stats', 'users'));
    }

    /**
     * Registrar una acción en la bitácora
     */
    public static function registrar(string $accion, ?int $registroId = null, ?string $descripcion = null): void
    {
        if (auth()->check()) {
            Bitacora::create([
                'user_id' => auth()->id(),
                'accion' => $accion,
                'registro_id' => $registroId,
                'descripcion' => $descripcion,
            ]);
        }
    }
}
