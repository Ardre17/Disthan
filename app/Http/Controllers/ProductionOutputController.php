<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\CajaMovement;
use App\Models\Label;
use App\Models\LabelMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionOutputController extends Controller
{
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
}