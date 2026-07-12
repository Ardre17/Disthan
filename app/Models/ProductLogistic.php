<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLogistic extends Model
{
    protected $fillable = [
        'product_id',
        'largo_cm',
        'ancho_cm',
        'alto_cm',
        'peso_caja',
        'max_cajas_pallet',
        'max_niveles',
        'altura_maxima_pallet',
        'permite_mezcla',
        'orientacion',
        'activo'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}