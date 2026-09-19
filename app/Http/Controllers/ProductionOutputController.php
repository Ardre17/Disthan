<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Movement;
use App\Models\Sticker;
use App\Models\StickerMovement;
use App\Models\Precinto;
use App\Models\PrecintoMovement;
use App\Models\Caja;
use App\Models\CajaMovement;
use App\Models\Label;
use App\Models\LabelMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionOutputController extends Controller
{

/**
 * Mostrar stickers disponibles para producción.
 */
public function stickers()
{
    $stickers = Sticker::where('activo', true)
        ->orderBy('nombre')
        ->get();

    return view(
        'production_outputs.stickers',
        compact('stickers')
    );
}

/**
 * Registrar salida de un sticker.
 */
public function salidaSticker(Request $request, Sticker $sticker)
{
    $request->validate([
        'cantidad' => 'required|integer|min:1',
        'responsable' => 'required|string|max:100',
        'observacion' => 'nullable|string|max:255',
    ], [
        'cantidad.required' => 'Ingresa la cantidad.',
        'cantidad.integer' => 'La cantidad debe ser un número entero.',
        'cantidad.min' => 'La cantidad debe ser como mínimo 1.',
        'responsable.required' => 'Ingresa el nombre del responsable.',
    ]);

    $cantidad = (int) $request->cantidad;

    DB::transaction(function () use (
        $sticker,
        $cantidad,
        $request
    ) {
        $sticker = Sticker::where('id', $sticker->id)
            ->lockForUpdate()
            ->firstOrFail();

        if (!$sticker->activo) {
            abort(404);
        }

        if ($cantidad > $sticker->stock_actual) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'cantidad' =>
                    'Stock insuficiente. Disponible: ' .
                    number_format($sticker->stock_actual, 0)
            ]);
        }

        $nuevoSaldo = $sticker->stock_actual - $cantidad;

        $referencia =
            'Salida producción - Responsable: ' .
            $request->responsable;

        if ($request->filled('observacion')) {
            $referencia .= ' - ' . $request->observacion;
        }

        StickerMovement::create([
            'sticker_id' => $sticker->id,
            'tipo' => 'SALIDA',
            'cantidad' => $cantidad,
            'motivo' => 'Producción',
            'referencia' => $referencia,
            'saldo_post' => $nuevoSaldo,
        ]);

        $sticker->stock_actual = $nuevoSaldo;
        $sticker->save();
    });

    return redirect()
        ->route('production.outputs.stickers')
        ->with(
            'success',
            'Salida de stickers registrada correctamente.'
        );
}
    /**
 * Mostrar precintos disponibles para producción.
 */
public function precintos()
{
    $precintos = Precinto::where('activo', true)
        ->orderBy('nombre')
        ->get();

    return view(
        'production_outputs.precintos',
        compact('precintos')
    );
}

/**
 * Registrar salida de un precinto.
 */
public function salidaPrecinto(Request $request, Precinto $precinto)
{
    $request->validate([
        'cantidad' => 'required|integer|min:1',
        'responsable' => 'required|string|max:100',
        'observacion' => 'nullable|string|max:255',
    ], [
        'cantidad.required' => 'Ingresa la cantidad.',
        'cantidad.integer' => 'La cantidad debe ser un número entero.',
        'cantidad.min' => 'La cantidad debe ser como mínimo 1.',
        'responsable.required' => 'Ingresa el nombre del responsable.',
    ]);

    $cantidad = (int) $request->cantidad;

    DB::transaction(function () use (
        $precinto,
        $cantidad,
        $request
    ) {
        $precinto = Precinto::where('id', $precinto->id)
            ->lockForUpdate()
            ->firstOrFail();

        if (!$precinto->activo) {
            abort(404);
        }

        if ($cantidad > $precinto->stock_actual) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'cantidad' =>
                    'Stock insuficiente. Disponible: ' .
                    number_format($precinto->stock_actual, 0)
            ]);
        }

        $nuevoSaldo = $precinto->stock_actual - $cantidad;

        $referencia =
            'Salida producción - Responsable: ' .
            $request->responsable;

        if ($request->filled('observacion')) {
            $referencia .= ' - ' . $request->observacion;
        }

        PrecintoMovement::create([
            'precinto_id' => $precinto->id,
            'tipo' => 'SALIDA',
            'cantidad' => $cantidad,
            'motivo' => 'Producción',
            'referencia' => $referencia,
            'saldo_post' => $nuevoSaldo,
        ]);

        $precinto->stock_actual = $nuevoSaldo;
        $precinto->save();
    });

    return redirect()
        ->route('production.outputs.precintos')
        ->with(
            'success',
            'Salida de precintos registrada correctamente.'
        );
}
    /**
     * Pantalla principal de salidas de producción.
     */
    public function index()
    {
        return view('production_outputs.index');
    }

    /**
     * Mostrar cajas disponibles para producción.
     */
    public function cajas()
    {
        $cajas = Caja::where('activo', true)
            ->orderBy('tipo')
            ->orderBy('nombre')
            ->get();

        return view('production_outputs.cajas', compact('cajas'));
    }

    /**
     * Registrar salida de una caja.
     */
    public function salidaCaja(Request $request, Caja $caja)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
            'responsable' => 'required|string|max:100',
            'observacion' => 'nullable|string|max:255',
        ], [
            'cantidad.required' => 'Ingresa la cantidad.',
            'cantidad.numeric' => 'La cantidad debe ser numérica.',
            'cantidad.min' => 'La cantidad debe ser mayor a 0.',
            'responsable.required' => 'Ingresa el nombre del responsable.',
        ]);

        $cantidad = (int) $request->cantidad;

        DB::transaction(function () use (
            $caja,
            $cantidad,
            $request
        ) {
            // Bloqueamos el registro para evitar
            // dos salidas simultáneas sobre el mismo stock.
            $caja = Caja::where('id', $caja->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (!$caja->activo) {
                abort(404);
            }

            if ($cantidad > $caja->stock_actual) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'cantidad' => 'Stock insuficiente. Disponible: ' . $caja->stock_actual
                ]);
            }

            $nuevoSaldo = $caja->stock_actual - $cantidad;

            $referencia = 'Salida producción - Responsable: '
                . $request->responsable;

            if ($request->filled('observacion')) {
                $referencia .= ' - ' . $request->observacion;
            }

            CajaMovement::create([
                'caja_id'    => $caja->id,
                'tipo'       => 'SALIDA',
                'cantidad'   => $cantidad,
                'motivo'     => 'Producción',
                'referencia' => $referencia,
                'saldo_post' => $nuevoSaldo,
            ]);

            $caja->stock_actual = $nuevoSaldo;
            $caja->save();
        });

        return redirect()
            ->route('production.outputs.cajas')
            ->with(
                'success',
                'Salida registrada correctamente.'
            );
    }
    /**
 * Mostrar etiquetas disponibles para producción.
 */
public function etiquetas()
{
    $etiquetas = Label::where('activo', true)
        ->orderBy('nombre')
        ->get();

    return view(
        'production_outputs.etiquetas',
        compact('etiquetas')
    );
}

/**
 * Registrar salida de una etiqueta.
 */
public function salidaEtiqueta(Request $request, Label $label)
{
    $request->validate([
        'cantidad' => 'required|integer|min:1',
        'responsable' => 'required|string|max:100',
        'observacion' => 'nullable|string|max:255',
    ], [
        'cantidad.required' => 'Ingresa la cantidad.',
        'cantidad.integer' => 'La cantidad debe ser un número entero.',
        'cantidad.min' => 'La cantidad debe ser como mínimo 1.',
        'responsable.required' => 'Ingresa el nombre del responsable.',
    ]);

    $cantidad = (int) $request->cantidad;

    DB::transaction(function () use (
        $label,
        $cantidad,
        $request
    ) {
        $label = Label::where('id', $label->id)
            ->lockForUpdate()
            ->firstOrFail();

        if (!$label->activo) {
            abort(404);
        }

        if ($cantidad > $label->stock_actual) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'cantidad' =>
                    'Stock insuficiente. Disponible: '
                    . number_format($label->stock_actual, 0)
            ]);
        }

        $nuevoSaldo = $label->stock_actual - $cantidad;

        $referencia = 'Salida producción - Responsable: '
            . $request->responsable;

        if ($request->filled('observacion')) {
            $referencia .= ' - ' . $request->observacion;
        }

        LabelMovement::create([
            'label_id' => $label->id,
            'tipo' => 'SALIDA',
            'cantidad' => $cantidad,
            'motivo' => 'Producción',
            'referencia' => $referencia,
            'saldo_post' => $nuevoSaldo,
        ]);

        $label->stock_actual = $nuevoSaldo;
        $label->save();
    });

    return redirect()
        ->route('production.outputs.etiquetas')
        ->with(
            'success',
            'Salida de etiquetas registrada correctamente.'
        );
}
/**
 * Mostrar productos disponibles para producción.
 */
public function productos(Request $request)
{
    $busqueda = trim($request->input('buscar', ''));

    $productos = Product::where('activo', true)
        ->when($busqueda !== '', function ($query) use ($busqueda) {
            $query->where(function ($q) use ($busqueda) {
                $q->where('nombre', 'like', '%' . $busqueda . '%')
                    ->orWhere('sku', 'like', '%' . $busqueda . '%')
                    ->orWhere('barcode', 'like', '%' . $busqueda . '%')
                    ->orWhere('box_barcode', 'like', '%' . $busqueda . '%')
                    ->orWhere('lote', 'like', '%' . $busqueda . '%');
            });
        })
        ->orderBy('nombre')
        ->get();

    return view(
        'production_outputs.productos',
        compact('productos', 'busqueda')
    );
}

/**
 * Registrar salida de un producto para producción.
 */
public function salidaProducto(Request $request, Product $product)
{
    $request->validate([
        'cantidad' => 'required|integer|min:1',
        'responsable' => 'required|string|max:100',
        'observacion' => 'nullable|string|max:255',
    ], [
        'cantidad.required' => 'Ingresa la cantidad.',
        'cantidad.integer' => 'La cantidad debe ser un número entero.',
        'cantidad.min' => 'La cantidad debe ser como mínimo 1.',
        'responsable.required' => 'Ingresa el nombre del responsable.',
    ]);

    $cantidad = (int) $request->cantidad;

    DB::transaction(function () use (
        $product,
        $cantidad,
        $request
    ) {
        $product = Product::where('id', $product->id)
            ->lockForUpdate()
            ->firstOrFail();

        if (!$product->activo) {
            abort(404);
        }

        if ($cantidad > $product->stock) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'cantidad' =>
                    'Stock insuficiente. Disponible: ' .
                    number_format($product->stock, 0),
            ]);
        }

        $nuevoSaldo = $product->stock - $cantidad;

        /*
         * El modelo Movement no tiene columnas independientes
         * para responsable y observación.
         *
         * Por eso conservamos ambos datos dentro de "motivo",
         * sin modificar la estructura actual del inventario.
         */
        $motivo = 'PRODUCCIÓN - Responsable: ' . $request->responsable;

        if ($request->filled('observacion')) {
            $motivo .= ' - ' . $request->observacion;
        }

        Movement::create([
            'product_id' => $product->id,
            'tipo' => 'SALIDA',
            'cantidad' => $cantidad,
            'motivo' => $motivo,
        ]);

        $product->stock = $nuevoSaldo;
        $product->save();
    });

    return redirect()
        ->route('production.outputs.productos')
        ->with(
            'success',
            'Salida de producto registrada correctamente.'
        );
}
}