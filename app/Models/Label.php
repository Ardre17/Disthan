<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $table = 'labels';

    protected $fillable = [
        'idioma',
        'zona',
        'stock',
        'stock_minimo'
    ];

    public function movements()
    {
        return $this->hasMany(LabelMovement::class);
    }
}