<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = [
        'product_id',
        'pais',
        'tipo',
        'cantidad',
        'motivo'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function inventory()
{
    return $this->belongsTo(\App\Models\Inventory::class, 'inventory_id');
}
}

