<?php
namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {

        DB::table('configs')->delete();

        $charts = ['bar', 'line', 'circle', 'side_bar', 'dynamic_bar'];

        $type = ['place', 'plate'];
        $view = ['home', 'report'];

        for ($i = 0; $i < 2; $i++) {
            for ($k = 0; $k < 2; $k++) {
                foreach ($charts as $data) {

                    Config::updateOrCreate([
                        'key' => 'chart',
                        'value' => $data,
                        'view' => $view[$k],
                        'model_type' => $type[$i],
                        'user_id' => 3,
                        'active' => true,
                    ]);
                }

                Config::updateOrCreate([
                    'key' => 'table',
                    'value' => 1,
                    'view' => $view[$k],
                    'model_type' => $type[$i],
                    'user_id' => 3,
                    'active' => true
                ]);

                Config::updateOrCreate([
                    'key' => 'statistics',
                    'value' => 1,
                    'view' => $view[$k],
                    'model_type' => $type[$i],
                    'user_id' => 3,
                    'active' => true
                ]);
            }

        }
    }
}
