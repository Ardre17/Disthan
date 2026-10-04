<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplyDispatch extends Model
{
    protected $fillable = [
        'numero_salida',
        'supply_order_id',
        'fecha_salida',
        'user_id',
        'observaciones',
    ];

    protected $casts = [
        'fecha_salida' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(
            SupplyOrder::class,
            'supply_order_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(
            SupplyDispatchItem::class
        );
    }
}