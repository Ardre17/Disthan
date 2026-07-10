<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoselitoItem extends Model
{
    protected $fillable = [
        'nombre','proveedor','origen',
        'cantidad_actual','fecha_llegada',
        'observaciones','activo'
    ];

    protected $casts = [
        'fecha_llegada' => 'date',
    ];

    public function movements()
    {
        return $this->hasMany(JoselitoMovement::class)
                    ->orderByDesc('created_at');
    }

    // Ocultar automáticamente cuando llega a 0
    public function scopeConStock($query)
    {
        return $query->where('activo', true)
                     ->where('cantidad_actual', '>', 0);
    }

    public function scopeTodos($query)
    {
        return $query->where('activo', true);
    }

    public function getEstadoAttribute(): string
    {
        if ($this->cantidad_actual <= 0)  return 'DESPACHADO';
        if ($this->cantidad_actual <= 10) return 'POCO';
        return 'EN_ALMACEN';
    }
}