<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTypeInMessageLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("ALTER TABLE `message_logs` CHANGE `type` `type` ENUM('welcome', 'invoice', 'estimate') NOT NULL DEFAULT 'welcome';");

        Schema::table('message_logs', function (Blueprint $table) {
            $table->renameColumn('invoiceUrl','fileUrl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('message_logs', function (Blueprint $table) {
            //
        });
    }
}
