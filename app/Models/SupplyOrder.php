<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplyOrder extends Model
{
    protected $fillable = [
        'numero_orden',
        'planta',
        'product_id',
        'cantidad_produccion',
        'lote',
        'fecha_solicitud',
        'fecha_requerida',
        'estado',
        'observaciones',
        'user_id',
    ];

    protected $casts = [
        'fecha_solicitud' => 'date',
        'fecha_requerida' => 'date',
        'cantidad_produccion' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SupplyOrderItem::class);
    }

    public function dispatches(): HasMany
    {
        return $this->hasMany(SupplyDispatch::class);
    }
}