<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarprofilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carprofiles', function (Blueprint $table) {
            $table->id();
            $table->string('plateNumber')->nullable();
            $table->timestamp('checkInDate')->nullable();
            $table->timestamp('checkOutDate')->nullable();
            $table->enum('status', ['pending','semi-completed','completed']);
            $table->string('BayCode')->nullable();
            $table->string('plateCountry')->default('Saudi Arabia');
            $table->string('plateColor')->default('White');
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches')
                ->onDelete('cascade');
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
        Schema::dropIfExists('carprofiles');
    }
}
