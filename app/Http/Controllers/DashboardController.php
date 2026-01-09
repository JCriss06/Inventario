<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas generales
        $totalProducts = Product::count();
        $lowStockCount = Product::where('stock', '<=', 10)->count();
        $totalStockValue = Product::sum('stock');
        
        // Movimientos del día
        $todayMovements = Reporte::whereDate('created_at', Carbon::today())->count();
        $todayEntradas = Reporte::whereDate('created_at', Carbon::today())
            ->where('tipo_reporte', 'entrada')->sum('cantidad');
        $todaySalidas = Reporte::whereDate('created_at', Carbon::today())
            ->where('tipo_reporte', 'salida')->sum('cantidad');
        
        // Productos con stock bajo
        $lowStockProducts = Product::where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();
        
        // Productos recientes
        $recentProducts = Product::orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'lowStockCount',
            'totalStockValue',
            'todayMovements',
            'todayEntradas',
            'todaySalidas',
            'lowStockProducts',
            'recentProducts'
        ));
    }
}
