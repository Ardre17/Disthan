<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PalletType;

class PalletPlannerService
{
    public function generar(Order $order, PalletType $pallet)
{
    $productos = [];
    $pallets = [];

    $numeroPallet = 1;

    $sobrantes = [];

   foreach ($order->details as $detail) {

    $producto = $detail->product;

    if (!$producto) {
        continue;
    }

    $logistica = $producto->logistic;

    $cantidadSolicitada = $detail->cantidad_solicitada;

    $stockDisponible = $producto->stock;

    $cantidadPreparar = min(
        $cantidadSolicitada,
        $stockDisponible
    );

    $cantidadPendiente =
        max(
            0,
            $cantidadSolicitada - $stockDisponible
        );
        $maxPorPallet = max(
    1,
    $logistica?->max_cajas_pallet ?? 1
);

$palletsCompletos = intdiv(
    $cantidadPreparar,
    $maxPorPallet
);

$saldo = $cantidadPreparar % $maxPorPallet;

    $productos[] = [

    'producto_id' => $producto->id,

    'nombre' => $producto->nombre,

    'cantidad_solicitada' => $cantidadSolicitada,

    'stock' => $stockDisponible,

    'cantidad_preparar' => $cantidadPreparar,

    'cantidad_pendiente' => $cantidadPendiente,

    'max_cajas_pallet' => $maxPorPallet,

    'pallets_completos' => $palletsCompletos,

    'saldo' => $saldo,

    'logistica' => $logistica

];
for ($i = 0; $i < $palletsCompletos; $i++) {

    $pallets[] = [

        'numero' => $numeroPallet++,

        'productos' => [

            [

                'producto_id' => $producto->id,

                'nombre' => $producto->nombre,

                'cantidad' => $maxPorPallet

            ]

        ],

        'completo' => true

    ];

}

if ($saldo > 0) {

    $sobrantes[] = [

        'producto_id' => $producto->id,

        'nombre' => $producto->nombre,

        'cantidad' => $saldo,

        'logistica' => $logistica

    ];

}
}
$totalPallets = array_sum(
    array_column(
        $productos,
        'pallets_completos'
    )
);

    return [

    'pedido' => $order->id,

    'pallet' => $pallet,

    'total_pallets' => count($pallets),

    'pallets' => $pallets,

    'sobrantes' => $sobrantes,

    'productos' => $productos

];
}
}