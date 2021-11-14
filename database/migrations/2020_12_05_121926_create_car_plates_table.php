<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarPLatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_plates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_model_branch_id');
            $table->unsignedBigInteger('setting_id');
            $table->enum('area', [1,2,3,4]);
            $table->string('plate_no');
            $table->date('date');
            $table->string('time');
            $table->integer('camera_id')->default(1);
            $table->string('screenshot')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_model_branch_id')->references('id')->on('user_model_branches')
                ->onDelete('cascade');
            $table->foreign('setting_id')->references('id')->on('car_plates_settings')
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
        Schema::dropIfExists('car_plates');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
