<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;
use Illuminate\Support\Carbon;
use Dompdf\Dompdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
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

        // Filtro por Producto
        if ($request->filled('producto')) {
            $query->where('product_id', $request->producto);
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

        // Calcular Stock Actual por Producto (Todas las entradas - Todas las salidas de la historia)
        $stocks = [];
        
        // Obtener todos los reportes sin filtros para calcular stock total histórico
        $todosReportes = Reporte::with('product')->get();
        
        foreach ($todosReportes as $reporte) {
            $productId = $reporte->product_id;
            
            if (!isset($stocks[$productId])) {
                $stocks[$productId] = [
                    'entradas' => 0,
                    'salidas' => 0,
                    'product' => $reporte->product
                ];
            }
            
            if ($reporte->tipo_reporte === 'entrada') {
                $stocks[$productId]['entradas'] += $reporte->cantidad;
            } else {
                $stocks[$productId]['salidas'] += $reporte->cantidad;
            }
        }

        // Separar stocks en alertas y normales
        $alertas = [];
        $normales = [];
        
        foreach ($stocks as $productId => $stock) {
            $neto = $stock['entradas'] - $stock['salidas'];
            
            if ($neto <= 2) {  // Rojo (≤0) o Amarillo (≤2)
                $alertas[$productId] = array_merge($stock, ['neto' => $neto]);
            } else {
                $normales[$productId] = array_merge($stock, ['neto' => $neto]);
            }
        }
        
        // Ordenar alertas por criticidad (mayor urgencia primero)
        uasort($alertas, function($a, $b) {
            return $a['neto'] <=> $b['neto'];
        });

        // Obtener lista de todos los productos para el dropdown
        $productos = \App\Models\Product::orderBy('clave')->get();

        return view('reportes.index', compact('reportes', 'stocks', 'alertas', 'normales', 'productos'));
    }

    public function exportPdf(Request $request)
    {
        $query = Reporte::with(['product', 'user'])->latest();

        // Aplicar los mismos filtros que en index
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

        if ($request->filled('producto')) {
            $query->where('product_id', $request->producto);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo_reporte', $request->tipo);
        }

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin]);
        }

        $reportes = $query->get();

        // Calcular resumen
        $totalEntradas = $reportes->where('tipo_reporte', 'entrada')->sum('cantidad');
        $totalSalidas = $reportes->where('tipo_reporte', 'salida')->sum('cantidad');

        // Generar HTML para el PDF
        $html = view('reportes.pdf', compact('reportes', 'totalEntradas', 'totalSalidas', 'request'))->render();

        // Crear instancia de Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Descargar el PDF
        return $dompdf->stream('reportes-inventario-' . now()->format('Y-m-d-His') . '.pdf');
    }
}
