<?php

namespace App\Services;

use App\Models\Caja;
use App\Models\CajaMovement;
use App\Models\Label;
use App\Models\LabelMovement;
use App\Models\Precinto;
use App\Models\PrecintoMovement;
use App\Models\Sticker;
use App\Models\StickerMovement;
use App\Models\SupplyDispatch;
use App\Models\SupplyOrder;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class SupplyDispatchService
{
    public function registrar(
        SupplyOrder $orden,
        array $cantidades,
        ?string $observaciones = null
    ): SupplyDispatch {

        return DB::transaction(function () use (
            $orden,
            $cantidades,
            $observaciones
        ) {

            /*
            |--------------------------------------------------------------------------
            | Bloquear la orden
            |--------------------------------------------------------------------------
            */

            $orden = SupplyOrder::where('id', $orden->id)
                ->lockForUpdate()
                ->firstOrFail();


            /*
            |--------------------------------------------------------------------------
            | Verificar que la orden no esté completada
            |--------------------------------------------------------------------------
            */

            if ($orden->estado === 'COMPLETADA') {

                throw ValidationException::withMessages([
                    'salida' =>
                        'Esta orden ya está completamente entregada.'
                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | Crear salida temporal
            |--------------------------------------------------------------------------
            |
            | Primero usamos un número temporal.
            | Después de crear el registro usamos su ID para generar:
            |
            | VS-000001
            |
            */

            $salida = SupplyDispatch::create([
                'numero_salida' => 'TEMP-' . uniqid(),
                'supply_order_id' => $orden->id,
                'fecha_salida' => now(),
                'user_id' => auth()->id(),
                'observaciones' => $observaciones,
            ]);


            $huboSalida = false;


            /*
            |--------------------------------------------------------------------------
            | Procesar cada material
            |--------------------------------------------------------------------------
            */

            foreach ($cantidades as $orderItemId => $cantidad) {

                $cantidad = (float) $cantidad;

                // Ignorar campos vacíos o cero
                if ($cantidad <= 0) {
                    continue;
                }

                $item = $orden->items()
                    ->where('id', $orderItemId)
                    ->lockForUpdate()
                    ->first();

                if (!$item) {

                    throw ValidationException::withMessages([
                        'cantidad' =>
                            'Uno de los materiales seleccionados no pertenece a esta orden.'
                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | Calcular cuánto ya fue entregado
                |--------------------------------------------------------------------------
                */

                $entregado = (float) $item->dispatchItems()->sum(
                    'cantidad'
                );

                $pendiente =
                    (float) $item->cantidad_solicitada
                    - $entregado;


                /*
                |--------------------------------------------------------------------------
                | No permitir enviar más de lo pendiente
                |--------------------------------------------------------------------------
                */

                if ($cantidad > $pendiente) {

                    throw ValidationException::withMessages([
                        "cantidad_{$item->id}" =>
                            "No puedes enviar {$cantidad}. "
                            . "El material {$item->tipo_material} "
                            . "solo tiene {$pendiente} pendiente."
                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | Descontar inventario correspondiente
                |--------------------------------------------------------------------------
                */

                $this->descontarInventario(
                    $item->tipo_material,
                    (int) $item->material_id,
                    $cantidad,
                    $salida->numero_salida
                );


                /*
                |--------------------------------------------------------------------------
                | Registrar detalle de la salida
                |--------------------------------------------------------------------------
                */

                $salida->items()->create([
                    'supply_order_item_id' => $item->id,
                    'cantidad' => $cantidad,
                ]);


                $huboSalida = true;
            }


            /*
            |--------------------------------------------------------------------------
            | Debe existir al menos una salida
            |--------------------------------------------------------------------------
            */

            if (!$huboSalida) {

                throw ValidationException::withMessages([
                    'salida' =>
                        'Debes ingresar al menos una cantidad para enviar.'
                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | Generar número definitivo
            |--------------------------------------------------------------------------
            */

            $numeroSalida = 'VS-' . str_pad(
                $salida->id,
                6,
                '0',
                STR_PAD_LEFT
            );

            $salida->update([
                'numero_salida' => $numeroSalida
            ]);


            /*
            |--------------------------------------------------------------------------
            | Actualizar estado de la orden
            |--------------------------------------------------------------------------
            */

            $this->actualizarEstado($orden);


            return $salida;
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Descontar inventario
    |--------------------------------------------------------------------------
    */

    private function descontarInventario(
        string $tipo,
        int $materialId,
        float $cantidad,
        string $referencia
    ): void {

        switch ($tipo) {

            /*
            |--------------------------------------------------------------------------
            | LABEL
            |--------------------------------------------------------------------------
            */

            case 'LABEL':

                $material = Label::where('id', $materialId)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (!$material->activo) {
                    throw ValidationException::withMessages([
                        'stock' => 'La etiqueta seleccionada está inactiva.'
                    ]);
                }

                if ($cantidad > $material->stock_actual) {
                    throw ValidationException::withMessages([
                        'stock' =>
                            'Stock insuficiente de la etiqueta '
                            . $material->nombre
                            . '. Disponible: '
                            . $material->stock_actual
                    ]);
                }

                $nuevoSaldo =
                    $material->stock_actual - $cantidad;

                LabelMovement::create([
                    'label_id' => $material->id,
                    'tipo' => 'SALIDA',
                    'cantidad' => $cantidad,
                    'motivo' => 'Abastecimiento a planta',
                    'referencia' => $referencia,
                    'saldo_post' => $nuevoSaldo,
                ]);

                $material->stock_actual = $nuevoSaldo;
                $material->save();

                break;


            /*
            |--------------------------------------------------------------------------
            | STICKER
            |--------------------------------------------------------------------------
            */

            case 'STICKER':

                $material = Sticker::where('id', $materialId)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (!$material->activo) {
                    throw ValidationException::withMessages([
                        'stock' => 'El sticker seleccionado está inactivo.'
                    ]);
                }

                if ($cantidad > $material->stock_actual) {
                    throw ValidationException::withMessages([
                        'stock' =>
                            'Stock insuficiente del sticker '
                            . $material->nombre
                            . '. Disponible: '
                            . $material->stock_actual
                    ]);
                }

                $nuevoSaldo =
                    $material->stock_actual - $cantidad;

                StickerMovement::create([
                    'sticker_id' => $material->id,
                    'tipo' => 'SALIDA',
                    'cantidad' => $cantidad,
                    'motivo' => 'Abastecimiento a planta',
                    'referencia' => $referencia,
                    'saldo_post' => $nuevoSaldo,
                ]);

                $material->stock_actual = $nuevoSaldo;
                $material->save();

                break;


            /*
            |--------------------------------------------------------------------------
            | PRECINTO
            |--------------------------------------------------------------------------
            */

            case 'PRECINTO':

                $material = Precinto::where('id', $materialId)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (!$material->activo) {
                    throw ValidationException::withMessages([
                        'stock' => 'El precinto seleccionado está inactivo.'
                    ]);
                }

                if ($cantidad > $material->stock_actual) {
                    throw ValidationException::withMessages([
                        'stock' =>
                            'Stock insuficiente del precinto '
                            . $material->nombre
                            . '. Disponible: '
                            . $material->stock_actual
                    ]);
                }

                $nuevoSaldo =
                    $material->stock_actual - $cantidad;

                PrecintoMovement::create([
                    'precinto_id' => $material->id,
                    'tipo' => 'SALIDA',
                    'cantidad' => $cantidad,
                    'motivo' => 'Abastecimiento a planta',
                    'referencia' => $referencia,
                    'saldo_post' => $nuevoSaldo,
                ]);

                $material->stock_actual = $nuevoSaldo;
                $material->save();

                break;


            /*
            |--------------------------------------------------------------------------
            | CAJA
            |--------------------------------------------------------------------------
            */

            case 'CAJA':

                $material = Caja::where('id', $materialId)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (!$material->activo) {
                    throw ValidationException::withMessages([
                        'stock' => 'La caja seleccionada está inactiva.'
                    ]);
                }

                if ($cantidad > $material->stock_actual) {
                    throw ValidationException::withMessages([
                        'stock' =>
                            'Stock insuficiente de la caja '
                            . $material->nombre
                            . '. Disponible: '
                            . $material->stock_actual
                    ]);
                }

                $nuevoSaldo =
                    $material->stock_actual - $cantidad;

                CajaMovement::create([
                    'caja_id' => $material->id,
                    'tipo' => 'SALIDA',
                    'cantidad' => $cantidad,
                    'motivo' => 'Abastecimiento a planta',
                    'referencia' => $referencia,
                    'saldo_post' => $nuevoSaldo,
                ]);

                $material->stock_actual = $nuevoSaldo;
                $material->save();

                break;


            default:

                throw ValidationException::withMessages([
                    'material' =>
                        'Tipo de material no válido: ' . $tipo
                ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Actualizar estado
    |--------------------------------------------------------------------------
    */

    private function actualizarEstado(
        SupplyOrder $orden
    ): void {

        $orden->load('items');

        $todosCompletos = true;
        $algunoEntregado = false;


        foreach ($orden->items as $item) {

            $entregado =
                (float) $item->dispatchItems()->sum(
                    'cantidad'
                );

            $solicitado =
                (float) $item->cantidad_solicitada;


            if ($entregado > 0) {
                $algunoEntregado = true;
            }


            if ($entregado < $solicitado) {
                $todosCompletos = false;
            }

        }


        if ($todosCompletos) {

            $orden->estado = 'COMPLETADA';

        } elseif ($algunoEntregado) {

            $orden->estado = 'PARCIAL';

        } else {

            $orden->estado = 'PENDIENTE';

        }


        $orden->save();
    }
}