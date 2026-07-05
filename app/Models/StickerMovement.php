<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StickerMovement extends Model
{
    protected $fillable = [
        'sticker_id','tipo','cantidad','motivo','referencia','saldo_post'
    ];

    public function sticker()
    {
        return $this->belongsTo(Sticker::class);
    }
}