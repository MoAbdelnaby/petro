<?php

use App\Models\Models;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Feature;
use App\Models\ModelFeature;

class ModelFeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('features')->delete();
        DB::table('model_features')->delete();


        $bayarea = Models::create(['name' => 'Bay Area', 'user_id' => 1]);
        $carplates = Models::create(['name' => 'CarPlates', 'user_id' => 1]);

        ////////////////create features lt table
        $screenshot = Feature::create(['name' => 'Screenshot', 'price' => '10']);
        $notification = Feature::create(['name' => 'Notification', 'price' => '10']);

        ModelFeature::create(['model_id' => $bayarea->id, 'feature_id' => $screenshot->id, 'price' => '10']);
        ModelFeature::create(['model_id' => $bayarea->id, 'feature_id' => $notification->id, 'price' => '10']);
        ModelFeature::create(['model_id' => $carplates->id, 'feature_id' => $screenshot->id, 'price' => '10']);
    }
}
