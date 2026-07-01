<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class WarehouseRack extends Model
{
    protected $fillable = [

        'rack',
        'level',
        'name',
        'rows',
        'columns',
        'type',
        'color',
        'active',
        'notes'

    ];

    public function locations()
    {
        return $this->hasMany(WarehouseLocation::class,'rack','rack');
    }
}
