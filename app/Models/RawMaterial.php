<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    protected $fillable=[

        'code',

        'name',

        'category',

        'supplier',
        
        'color',

        'active',

        'unit',

        'stock',

        'minimum_stock',

        'status',

        'notes'

    ];
}