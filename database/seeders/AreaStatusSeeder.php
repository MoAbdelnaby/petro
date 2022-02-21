<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class AreaStatusSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach (Branch::all() as $branch) {

            $areas_count = ($branch->area_count || !empty($branch->area_count)) ? $branch->area_count : 4;

            for ($i = 1; $i <= $areas_count; $i++) {

                $branch->areas()->firstOrCreate([
                    'area' => $i
                ], [
                    'status' => 0
                ]);
            }
        }
    }
}
