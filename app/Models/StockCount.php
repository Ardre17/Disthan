<?php
// app/Models/StockCount.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockCount extends Model
{
    protected $fillable = ['codigo', 'fecha', 'realizado_por', 'estado', 'observaciones'];

    public function detalles()
    {
        return $this->hasMany(StockCountDetail::class);
    }
}