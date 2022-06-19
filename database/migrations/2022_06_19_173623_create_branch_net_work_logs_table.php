<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchNetWorkLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_net_work_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_net_work_id')->constrained('branch_net_works');
            $table->string('branch_code');
            $table->float('cpu')->default(0.00);
            $table->float('temp')->default(0.00);
            $table->float('memory')->default(0.00);
            $table->float('desk')->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branch_net_work_logs');
    }
}
