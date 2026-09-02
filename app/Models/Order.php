<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [

        'numero_orden',

        'factura_asociada',

        'guia_asociada',

        'order_interna',

        'client_id',

        'tipo_orden',

        'fecha_pedido',

        'fecha_entrega',

        'estado',

        'observaciones',

        'subtotal',

        'igv',

        'total'
    ];


    public function client()
    {
        return $this->belongsTo(Client::class);
    }


    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }


    public function bultos()
    {
        return $this->hasMany(\App\Models\Bulto::class);
    }


    public function pallets()
    {
        return $this->hasMany(Pallet::class);
    }
    public function validations()
{
    return $this->hasMany(
        OrderValidation::class,
        'order_id'
    );
}
}