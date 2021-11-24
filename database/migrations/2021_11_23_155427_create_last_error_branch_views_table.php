<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLastErrorBranchViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("SET @@sql_mode :=''");
        \DB::statement("CREATE VIEW last_error_branch_views AS(
        SELECT * FROM branch_net_works
        WHERE id IN (
        SELECT MAX(id) FROM branch_net_works
        GROUP BY branch_code
        )
        )
        ");
        DB::unprepared("SET @@sql_mode :='ONLY_FULL_GROUP_BY'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('last_error_branch_views');
    }
}
