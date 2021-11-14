<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopBranchViewsPLaceTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("CREATE VIEW view_top_branch_place AS(
            SELECT MAX(work_by_minute) AS count ,
            branch_id FROM area_duration_days
            GROUP BY branch_id ORDER BY count DESC LIMIT 10
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
        \DB::statement('DROP VIEW IF EXISTS view_top_branch_place');
    }
}
