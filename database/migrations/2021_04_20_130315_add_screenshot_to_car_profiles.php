<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScreenshotToCarProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carprofiles', function (Blueprint $table) {
            $table->string('screenshot')->nullable();
            $table->string('area_screenshot')->nullable();
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
            $table->dropColumn('screenshot');
            $table->dropColumn('area_screenshot');
        });
    }
}
