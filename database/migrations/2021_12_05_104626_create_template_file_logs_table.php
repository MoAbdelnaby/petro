<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateFileLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_file_logs', function (Blueprint $table) {
            $table->id();
            $table->mediumText('file')->nullable();
            $table->string('template_id');
            $table->string('distance')->nullable();
            $table->string('phone');
            $table->string('PlateNumber');
            $table->string('branch_code')->nullable();
            $table->string('storage')->nullable();
            $table->enum('type',['invoice','estimate'])->nullable();
            $table->string('invoiceNumber')->nullable();
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
        Schema::dropIfExists('template_file_logs');
    }
}
