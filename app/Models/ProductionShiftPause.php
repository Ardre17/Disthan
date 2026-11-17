<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionShiftPause extends Model
{
    protected $fillable = [
        'production_order_shift_id', 'paused_at', 'resumed_at', 'reason',
    ];

    protected $casts = [
        'paused_at' => 'datetime',
        'resumed_at' => 'datetime',
    ];

    public function shift()
    {
        return $this->belongsTo(ProductionOrderShift::class, 'production_order_shift_id');
    }
}
