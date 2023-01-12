<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCmtCertToEventLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_logs', function (Blueprint $table) {
            $table->timestamp('cert_req_date')->nullable();
            $table->string('cert_comment',4000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_logs', function (Blueprint $table) {
            $table->dropColumn('cert_req_date');
            $table->dropColumn('cert_comment');
        });
    }
}
