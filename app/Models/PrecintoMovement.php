<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrecintoMovement extends Model
{
    protected $fillable = [
        'precinto_id','tipo','cantidad','motivo','referencia','saldo_post'
    ];

    public function precinto()
    {
        return $this->belongsTo(Precinto::class);
    }
}