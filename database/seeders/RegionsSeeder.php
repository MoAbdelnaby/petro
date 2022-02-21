<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {


        $regions = [
            [1,'Riyadh Region','regions/1624278242808290089.svg',3],
            [2,'Makkah Region','regions/162427729199629975.svg',3],
            [3,'Hail Region','regions/1624279585815342731.svg',3],
            [4,'Aljawf Region','regions/1624279712537861573.svg',3],
            [5,'Alqussim Region','regions/1624279782296357797.svg',3],
            [6,'Al Madinah Region','regions/1624279906983036913.svg',3],
            [7,'Al Sharqiyah Region','regions/1624279951859259813.svg',3],
            [8,'Asir Region','regions/1624280042670040485.svg',3],
            [9,'Tabuk Region','regions/1624280117369204450.svg',3],
            [10,'Al Hudud Al Shamaliyah','regions/1624280193101464795.svg',3],
            [11,'Jizan Region','regions/1624280323677550876.svg',3],
            [12,'Najran','regions/1624280434416787167.svg',3],
            [13,'Bahah Region','regions/1624280577918214165.svg',3],

        ];
        $arr = [];
        foreach($regions as $key => $reg){
            \App\Models\Region::withoutEvents(function () use ($reg) {
                $newreg = \App\Models\Region::updateOrCreate(
                    ['id'=>$reg[0]],
                    [
                        'name'=>$reg[1],
                        'display_name'=>$reg[1],
                        'photo' =>$reg[2],
                        'user_id'=> $reg[3] ,
                        'created_at'=>\Carbon\Carbon::now(),
                        'updated_at'=>\Carbon\Carbon::now(),
                    ]
                );
                return $newreg;
            });
        }
    }
}
