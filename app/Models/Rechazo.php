<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rechazo extends Model
{
    protected $fillable = [
        'order_id',
        'order_detail_id',
        'cantidad_rechazada',
        'motivo',
        'observaciones',
        'fecha_rechazo',
    ];

    protected $casts = [
        'fecha_rechazo' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function detail()
    {
        return $this->belongsTo(OrderDetail::class, 'order_detail_id');
    }
}