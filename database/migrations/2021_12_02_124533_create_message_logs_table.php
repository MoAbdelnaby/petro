<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['welcome','invoice'])->default('welcome');
            $table->text('message');
            $table->string('plateNumber');
            $table->string('phone');
            $table->string('invoiceUrl')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->enum('status',['failed','sent'])->default('sent');
            $table->string('error_reason')->nullable();
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
        Schema::dropIfExists('message_logs');
    }
}
