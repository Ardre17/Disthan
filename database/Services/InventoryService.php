<?php

namespace App\Services;

use App\Models\InventoryMovement;

class InventoryService
{
    public static function registrar(array $datos)
    {
        return InventoryMovement::create($datos);
    }
}