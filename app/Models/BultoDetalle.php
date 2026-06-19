<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BultoDetalle extends Model
{
    protected $fillable = ['bulto_id','product_id','cantidad'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function bulto()
    {
        return $this->belongsTo(Bulto::class);
    }
}
