<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseLocation extends Model
{
    protected $fillable = [
        'code',
        'rack',
        'rack_name',
        'level',
        'row',
        'column',
        'status',
        'product_id',
        'stock',
        'capacity',
        'max_weight',
        'notes'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}