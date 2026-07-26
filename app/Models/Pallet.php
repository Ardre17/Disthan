<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pallet extends Model
{
    protected $fillable = [

        'order_id',

        'codigo',

        'orden',

        'estado',

        'peso_neto',

        'peso_bruto',

        'altura',

        'ancho',

        'largo',

        'observaciones',

        'cerrado',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function detalles()
    {
        return $this->hasMany(PalletDetail::class);
    }
}