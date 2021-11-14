<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdddPlateStatusToCarprofiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carprofiles', function (Blueprint $table) {
            $table->enum('plate_status',['success','modified','error' , 'reported'])->default('success');
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
            $table->dropColumn('plate_status');
        });
    }
}
