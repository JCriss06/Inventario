<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KitController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BitacoraController;

Route::redirect('/', '/login');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rutas para productos
    Route::resource('products', ProductController::class)->names('products');
    
    // Rutas para kits
    Route::resource('kits', KitController::class)->names('kits');

    //Rutas para inventario
    Route::get('/inventario', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventario/movements', [InventoryController::class, 'store'])->name('inventory.store');
    
    //rutas para reportes
    Route::get('/reportes', [ReportController::class, 'index'])->name('reportes.index');
    
    //rutas para bitácoras
    Route::get('/bitacoras', [BitacoraController::class, 'index'])->name('bitacoras.index');

});

require __DIR__.'/auth.php';
