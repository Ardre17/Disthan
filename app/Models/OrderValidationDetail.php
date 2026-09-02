<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderValidationDetail extends Model
{
    protected $fillable = [
        'order_validation_id',
        'order_detail_id',
        'estado',
        'cantidad_solicitada',
        'cantidad_validada',
        'codigo_escaneado',
        'observaciones',
    ];

    protected $casts = [
        'cantidad_solicitada' => 'decimal:2',
        'cantidad_validada' => 'decimal:2',
    ];

    public function validation()
    {
        return $this->belongsTo(
            OrderValidation::class,
            'order_validation_id'
        );
    }

    public function orderDetail()
    {
        return $this->belongsTo(
            OrderDetail::class,
            'order_detail_id'
        );
    }

    public function product()
    {
        return $this->hasOneThrough(
            Product::class,
            OrderDetail::class,
            'id',
            'id',
            'order_detail_id',
            'product_id'
        );
    }
}