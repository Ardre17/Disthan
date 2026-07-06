<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CajaMovement extends Model
{
    protected $fillable = [
        'caja_id','tipo','cantidad','motivo','referencia','saldo_post'
    ];

    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }
}