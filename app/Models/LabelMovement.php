<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabelMovement extends Model
{
    protected $table = 'label_movements';

    protected $fillable = [
        'label_id',
        'tipo',
        'cantidad',
        'motivo',
        'observacion'
    ];

    public function label()
    {
        return $this->belongsTo(Label::class);
    }
}