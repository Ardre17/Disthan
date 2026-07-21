<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Desmedro extends Model
{
    protected $fillable = [
        'codigo', 'user_id', 'motivo', 'estado', 'registrado_at',
    ];

    protected $casts = [
        'registrado_at' => 'datetime',
    ];

    public function detalles(): HasMany
    {
        return $this->hasMany(DesmedroDetalle::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getCantidadTotalAttribute(): float
    {
        return $this->detalles->sum('cantidad');
    }

    public static function generarCodigo(): string
{
    $ultimo = static::orderByDesc('id')->first();

    $siguiente = $ultimo ? $ultimo->id + 1 : 1;

    return 'DSM-' . str_pad($siguiente, 6, '0', STR_PAD_LEFT);
}
}