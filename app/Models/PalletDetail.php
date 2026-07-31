<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PalletDetail extends Model
{
    protected $fillable = [
        'pallet_id',
        'order_detail_id',
        'product_id',
        'cantidad',
        'peso',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function pallet()
    {
        return $this->belongsTo(Pallet::class);
    }

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class);
    }
}