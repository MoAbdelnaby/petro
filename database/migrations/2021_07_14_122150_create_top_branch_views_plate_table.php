<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopBranchViewsPLateTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        \DB::statement("CREATE VIEW view_top_branch_plate AS(
//            SELECT COUNT(id) AS count ,
//            branch_id FROM carprofiles
//            GROUP BY branch_id ORDER BY count DESC LIMIT 10
//            )
//        ");
        \DB::statement("select count(`carprofiles`.`id`) AS `count`,`carprofiles`.`branch_id` AS `branch_id` from `carprofiles` WHERE created_at BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() group by `carprofiles`.`branch_id` order by `count` desc limit 10");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP VIEW IF EXISTS view_top_branch_plate');
    }
}
