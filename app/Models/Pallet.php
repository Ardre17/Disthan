<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pallet extends Model
{
    public function order()
{
    return $this->belongsTo(Order::class);
}

public function detalles()
{
    return $this->hasMany(PalletDetail::class);
}
}
