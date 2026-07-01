<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WarehouseLocation;
use App\Models\WarehouseRack;

class WarehouseLocationSeeder extends Seeder
{
    public function run(): void
    {
        WarehouseLocation::truncate();

        $racks = WarehouseRack::orderBy('level')
            ->orderBy('rack')
            ->get();

        foreach ($racks as $rack) {

    $total = $rack->rows * $rack->columns;

    for ($i = 1; $i <= $total; $i++) {

        WarehouseLocation::create([

            'code' => $rack->level .
                $rack->rack .
                str_pad($i,2,'0',STR_PAD_LEFT),

            'full_code' => $rack->level .
                '-' .
                $rack->rack .
                str_pad($i,2,'0',STR_PAD_LEFT),

            'rack' => $rack->rack,

            'rack_name' => $rack->name,

            'level' => $rack->level,

            'row' => ceil($i / $rack->columns),

            'column' => (($i - 1) % $rack->columns) + 1,

            'status' => 'FREE',

            'product_id' => null,

            'stock' => 0,

            'capacity' => 200,

            'max_weight' => 0,

            'notes' => null,

        ]);

    }

}
    }
}