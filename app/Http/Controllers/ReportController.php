<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;
use Illuminate\support\Carbon;
class ReportController extends Controller
{
    public function index(Request $request){

       $query = Reporte::with(['product', 'user'])->latest();

    // Filtro por Periodos Predefinidos
    if ($request->filled('periodo')) {
        switch ($request->periodo) {
            case 'hoy':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'semana':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'mes':
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
                break;
            case 'año':
                $query->whereYear('created_at', Carbon::now()->year);
                break;
        }
    }

    // Filtro por Tipo (Entrada/Salida)
    if ($request->filled('tipo')) {
        $query->where('tipo_reporte', $request->tipo);
    }

    // Filtro por Fecha Manual (Si el usuario elige un rango)
    if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
        $query->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin]);
    }

    $reportes = $query->get();

    return view('reportes.index', compact('reportes'));
}

}
