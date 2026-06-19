<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    // 🔥 AQUÍ VA (FUERA DE FUNCIONES)
    protected $fillable = [
        'product_id',
        'pais',
        'zona',
        'stock'
    ];

    // 🔥 RELACIÓN
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}