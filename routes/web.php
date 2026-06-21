<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\InventoryController;

    Route::resource('products', ProductController::class)
    ->middleware('auth');

    use Illuminate\Support\Facades\Auth;

        Route::get('/', function () {
            return Auth::check() 
                ? redirect('/dashboard') 
                : redirect('/login');
        });

    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::middleware('auth')->group(function () {

    Route::resource('clients', ClientController::class);

    Route::resource('categories', CategoryController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::resource('orders', OrderController::class)
    ->middleware('auth');

    Route::post('/orders/{order}/add-product', [OrderController::class, 'addProduct'])
    ->name('orders.addProduct');

    Route::put('/order-details/{detail}', [OrderController::class, 'updateDetail'])
    ->name('orders.updateDetail');

    Route::post(
    '/orders/{order}/import',
    [OrderController::class,'importCsv']
    )->name('orders.import');

    Route::get(
    '/orders/{order}/pdf',
    [OrderController::class,'pdf']
    )->name('orders.pdf');

    Route::delete('/order-details/{detail}', [OrderController::class, 'destroyDetail'])
    ->name('orders.details.destroy');

    Route::get('/api/producto/{codigo}', function ($codigo) {
    return \App\Models\Product::where('barcode', $codigo)
        ->orWhere('sku', $codigo)
        ->first();
    });
    Route::get('/pedidos', [OrderController::class, 'pedidos'])
    ->name('pedidos.index');

    Route::get('/orders/{order}/operario', [OrderController::class, 'operario'])
    ->name('orders.operario');

    Route::post('/orders/{order}/cerrar', [OrderController::class, 'cerrar'])
    ->name('orders.cerrar');

    Route::get('/historial', [OrderController::class, 'historial'])
    ->name('orders.historial');

    Route::post('/orders/{order}/bultos', [OrderController::class, 'crearBulto'])
    ->name('bultos.crear');

    Route::post('/bultos/{bulto}/agregar', [OrderController::class, 'agregarABulto'])
    ->name('bultos.agregar');

    Route::delete('/bulto-detalle/{detalle}', [OrderController::class, 'eliminarDeBulto'])
    ->name('bultos.eliminar');

    Route::get('/operario', function () {
    return view('operario.index');
    })->name('operario'); 

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/inventario', [InventoryController::class, 'index'])
    ->name('inventory.index');

    Route::get('/inventario/{id}', [InventoryController::class, 'show']);

    Route::post('/inventario/add/{id}', [InventoryController::class, 'add'])
    ->name('inventory.add');

    Route::post('/inventario/store', [InventoryController::class, 'store'])
    ->name('inventory.store');

});

require __DIR__.'/auth.php';