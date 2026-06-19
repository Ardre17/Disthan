<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [

        'numero_orden',

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
}