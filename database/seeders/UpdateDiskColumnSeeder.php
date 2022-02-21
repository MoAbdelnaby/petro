<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UpdateDiskColumnSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Carprofile::update(['disk'=>'local']);
        \App\Models\PlaceMaintenance::update(['disk'=>'local']);
    }
}
