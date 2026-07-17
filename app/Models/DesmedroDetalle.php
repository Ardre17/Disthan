<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DesmedroDetalle extends Model
{
    protected $fillable = [
        'desmedro_id', 'producto_id', 'cantidad', 'stock_antes',
    ];

    public function desmedro(): BelongsTo
    {
        return $this->belongsTo(Desmedro::class);
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Product::class, 'producto_id');
    }
}