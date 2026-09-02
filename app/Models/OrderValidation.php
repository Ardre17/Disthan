<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderValidation extends Model
{
    protected $fillable = [
        'order_id',
        'usuario_id',
        'estado',
        'observaciones',
        'fecha_validacion',
    ];

    protected $casts = [
        'fecha_validacion' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function details()
    {
        return $this->hasMany(
            OrderValidationDetail::class,
            'order_validation_id'
        );
    }
}