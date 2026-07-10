<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductEntry extends Model
{
    protected $fillable = [
        'product_id',
        'quantity',
        'stock_before',
        'stock_after',
        'supplier',
        'lote',
        'fecha_vencimiento',
        'observation',
        'user_id',
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}