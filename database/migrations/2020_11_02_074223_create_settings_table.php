<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('whats_num')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('country')->nullable();
            $table->text('fb_link')->nullable();
            $table->text('tw_link')->nullable();
            $table->text('in_link')->nullable();
            $table->text('insta_link')->nullable();
            $table->text('website_link')->nullable();
            $table->text('address')->nullable();
            $table->string('logo')->nullable();
            $table->string('icon')->nullable();

            $table->unsignedBigInteger('primary_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lang_id')->nullable();

            $table->foreign('primary_id')->references('id')->on('users')
                ->ondelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->ondelete('cascade');
            $table->foreign('lang_id')->references('id')->on('languages_old')
                ->ondelete('cascade');

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
        Schema::dropIfExists('settings');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
