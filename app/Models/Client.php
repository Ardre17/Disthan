<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [

        'ruc',
        'razon_social',
        'nombre_comercial',

        'contacto',
        'telefono',
        'correo',

        'direccion',
        'distrito',
        'ciudad',

        'activo',
        'observaciones'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}