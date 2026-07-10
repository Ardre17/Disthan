<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoselitoMovement extends Model
{
    protected $fillable = [
        'joselito_item_id','tipo','cantidad',
        'motivo','destino','saldo_post'
    ];

    public function item()
    {
        return $this->belongsTo(JoselitoItem::class, 'joselito_item_id');
    }
}