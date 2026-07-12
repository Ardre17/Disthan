<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    protected $fillable = [

        'category_id',

        'sku',
        'barcode',
        'box_barcode',
        'nombre',
        'marca',
        'category_id',
        'descripcion',
        'advertencias',
        'peso',

        'imagen',

        'lote',
        'fecha_produccion',
        'fecha_vencimiento',

        'cantidad_por_caja',

        'rotacion',

        'stock',
        'stock_minimo',

        'activo'
    ];
    public function getPesoKgAttribute()
{
    return $this->peso / 1000;
}

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function orderDetails()
{
    return $this->hasMany(OrderDetail::class);
}
 public function locations()
{
    return $this->hasMany(WarehouseLocation::class);
}
public function logistic()
{
    return $this->hasOne(ProductLogistic::class);
}

}
