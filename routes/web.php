<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| RUTA TEMPORAL MIGRACIÓN
|--------------------------------------------------------------------------
*/
Route::get('/init-db', function () {

    \Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
        '--force' => true
    ]);

    return "Base de datos creada correctamente";
});

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Auth::check() 
        ? redirect('/dashboard') 
        : redirect('/login');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::resource('products', ProductController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', OrderController::class);

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | ÓRDENES
    |--------------------------------------------------------------------------
    */
    Route::post('/orders/{order}/add-product', [OrderController::class, 'addProduct'])->name('orders.addProduct');
    Route::put('/order-details/{detail}', [OrderController::class, 'updateDetail'])->name('orders.updateDetail');
    Route::delete('/order-details/{detail}', [OrderController::class, 'destroyDetail'])->name('orders.details.destroy');

    Route::post('/orders/{order}/import', [OrderController::class,'importCsv'])->name('orders.import');
    Route::get('/orders/{order}/pdf', [OrderController::class,'pdf'])->name('orders.pdf');

    Route::get('/orders/{order}/operario', [OrderController::class, 'operario'])->name('orders.operario');
    Route::post('/orders/{order}/cerrar', [OrderController::class, 'cerrar'])->name('orders.cerrar');

    Route::get('/pedidos', [OrderController::class, 'pedidos'])->name('pedidos.index');
    Route::get('/historial', [OrderController::class, 'historial'])->name('orders.historial');

    /*
    |--------------------------------------------------------------------------
    | BULTOS
    |--------------------------------------------------------------------------
    */
    Route::post('/orders/{order}/bultos', [OrderController::class, 'crearBulto'])->name('bultos.crear');
    Route::post('/bultos/{bulto}/agregar', [OrderController::class, 'agregarABulto'])->name('bultos.agregar');
    Route::delete('/bulto-detalle/{detalle}', [OrderController::class, 'eliminarDeBulto'])->name('bultos.eliminar');

    /*
    |--------------------------------------------------------------------------
    | INVENTARIO
    |--------------------------------------------------------------------------
    */
    Route::get('/inventario', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventario/{id}', [InventoryController::class, 'show']);
    Route::post('/inventario/add/{id}', [InventoryController::class, 'add'])->name('inventory.add');
    Route::post('/inventario/store', [InventoryController::class, 'store'])->name('inventory.store');

    /*
    |--------------------------------------------------------------------------
    | API PRODUCTO
    |--------------------------------------------------------------------------
    */
    Route::get('/api/producto/{codigo}', function ($codigo) {
        return \App\Models\Product::where('barcode', $codigo)
            ->orWhere('sku', $codigo)
            ->first();
    });

    /*
    |--------------------------------------------------------------------------
    | OPERARIO
    |--------------------------------------------------------------------------
    */
    Route::get('/operario', function () {
        return view('operario.index');
    })->name('operario');

    /*
    |--------------------------------------------------------------------------
    | USUARIOS
    |--------------------------------------------------------------------------
    */
    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
    Route::get('/usuarios/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('users.destroy');

});

require __DIR__.'/auth.php';
