<?php

use App\Models\PlaceMaintenance;
use Illuminate\Database\Seeder;

class AreaDurationDaily extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $start = PlaceMaintenance::first();
        if ($start) {
            $start = $start->date;
            $begin = new DateTime($start);
            $end = new DateTime();

            $areaDurationService = new App\Services\AreaDurationDaily();

            for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
                $areaDurationService->calculate($i->format("Y-m-d"));
            }
        }

    }
}
