<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DalsaMovement extends Model
{
    protected $fillable = [
        'dalsa_item_id','tipo','cantidad',
        'motivo','destino','saldo_post'
    ];

    public function item()
    {
        return $this->belongsTo(DalsaItem::class, 'dalsa_item_id');
    }
}