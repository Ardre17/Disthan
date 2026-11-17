<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionOrderShift extends Model
{
    protected $fillable = [
        'production_order_id', 'shift_number', 'status', 'started_at',
        'ended_at', 'produced_quantity', 'actual_duration_seconds',
        'notes', 'started_by', 'closed_by',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'produced_quantity' => 'decimal:2',
        'actual_duration_seconds' => 'integer',
    ];

    public function productionOrder()
    {
        return $this->belongsTo(ProductionOrder::class);
    }

    public function workers()
    {
        return $this->hasMany(ProductionShiftWorker::class);
    }

    public function pauses()
    {
        return $this->hasMany(ProductionShiftPause::class);
    }

    public function openPause()
    {
        return $this->hasOne(ProductionShiftPause::class)->whereNull('resumed_at');
    }
}
