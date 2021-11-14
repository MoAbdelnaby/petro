<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusyAreaBranchView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        \DB::statement("CREATE OR REPLACE VIEW busy_area_branch_view AS(
            SELECT last_plate, area, branch_code
            FROM area_statuses
            Where status = 1
            AND last_plate IS NOT NULL
            )
        ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP VIEW IF EXISTS busy_area_branch_view');
    }
}
