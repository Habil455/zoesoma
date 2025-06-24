<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'id' => 1,
                'name' =>  'Arusha'
            ],
            [
                'id' => 2,
                'name' =>  'Dar es Salaam'
            ],
            [
                'id' => 3,
                'name' =>  'Dodoma'
            ],
            [
                'id' => 4,
                'name' =>  'Geita'
            ],
            [
                'id' => 5,
                'name' => 'Iringa'
            ], [
                'id' => 6,
                'name' =>'Kagera'
            ], [
                'id' => 7,
                'name' =>'Katavi'
            ], [
                'id' => 8,
                'name' =>'Kigoma'
            ], [
                'id' => 9,
                'name' =>'Kilimanjaro'
            ], [
                'id' => 10,
                'name' =>'Lindi'
            ], [
                'id' => 11,
                'name' =>'Manyara'
            ], [
                'id' => 12,
                'name' =>'Mara'
            ], [
                'id' => 13,
                'name' =>'Mbeya'
            ], [
                'id' => 14,
                'name' =>'Morogoro'
            ], [
                'id' => 15,
                'name' =>'Mtwara'
            ], [
                'id' => 16,
                'name' =>'Mwanza'
            ], [
                'id' => 17,
                'name' =>'Njombe'
            ], [
                'id' => 18,
                'name' =>'Pemba North'
            ],
            [
                'id' => 19,
                'name' => 'Pemba South'
            ],
            [
                'id' => 20,
                'name' =>'Pwani'
            ],
            [
                'id' => 21,
                'name' =>'Rukwa'
            ],[
                'id' => 22,
                'name' =>'Ruvuma'
            ],[
                'id' => 23,
                'name' =>'Shinyanga'
            ],[
                'id' => 24,
                'name' =>'Simiyu'
            ],[
                'id' => 25,
                'name' =>'Singida'
            ],[
                'id' => 26,
                'name' =>'Tabora'
            ],[
                'id' => 27,
                'name' =>'Tanga'
            ],[
                'id' =>28,
                'name' =>'Zanzibar North'
            ],[
                'id' => 29,
                'name' =>'Zanzibar South and Central'
            ],
            [
                'id' => 30,
                'name' =>'Zanzibar West'
            ],
            [
                'id' => 32,
                'name' =>'Songwe'
            ],

        ];

        foreach ($items as $item) {
            Region::updateorCreate($item);
        }


    }

}
