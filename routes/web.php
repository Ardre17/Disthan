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
use App\Http\Controllers\WarehouseMapController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\ProductionOrderController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\RawMaterialEntryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\StickerController;
use App\Http\Controllers\PrecintoController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\OrderPreparationController;


Route::resource('cajas', CajaController::class);
Route::post('cajas/{caja}/movimiento', [CajaController::class, 'movimiento'])
     ->name('cajas.movimiento');


Route::resource('stickers', StickerController::class);
Route::post('stickers/{sticker}/movimiento', [StickerController::class, 'movimiento'])
     ->name('stickers.movimiento');

Route::resource('precintos', PrecintoController::class);
Route::post('precintos/{precinto}/movimiento', [PrecintoController::class, 'movimiento'])
     ->name('precintos.movimiento');

Route::prefix('warehouse')->name('warehouse.')->middleware('auth')->group(function () {
    Route::get('/',                       [WarehouseController::class, 'index'])->name('index');
    Route::post('/{location}/assign',     [WarehouseController::class, 'assign'])->name('assign');
    Route::delete('/{location}/clear',    [WarehouseController::class, 'clear'])->name('clear');
});

Route::get(
    '/raw-material-entries/create',
    [RawMaterialEntryController::class,'create']
)->name('raw-material-entries.create');

Route::post(
    '/raw-material-entries',
    [RawMaterialEntryController::class,'store']
)->name('raw-material-entries.store');

Route::resource('labels', LabelController::class);
Route::post('labels/{label}/movimiento', [LabelController::class, 'movimiento'])
     ->name('labels.movimiento');

Route::get('/kardex', [KardexController::class, 'index'])->name('kardex.index');

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

Route::resource('raw-materials', RawMaterialController::class);
Route::resource('production-orders', ProductionOrderController::class);

Route::post(
    'production-orders/{production_order}/finish',
    [ProductionOrderController::class,'finish']
)->name('production-orders.finish');
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

    Route::get('/products/proyectado', [ProductController::class, 'proyectado']) ->name('products.proyectado');
    Route::resource('products', ProductController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', OrderController::class);
    Route::get('/warehouse-map', [WarehouseMapController::class, 'index']) ->name('warehouse.map');
    Route::get('/warehouse-map/locations', [WarehouseMapController::class, 'locations'])
    ->name('warehouse.locations');



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

    Route::middleware(['auth'])->group(function () {

    Route::get('/usuarios', [UserController::class, 'index'])
        ->middleware('role:admin');

    });
    Route::get('/control-etiquetas', [InventoryController::class, 'controlEtiquetas']);
    Route::post('/control-etiquetas/store', [InventoryController::class, 'storeMovimiento']);
    Route::post('/inventario/salida/{id}', [InventoryController::class, 'salida']);
    Route::post('/inventario/add/{id}', [InventoryController::class, 'add']);

    Route::get('/control-stickers', [InventoryController::class, 'controlStickers']);
    Route::get('/control-precintos', [InventoryController::class, 'controlPrecintos']);

    /*
|--------------------------------------------------------------------------
| PREPARACIÓN DE PEDIDOS
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| PREPARACIÓN DE PEDIDOS
|--------------------------------------------------------------------------
*/

Route::prefix('preparation')
    ->name('preparation.')
    ->controller(OrderPreparationController::class)
    ->group(function () {

        // Bandeja
        Route::get('/', 'index')
            ->name('index');

        // Asistente de preparación
        Route::get('/{order}', 'show')
            ->name('show');

        // Acciones del asistente
        Route::post('/detail/{detail}/save', 'save')
            ->name('save');

        Route::post('/detail/{detail}/skip', 'skip')
            ->name('skip');

        Route::post('/detail/{detail}/not-found', 'notFound')
            ->name('notFound');

        // Finalizar preparación
        Route::post('/{order}/finish', 'finish')
            ->name('finish');

    });
});

require __DIR__.'/auth.php';
