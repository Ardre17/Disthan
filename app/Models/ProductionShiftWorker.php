<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionShiftWorker extends Model
{
    protected $fillable = ['production_order_shift_id', 'name'];

    public function shift()
    {
        return $this->belongsTo(ProductionOrderShift::class, 'production_order_shift_id');
    }
}
