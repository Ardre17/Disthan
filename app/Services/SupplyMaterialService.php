<?php

namespace App\Services;

use App\Models\Label;
use App\Models\Sticker;
use App\Models\Precinto;
use App\Models\Caja;
use Illuminate\Support\Collection;

class SupplyMaterialService
{
    /**
     * Obtiene todos los materiales disponibles
     * desde las diferentes fuentes de inventario.
     */
    public function all(?string $search = null): Collection
    {
        $labels = Label::query()
            ->where('activo', 1)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                      ->orWhere('idioma', 'like', "%{$search}%")
                      ->orWhere('pais', 'like', "%{$search}%")
                      ->orWhere('zona', 'like', "%{$search}%")
                      ->orWhere('formato', 'like', "%{$search}%");
                });
            })
            ->get()
            ->map(function ($item) {
                return [
                    'tipo' => 'LABEL',
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'detalle' => collect([
                        $item->idioma,
                        $item->pais,
                        $item->zona,
                        $item->formato,
                    ])->filter()->implode(' · '),
                    'stock' => (float) $item->stock_actual,
                    'stock_minimo' => (float) $item->stock_minimo,
                    'estado' => $item->estado,
                ];
            });

        $stickers = Sticker::query()
            ->where('activo', 1)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                      ->orWhere('idioma', 'like', "%{$search}%");
                });
            })
            ->get()
            ->map(function ($item) {
                return [
                    'tipo' => 'STICKER',
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'detalle' => $item->idioma,
                    'stock' => (float) $item->stock_actual,
                    'stock_minimo' => (float) $item->stock_minimo,
                    'estado' => $item->estado,
                ];
            });

        $precintos = Precinto::query()
            ->where('activo', 1)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                      ->orWhere('color', 'like', "%{$search}%");
                });
            })
            ->get()
            ->map(function ($item) {
                return [
                    'tipo' => 'PRECINTO',
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'detalle' => $item->color,
                    'stock' => (float) $item->stock_actual,
                    'stock_minimo' => (float) $item->stock_minimo,
                    'estado' => $item->estado,
                ];
            });

        $cajas = Caja::query()
            ->where('activo', 1)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                      ->orWhere('tipo', 'like', "%{$search}%");
                });
            })
            ->get()
            ->map(function ($item) {
                return [
                    'tipo' => 'CAJA',
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'detalle' => $item->tipo,
                    'stock' => (float) $item->stock_actual,
                    'stock_minimo' => (float) $item->stock_minimo,
                    'estado' => $item->estado,
                ];
            });

        return $labels
            ->concat($stickers)
            ->concat($precintos)
            ->concat($cajas)
            ->sortBy('nombre')
            ->values();
    }

    /**
     * Busca un material específico
     * utilizando su tipo e ID.
     */
    public function find(string $tipo, int $id): array
    {
        return match (strtoupper($tipo)) {

            'LABEL' => $this->formatLabel(
                Label::findOrFail($id)
            ),

            'STICKER' => $this->formatSticker(
                Sticker::findOrFail($id)
            ),

            'PRECINTO' => $this->formatPrecinto(
                Precinto::findOrFail($id)
            ),

            'CAJA' => $this->formatCaja(
                Caja::findOrFail($id)
            ),

            default => throw new \InvalidArgumentException(
                "Tipo de material no válido: {$tipo}"
            ),
        };
    }

    private function formatLabel(Label $item): array
    {
        return [
            'tipo' => 'LABEL',
            'id' => $item->id,
            'nombre' => $item->nombre,
            'detalle' => collect([
                $item->idioma,
                $item->pais,
                $item->zona,
                $item->formato,
            ])->filter()->implode(' · '),
            'stock' => (float) $item->stock_actual,
            'stock_minimo' => (float) $item->stock_minimo,
            'estado' => $item->estado,
        ];
    }

    private function formatSticker(Sticker $item): array
    {
        return [
            'tipo' => 'STICKER',
            'id' => $item->id,
            'nombre' => $item->nombre,
            'detalle' => $item->idioma,
            'stock' => (float) $item->stock_actual,
            'stock_minimo' => (float) $item->stock_minimo,
            'estado' => $item->estado,
        ];
    }

    private function formatPrecinto(Precinto $item): array
    {
        return [
            'tipo' => 'PRECINTO',
            'id' => $item->id,
            'nombre' => $item->nombre,
            'detalle' => $item->color,
            'stock' => (float) $item->stock_actual,
            'stock_minimo' => (float) $item->stock_minimo,
            'estado' => $item->estado,
        ];
    }

    private function formatCaja(Caja $item): array
    {
        return [
            'tipo' => 'CAJA',
            'id' => $item->id,
            'nombre' => $item->nombre,
            'detalle' => $item->tipo,
            'stock' => (float) $item->stock_actual,
            'stock_minimo' => (float) $item->stock_minimo,
            'estado' => $item->estado,
        ];
    }
}