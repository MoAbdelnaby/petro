<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceMaintenanceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_maintenance_settings', function (Blueprint $table) {
            $table->id();
            $table->string('start_time');
            $table->string('end_time');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('user_model_branch_id');
            $table->boolean('notification')->default(false);
            $table->string('notification_start')->nullable();
            $table->string('notification_end')->nullable();
            $table->boolean('screenshot')->default(false);
            $table->boolean('active')->default(true);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_model_branch_id')->references('id')->on('user_model_branches')
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
        Schema::dropIfExists('place_maintenance_settings');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
