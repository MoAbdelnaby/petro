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
//        \DB::statement("select count(`carprofiles`.`id`) AS `count`,`carprofiles`.`branch_id` AS `branch_id` from `carprofiles` WHERE created_at BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() group by `carprofiles`.`branch_id` order by `count` desc limit 10");
//        \DB::statement("(select count(`carprofiles`.`id`) AS `count`,`carprofiles`.`branch_id` AS `branch_id` from `carprofiles` where (`carprofiles`.`created_at` between (curdate() - interval 30 day) and curdate()) group by `carprofiles`.`branch_id` order by `count` desc limit 10)");
//        select count(`carprofiles`.`id`) AS `count`,`carprofiles`.`branch_id` AS `branch_id` from `carprofiles` where (`carprofiles`.`created_at` between DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY) and curdate()) group by `carprofiles`.`branch_id` order by `count` desc limit 10

//        select count(`carprofiles`.`id`) AS `count`,`carprofiles`.`branch_id` AS `branch_id` from `carprofiles` where (`carprofiles`.`created_at` BETWEEN (curdate() - dayofmonth(CURDATE()) + 1) and curdate()) group by `carprofiles`.`branch_id` order by `count` desc limit 10
        \DB::statement("(select count(`carprofiles`.`id`) AS `count`,`carprofiles`.`branch_id` AS `branch_id` from `carprofiles` where (`carprofiles`.`created_at` between date((curdate() - dayofmonth(curdate())) + 1) and curdate()) group by `carprofiles`.`branch_id` order by `count` desc limit 10)");
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
