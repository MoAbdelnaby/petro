<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchNetWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_net_works', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("branch_id");
            $table->unsignedBigInteger("user_id");
            $table->tinyInteger("status")->default(0);
            $table->timestamps();
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branch_net_works');
    }
}
