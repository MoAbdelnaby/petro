<?php

use Illuminate\Database\Seeder;

class MoveImagesToStorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profiles = \App\Models\Carprofile::get();

        foreach ($profiles as $profile ) {
            $data = [];
            if(!is_null($profile->screenshot)){
                $data['screenshot']= str_replace(\Illuminate\Support\Str::before($profile->screenshot,'/screenshot'), '', $profile->screenshot);
            }
            if(!is_null($profile->area_screenshot)){
                $data['area_screenshot'] = str_replace(\Illuminate\Support\Str::before($profile->area_screenshot,'/screenshot'), '', $profile->area_screenshot);
            }
            if(!empty($data)) {
                $profile->update($data);
            }

        }
    }
}
