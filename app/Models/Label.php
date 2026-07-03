<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $fillable = [
        'nombre','idioma','pais','zona',
        'formato','stock_actual','stock_minimo','activo'
    ];

    public function movements()
    {
        return $this->hasMany(LabelMovement::class)
                    ->orderByDesc('created_at');
    }

    // Recalcula stock desde movimientos
    public function recalcularStock(): void
    {
        $entradas = $this->movements()->where('tipo','ENTRADA')->sum('cantidad');
        $salidas  = $this->movements()->where('tipo','SALIDA')->sum('cantidad');
        $this->stock_actual = $entradas - $salidas;
        $this->save();
    }

    public function getEstadoAttribute(): string
    {
        if ($this->stock_actual <= 0)              return 'AGOTADO';
        if ($this->stock_actual <= $this->stock_minimo) return 'STOCK_BAJO';
        return 'DISPONIBLE';
    }
}