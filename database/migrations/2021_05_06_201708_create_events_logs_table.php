<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('eventId');
            $table->integer('uploadBy');
            $table->string('band');
            $table->string('call');
            $table->string('cnty');
            $table->string('comment');
            $table->string('contestId');
            $table->string('country');
            $table->string('dxcc');
            $table->string('email');
            $table->string('esql_esql_rcvd');
            $table->string('freq');
            $table->string('grid');
            $table->string('iota');
            $table->string('lat');
            $table->string('lon');
            $table->string('lotw_qsl_rcvd');
            $table->string('mode');
            $table->string('name');
            $table->string('ownerCall');
            $table->string('propMode');
            $table->string('qsoDate');
            $table->string('qsoDateOff');
            $table->string('qsoTime');
            $table->string('qsoTimeOff');
            $table->string('state');
            $table->string('station_callsign');
            $table->string('satName');
            $table->string('satMode');
            $table->string('TXPwr');
            $table->string('rstSent');
            $table->string('rstRecv');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events_logs');
    }
}
