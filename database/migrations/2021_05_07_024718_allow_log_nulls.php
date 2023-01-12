<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AllowLogNulls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_logs', function (Blueprint $table) {
            $table->string('band')->nullable()->change();
            $table->string('call')->nullable()->change();
            $table->string('cnty')->nullable()->change();
            $table->string('comment')->nullable()->change();
            $table->string('contestId')->nullable()->change();
            $table->string('country')->nullable()->change();
            $table->string('dxcc')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('esql_esql_rcvd')->nullable()->change();
            $table->string('freq')->nullable()->change();
            $table->string('grid')->nullable()->change();
            $table->string('iota')->nullable()->change();
            $table->string('lat')->nullable()->change();
            $table->string('lon')->nullable()->change();
            $table->string('lotw_qsl_rcvd')->nullable()->change();
            $table->string('mode')->nullable()->change();
            $table->string('name')->nullable()->change();
            $table->string('ownerCall')->nullable()->change();
            $table->string('propMode')->nullable()->change();
            $table->string('qsoDate')->nullable()->change();
            $table->string('qsoDateOff')->nullable()->change();
            $table->string('qsoTime')->nullable()->change();
            $table->string('qsoTimeOff')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->string('station_callsign')->nullable()->change();
            $table->string('satName')->nullable()->change();
            $table->string('satMode')->nullable()->change();
            $table->string('TXPwr')->nullable()->change();
            $table->string('rstSent')->nullable()->change();
            $table->string('rstRecv')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
