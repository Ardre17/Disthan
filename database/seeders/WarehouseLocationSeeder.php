<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WarehouseLocation;

class WarehouseLocationSeeder extends Seeder
{
    public function run(): void
    {
        WarehouseLocation::truncate();

        $racks = [

            ['rack'=>'A','level'=>2,'total'=>18],
            ['rack'=>'B','level'=>2,'total'=>18],
            ['rack'=>'C','level'=>2,'total'=>18],
            ['rack'=>'D','level'=>2,'total'=>18],

            ['rack'=>'E','level'=>2,'total'=>8],
            ['rack'=>'F','level'=>2,'total'=>8],

            ['rack'=>'A','level'=>1,'total'=>18],
            ['rack'=>'B','level'=>1,'total'=>18],
            ['rack'=>'C','level'=>1,'total'=>18],
            ['rack'=>'D','level'=>1,'total'=>18],

            ['rack'=>'G','level'=>1,'total'=>18],

        ];

        foreach($racks as $r){

            for($i=1;$i<=$r['total'];$i++){

                WarehouseLocation::create([

                    'code' => $r['level'].$r['rack'].str_pad($i,2,'0',STR_PAD_LEFT),

                    'full_code' => $r['level'].'-'.$r['rack'].str_pad($i,2,'0',STR_PAD_LEFT),

                    'rack'=>$r['rack'],

                    'rack_name'=>'Rack '.$r['rack'],

                    'level'=>$r['level'],

                    'row'=>ceil($i/3),

                    'column'=>(($i-1)%3)+1,

                    'status'=>'FREE',

                    'product_id'=>null,

                    'stock'=>0,

                    'capacity'=>200,

                    'max_weight'=>0,

                    'notes'=>null

                ]);

            }

        }
    }
}