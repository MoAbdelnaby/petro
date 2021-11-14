<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPlateAndAndPlateEnToTableCarprofiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carprofiles', function (Blueprint $table) {
            $table->string('plate_ar')->nullable();
            $table->string('plate_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carprofiles', function (Blueprint $table) {
            $table->dropColumn('plate_ar');
            $table->dropColumn('plate_en');
        });
    }
}
