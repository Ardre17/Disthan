<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionOrder extends Model
{
    protected $fillable = [
        'number',
        'product_id',
        'raw_material_id',
        'produced_quantity',
        'target_quantity',
        'consumed_quantity',
        'observation',
        'user_id',
        'status',
        'fecha_produccion',
        'standard_time_seconds',
        'planned_duration_seconds',
        'actual_duration_seconds',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'fecha_produccion' => 'datetime',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'target_quantity' => 'decimal:2',
        'produced_quantity' => 'decimal:2',
        'consumed_quantity' => 'decimal:2',
        'standard_time_seconds' => 'decimal:3',
        'planned_duration_seconds' => 'integer',
        'actual_duration_seconds' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shifts()
    {
        return $this->hasMany(ProductionOrderShift::class)->orderBy('shift_number');
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'BORRADOR' => 'secondary',
            'EN_PRODUCCION' => 'warning',
            'FINALIZADA' => 'success',
            default => 'danger',
        };
    }
}
