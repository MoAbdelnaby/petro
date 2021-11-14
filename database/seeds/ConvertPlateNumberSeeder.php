<?php

use App\Models\Carprofile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ConvertPlateNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = Carprofile::where('status','completed')->get();
        foreach ($data as $car) {
            $data_ar  = Str::after(Str::before($car->plateNumber, 'lower: '),'upper:');
            $fn_data_ar = utf8_strrev(str_replace(".", " ", $data_ar));
            $plate_ar = convert2ArabicNum($fn_data_ar);
            $data_en  = Str::after($car->plateNumber, 'lower: ');
            $plate_en = str_replace(".", " ", $data_en);

            $car->update([
                'plate_ar' => $plate_ar,
                'plate_en' => $plate_en,
            ]);
        }

    }
}
