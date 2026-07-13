<?php
// app/Models/StockCountDetail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockCountDetail extends Model
{
    protected $fillable = ['stock_count_id', 'product_id', 'stock_sistema', 'stock_fisico', 'diferencia'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stockCount()
    {
        return $this->belongsTo(StockCount::class);
    }
}