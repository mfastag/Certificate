<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreToEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('contact_email',64)->nullable();
            $table->string('cert_issue_email')->nullable();
            $table->integer('block_blast_emails')->default(0);
            $table->integer('stat_unique_calls')->default(0);
            $table->integer('stat_unique_cert_downloads')->default(0);
            $table->integer('stat_emails_sent')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('contact_email');
            $table->dropColumn('cert_issue_email');
            $table->dropColumn('block_blast_emails');
            $table->dropColumn('stat_unique_calls');
            $table->dropColumn('stat_unique_cert_downloads');
            $table->dropColumn('stat_emails_sent');
        });
    }
}
