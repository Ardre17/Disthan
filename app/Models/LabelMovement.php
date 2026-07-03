<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabelMovement extends Model
{
    protected $fillable = [
        'label_id','tipo','cantidad',
        'motivo','referencia','saldo_post'
    ];

    public function label()
    {
        return $this->belongsTo(Label::class);
    }
}