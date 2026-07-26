<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PalletDetail extends Model
{
    public function pallet()
{
    return $this->belongsTo(Pallet::class);
}

public function product()
{
    return $this->belongsTo(Product::class);
}

public function orderDetail()
{
    return $this->belongsTo(OrderDetail::class);
}
}
