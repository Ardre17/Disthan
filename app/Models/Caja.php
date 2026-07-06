<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $fillable = [
        'nombre','tipo','stock_actual','stock_minimo','activo'
    ];

    public function movements()
    {
        return $this->hasMany(CajaMovement::class)->orderByDesc('created_at');
    }

    public function getEstadoAttribute(): string
    {
        if ($this->stock_actual <= 0)                       return 'AGOTADO';
        if ($this->stock_actual <= $this->stock_minimo)     return 'STOCK_BAJO';
        return 'DISPONIBLE';
    }
}