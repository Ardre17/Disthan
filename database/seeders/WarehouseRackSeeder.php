<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WarehouseRack;

class WarehouseRackSeeder extends Seeder
{
    public function run(): void
    {
        WarehouseRack::truncate();

        $racks = [

            // =====================
            // NIVEL 2
            // =====================

            [
                'rack'=>'A',
                'level'=>2,
                'name'=>'Rack A',
                'rows'=>6,
                'columns'=>3,
                'type'=>'ALMACENAMIENTO'
            ],

            [
                'rack'=>'B',
                'level'=>2,
                'name'=>'Rack B',
                'rows'=>6,
                'columns'=>3,
                'type'=>'ALMACENAMIENTO'
            ],

            [
                'rack'=>'C',
                'level'=>2,
                'name'=>'Rack C',
                'rows'=>6,
                'columns'=>3,
                'type'=>'ALMACENAMIENTO'
            ],

            [
                'rack'=>'D',
                'level'=>2,
                'name'=>'Rack D',
                'rows'=>6,
                'columns'=>3,
                'type'=>'ALMACENAMIENTO'
            ],

            [
                'rack'=>'E',
                'level'=>2,
                'name'=>'Rack E',
                'rows'=>4,
                'columns'=>2,
                'type'=>'ALMACENAMIENTO'
            ],

            [
                'rack'=>'F',
                'level'=>2,
                'name'=>'Rack F',
                'rows'=>4,
                'columns'=>2,
                'type'=>'ALMACENAMIENTO'
            ],

            // =====================
            // NIVEL 1
            // =====================

            [
                'rack'=>'A',
                'level'=>1,
                'name'=>'Rack A',
                'rows'=>6,
                'columns'=>3,
                'type'=>'ALMACENAMIENTO'
            ],

            [
                'rack'=>'B',
                'level'=>1,
                'name'=>'Rack B',
                'rows'=>6,
                'columns'=>3,
                'type'=>'ALMACENAMIENTO'
            ],

            [
                'rack'=>'C',
                'level'=>1,
                'name'=>'Rack C',
                'rows'=>6,
                'columns'=>3,
                'type'=>'ALMACENAMIENTO'
            ],

            [
                'rack'=>'D',
                'level'=>1,
                'name'=>'Rack D',
                'rows'=>6,
                'columns'=>3,
                'type'=>'ALMACENAMIENTO'
            ],

            [
                'rack'=>'G',
                'level'=>1,
                'name'=>'Rack G',
                'rows'=>6,
                'columns'=>3,
                'type'=>'BAJA_ROTACION'
            ]

        ];

        foreach($racks as $rack){

            WarehouseRack::create($rack);

        }

    }
}
