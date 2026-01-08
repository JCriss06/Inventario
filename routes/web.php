<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('products', ProductController::class)->except(['show','create','edit'])->names('products');

    //Rutas para inventario
    Route::get('/inventario', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventario/movements', [InventoryController::class, 'store'])->name('inventory.store');
    //rutas para reportes
    Route::get('/reportes', [ReportController::class, 'index'])->name('reportes.index');

});

require __DIR__.'/auth.php';
