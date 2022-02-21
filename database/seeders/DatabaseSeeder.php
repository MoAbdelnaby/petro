<?php
namespace Database\Seeders;

use App\Services\SeederCheck;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        SeederCheck::start();

        $this->call(UserRolePermissionSeeder::class);
        $this->call(ModelFeaturesSeeder::class);
        $this->call(EditModelFeatureSeeder::class);
        $this->call(RegionsSeeder::class);
        $this->call(ConvertPlateNumberSeeder::class);
        $this->call(SystemPasswordSeeder::class);
        $this->call(AreaStatusSeeder::class);
        $this->call(AreaDurationDaily::class);
        $this->call(ConfigSeeder::class);
        $this->call(MoveImagesToStorageSeeder::class);
        $this->call(MovePlaceImagesToStorageSeeder::class);
        $this->call(branchSettingSeeder::class);
        $this->call(BranchCoordinatesSeeder::class);

    }
}
