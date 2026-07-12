<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PalletType;

class PalletTypeSeeder extends Seeder
{
    public function run(): void
    {
        PalletType::create([

            'nombre' => 'Pallet Estándar',

            'largo_cm' => 120,

            'ancho_cm' => 100,

            'altura_maxima_cm' => 160,

            'peso_maximo_kg' => 1000,

            'activo' => true

        ]);
    }
}