<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'nombre',
        'color',
        'activo',
        'descripcion'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}