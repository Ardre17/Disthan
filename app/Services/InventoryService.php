<?php

namespace App\Services;

use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\InventoryMovement;

class InventoryService
{
    /**
     * Registrar movimiento en el Kardex
     */
    private static function registrarMovimiento(array $datos)
    {
        return InventoryMovement::create($datos);
    }

    /**
     * Entrada de producto terminado
     */
    public static function entradaProducto(
        Product $producto,
        float $cantidad,
        string $documento,
        string $modulo,
        ?int $clienteId = null,
        ?int $usuarioId = null,
        ?string $observacion = null,
        ?int $referenceId = null
    ) {

        $stockAnterior = $producto->stock;

        $producto->stock += $cantidad;
        $producto->save();

        self::registrarMovimiento([

            'product_id'      => $producto->id,
            'client_id'       => $clienteId,
            'user_id'         => $usuarioId,
            'movement_type'   => 'PRODUCCION',
            'entry'           => $cantidad,
            'exit'            => 0,
            'stock_before'    => $stockAnterior,
            'stock_after'     => $producto->stock,
            'document_number' => $documento,
            'observation'     => $observacion

        ]);
    }

    /**
     * Salida de materia prima
     */
    public static function salidaMateriaPrima(
        RawMaterial $material,
        float $cantidad,
        string $documento,
        string $modulo,
        ?int $usuarioId = null,
        ?string $observacion = null,
        ?int $referenceId = null
    ) {

        $stockAnterior = $material->stock;

        $material->stock -= $cantidad;

        if ($material->stock <= 0) {

            $material->status = 'AGOTADO';

        } elseif ($material->stock <= $material->minimum_stock) {

            $material->status = 'STOCK_BAJO';

        } else {

            $material->status = 'DISPONIBLE';

        }

        $material->save();

        self::registrarMovimiento([

            'raw_material_id' => $material->id,
            'user_id'         => $usuarioId,
            'movement_type'   => 'PRODUCCION',
            'entry'           => 0,
            'exit'            => $cantidad,
            'stock_before'    => $stockAnterior,
            'stock_after'     => $material->stock,
            'document_number' => $documento,
            'observation'     => $observacion

        ]);
    }

    /**
     * Salida de producto
     */
    public static function salidaProducto(
        Product $producto,
        float $cantidad,
        string $documento,
        string $modulo,
        ?int $clienteId = null,
        ?int $usuarioId = null,
        ?string $observacion = null,
        ?int $referenceId = null
    ) {

        $stockAnterior = $producto->stock;

        $producto->stock -= $cantidad;

        if ($producto->stock < 0) {
            $producto->stock = 0;
        }

        $producto->save();

        self::registrarMovimiento([

            'product_id'      => $producto->id,
            'client_id'       => $clienteId,
            'user_id'         => $usuarioId,
            'movement_type'   => 'VENTA',
            'entry'           => 0,
            'exit'            => $cantidad,
            'stock_before'    => $stockAnterior,
            'stock_after'     => $producto->stock,
            'document_number' => $documento,
            'observation'     => $observacion

        ]);
    }

    /**
     * Entrada de materia prima
     */
    public static function entradaMateriaPrima(
        RawMaterial $material,
        float $cantidad,
        string $documento,
        string $modulo,
        ?int $usuarioId = null,
        ?string $observacion = null,
        ?int $referenceId = null
    ) {

        $stockAnterior = $material->stock;

        $material->stock += $cantidad;

        $material->save();

        self::registrarMovimiento([

            'raw_material_id' => $material->id,
            'user_id'         => $usuarioId,
            'movement_type'   => 'COMPRA',
            'entry'           => $cantidad,
            'exit'            => 0,
            'stock_before'    => $stockAnterior,
            'stock_after'     => $material->stock,
            'document_number' => $documento,
            'observation'     => $observacion

        ]);
    }
}