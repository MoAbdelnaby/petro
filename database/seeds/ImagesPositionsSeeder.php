<?php

use Illuminate\Database\Seeder;
use App\Models\ImagePosition;

class ImagesPositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


//$positions = [
//    [197, 530], [195, 449], [278, 530], [277, 448], [358, 448], [358, 366], [396, 288], [481, 286], [359, 529], [439, 529], [439, 449], [439, 368], [520, 368], [520, 449], [520, 530], [602, 530], [602, 450], [602, 368], [566, 287], [650, 286], [736, 286], [684, 367], [683, 449], [683, 530], [764, 531], [764, 449], [764, 367], [820, 287], [706, 203], [529, 205]
//];

$positions = [
    [298, 544], [326, 476], [462, 410], [356, 536], [386, 473], [519, 410], [415, 530], [446, 470], [436, 340], [475, 531], [405, 412], [435, 277], [495, 272], [496, 335], [555, 329], [482, 209], [554, 269], [613, 263], [543, 210], [604, 210], [672, 251], [615, 325], [733, 248], [678, 313], [797, 245], [737, 309], [798, 302], [506, 470], [346, 414], [378, 351]
];


foreach($positions as $key=>$position){
   ImagePosition::create([
        'centerx'=>$position[0],
        'centery' =>$position[1],
        'image_id'=> 10 ,
        'name' => 'reg'.($key+1),
        'created_at'=>\Carbon\Carbon::now(),
        'updated_at'=>\Carbon\Carbon::now(),
    ]);
}






    }
}
