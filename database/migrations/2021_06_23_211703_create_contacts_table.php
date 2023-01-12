<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('callsign',20)->unique();
            $table->integer('do_not_contact')->default(0);
            $table->dateTime('lookup_on')->null();
            $table->string('source',24);
            $table->string('email',64)->null();
            $table->string('name',64)->null();
            $table->string('nickname',64)->null();
            $table->string('attn',64)->null();
            $table->string('addr1',64)->null();
            $table->string('addr2',64)->null();
            $table->string('url',128)->null();
            $table->string('country',64)->null();
            $table->string('state',24)->null();
            $table->string('county',64)->null();
            $table->string('zip',24)->null();
            $table->string('city',64)->null();
            $table->string('phone_home',64)->null();
            $table->string('phone_mobile',64)->null();
            $table->string('phone_office',64)->null();
            $table->string('phone_fax',64)->null();
            $table->string('iota',12)->null();
            $table->string('dxcc',12)->null();
            $table->string('grid',12)->null();
            $table->float('lat')->null();
            $table->float('lon')->null();
            $table->integer('eqsl')->null();
            $table->integer('mqsl')->null();
            $table->integer('lotw')->null();
            $table->index(['lookup_on','callsign']);
        });
    }




    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
