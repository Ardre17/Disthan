<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseLocation extends Model
{
    protected $table = 'almacen_ubicaciones';

    protected $fillable = [
        'nivel', 'tipo', 'fila', 'espacio', 'slot',
        'product_id', 'cantidad', 'observaciones',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /** ¿La celda tiene producto? */
    public function getOcupadaAttribute(): bool
    {
        return !is_null($this->product_id);
    }

    /**
     * Color de estado para el plano.
     * Compara stock global del producto contra su stock_minimo.
     */
    public function getColorEstadoAttribute(): string
    {
        if (!$this->ocupada) return 'empty';

        $stock  = optional($this->product)->stock ?? 0;
        $minimo = optional($this->product)->stock_minimo ?? 0;

        if ($stock <= 0)       return 'crit';
        if ($stock <= $minimo) return 'warn';
        return 'ok';
    }

    /** Etiqueta corta para mostrar en el plano */
    public function getEtiquetaAttribute(): string
    {
        if (!$this->ocupada) return '— libre';
        $nombre = \Str::limit(optional($this->product)->nombre ?? '', 12);
        $stock  = optional($this->product)->stock ?? 0;
        return "{$nombre} · {$stock}u";
    }
}