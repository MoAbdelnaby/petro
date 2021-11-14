<?php

use Illuminate\Database\Seeder;

class MovePlaceImagesToStorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $places = \App\Models\PlaceMaintenance::get();
        foreach ($places as $place ) {
            if(!is_null($place->screenshot)) {
                $data['screenshot'] = str_replace(\Illuminate\Support\Str::before($place->screenshot, '/screenshot'), '', $place->screenshot);
                $place->update($data);
            }

        }
    }
}
