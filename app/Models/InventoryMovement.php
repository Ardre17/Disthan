<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    protected $fillable = [

        'product_id',

        'raw_material_id',

        'client_id',

        'user_id',

        'movement_type',

        'module',

        'reference_id',

        'entry',

        'exit',

        'stock_before',

        'stock_after',

        'document_number',

        'observation'

    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}