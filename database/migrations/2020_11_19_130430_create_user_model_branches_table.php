<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserModelBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_model_branches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_model_id');
            $table->unsignedBigInteger('branch_id');
            $table->boolean('active')->default(true);
            $table->unique(['user_model_id', 'branch_id','active','deleted_at'],'user_model_branch_key');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_model_id')->references('id')->on('users_models')
                ->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('user_model_branches');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
