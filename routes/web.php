<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KitController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\UserController; // Corregido el namespace

Route::redirect('/', '/login');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    
    // Rutas de Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Gestión de Usuarios (La seguridad la pondremos en el controlador)
    Route::resource('users', UserController::class)->names('users');

   // Productos
Route::resource('products', ProductController::class)->names('products');
Route::get('/products/search/ajax', [ProductController::class, 'search'])
    ->name('products.search');

// Kits
Route::resource('kits', KitController::class)->names('kits');

// Inventario
Route::get('/inventario', [InventoryController::class, 'index'])
    ->name('inventory.index')
    ->middleware('can:gestionar inventario');

Route::post('/inventario/movements', [InventoryController::class, 'store'])
    ->name('inventory.store')
    ->middleware('can:gestionar inventario');

// Reportes
Route::get('/reportes', [ReportController::class, 'index'])
    ->name('reportes.index')
    ->middleware('can:ver reportes');

Route::get('/reportes/export/pdf', [ReportController::class, 'exportPdf'])
    ->name('reportes.export.pdf');

// Bitácoras
Route::get('/bitacoras', [BitacoraController::class, 'index'])
    ->name('bitacoras.index')
    ->middleware('can:ver bitacoras');

});

require __DIR__.'/auth.php';