<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplyOrderItem extends Model
{
    protected $fillable = [
        'supply_order_id',
        'tipo_material',
        'material_id',
        'cantidad_solicitada',
    ];

    protected $casts = [
        'cantidad_solicitada' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(
            SupplyOrder::class,
            'supply_order_id'
        );
    }

    public function dispatchItems(): HasMany
    {
        return $this->hasMany(
            SupplyDispatchItem::class
        );
    }

    /**
     * Cantidad total entregada.
     */
    public function getCantidadEntregadaAttribute(): float
    {
        return (float) $this->dispatchItems()->sum('cantidad');
    }

    /**
     * Cantidad que todavía falta entregar.
     */
    public function getCantidadPendienteAttribute(): float
    {
        return max(
            0,
            (float) $this->cantidad_solicitada
            - $this->cantidad_entregada
        );
    }

    /**
     * Porcentaje entregado.
     */
    public function getPorcentajeEntregadoAttribute(): float
    {
        if ((float) $this->cantidad_solicitada <= 0) {
            return 0;
        }

        return round(
            ($this->cantidad_entregada / $this->cantidad_solicitada) * 100,
            2
        );
    }
}