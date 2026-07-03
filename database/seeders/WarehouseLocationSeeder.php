<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WarehouseLocation;

class WarehouseLocationSeeder extends Seeder
{
    public function run(): void
    {
        // ── Racks normales: 2 niveles × 2 filas × 4 espacios × 4 slots = 64 celdas
        foreach ([1, 2] as $nivel) {
            foreach (['A', 'B'] as $fila) {
                for ($espacio = 1; $espacio <= 4; $espacio++) {
                    for ($slot = 1; $slot <= 4; $slot++) {
                        WarehouseLocation::firstOrCreate([
                            'nivel'   => $nivel,
                            'tipo'    => 'RACK',
                            'fila'    => $fila,
                            'espacio' => $espacio,
                            'slot'    => $slot,
                        ], ['product_id' => null, 'cantidad' => 0]);
                    }
                }
            }
        }

        // ── Zona poca rotación Nivel 1: 10 espacios
        for ($espacio = 1; $espacio <= 10; $espacio++) {
            WarehouseLocation::firstOrCreate([
                'nivel'   => 1,
                'tipo'    => 'ROTACION',
                'fila'    => null,
                'espacio' => $espacio,
                'slot'    => null,
            ], ['product_id' => null, 'cantidad' => 0]);
        }

        // ── Zona poca rotación Nivel 2: 5 espacios
        for ($espacio = 1; $espacio <= 5; $espacio++) {
            WarehouseLocation::firstOrCreate([
                'nivel'   => 2,
                'tipo'    => 'ROTACION',
                'fila'    => null,
                'espacio' => $espacio,
                'slot'    => null,
            ], ['product_id' => null, 'cantidad' => 0]);
        }

        $this->command->info('✅ 79 celdas creadas correctamente.');
    }
}