<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bulto extends Model
{
    protected $fillable = ['order_id','nombre','peso_total'];

    public function detalles()
    {
        return $this->hasMany(BultoDetalle::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
