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

        'consumed_quantity',

        'observation',

        'user_id',

        'status'

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
    public function getStatusColorAttribute()
{
    return match($this->status){

        'BORRADOR'=>'secondary',

        'EN_PRODUCCION'=>'warning',

        'FINALIZADA'=>'success',

        default=>'danger'

    };
}
}