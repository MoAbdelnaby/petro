<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackoutReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backout_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('station_code');
            $table->string('LatestPlateNumber');
            $table->string('BayCode')->nullable();
            $table->string('CustomerName')->nullable();
            $table->string('CustomerPhone')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('reason1')->nullable();
            $table->string('reason2')->nullable();
            $table->string('reason3')->nullable();
            $table->foreignId('car_profile_id')->nullable()->constrained('carprofiles')->cascadeOnDelete();
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
        Schema::dropIfExists('backout_reasons');
    }
}
