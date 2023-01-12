<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlagToEventComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_log_comment', function (Blueprint $table) {
            $table->string('flag',32)->nullable();
            $table->string('flag_by',32)->nullable();
            $table->timestamp('flag_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_log_comment', function (Blueprint $table) {
            $table->dropColumn('flag');
            $table->dropColumn('flag_by');
            $table->dropColumn('flag_at');
        });
    }
}
