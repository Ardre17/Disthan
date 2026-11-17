<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionTimeStandard extends Model
{
    protected $fillable = [
        'product_id', 'seconds_per_unit', 'notes', 'active', 'created_by',
    ];

    protected $casts = [
        'seconds_per_unit' => 'decimal:3',
        'active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
