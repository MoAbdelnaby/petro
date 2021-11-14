<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaDurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_durations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('work_by_minute');
            $table->bigInteger('empty_by_minute');
            $table->smallInteger('area');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->unsignedBigInteger('last_id');
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
        Schema::dropIfExists('area_durations');
    }
}
