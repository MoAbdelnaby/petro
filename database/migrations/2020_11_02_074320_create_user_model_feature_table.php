<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserModelFeatureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_model_feature', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('user_model_id');
            $table->unsignedBigInteger('feature_id');
            $table->boolean('active')->default(true);
            $table->foreign('user_model_id')->references('id')->on('users_models')
                ->onDelete('cascade');
            $table->foreign('feature_id')->references('id')->on('features')
                ->onDelete('cascade');
            $table->softDeletes();
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('user_model_feature');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
