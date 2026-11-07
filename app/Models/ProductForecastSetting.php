<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductForecastSetting extends Model
{
    protected $fillable = [
        'product_id', 'lead_time_days', 'safety_days',
        'coverage_days', 'approved_min_stock', 'updated_by',
    ];

    protected $casts = [
        'lead_time_days' => 'integer',
        'safety_days' => 'integer',
        'coverage_days' => 'integer',
        'approved_min_stock' => 'decimal:3',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
