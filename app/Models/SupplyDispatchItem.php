<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplyDispatchItem extends Model
{
    protected $fillable = [
        'supply_dispatch_id',
        'supply_order_item_id',
        'cantidad',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
    ];

    public function dispatch(): BelongsTo
    {
        return $this->belongsTo(
            SupplyDispatch::class,
            'supply_dispatch_id'
        );
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(
            SupplyOrderItem::class,
            'supply_order_item_id'
        );
    }
}