<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_features', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('feature_id');
            $table->string('price')->nullable();
            $table->boolean('active')->default(true);
            $table->unique(['model_id', 'feature_id','active']);
            $table->foreign('model_id')->references('id')->on('lt_models')->ondelete('cascade');
            $table->foreign('feature_id')->references('id')->on('features')->ondelete('cascade');
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('model_features');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
