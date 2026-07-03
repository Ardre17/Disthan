<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RawMaterialEntry extends Model
{
    protected $fillable = [

        'raw_material_id',

        'supplier',

        'quantity',

        'observation',

        'user_id'

    ];

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}