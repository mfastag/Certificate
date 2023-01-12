<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventAttachementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_attachement', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('event_id');
            $table->integer('sort_order');
            $table->string('title')->nullable();
            $table->text('upper_text')->nullable();
            $table->text('lower_text')->nullable();
            $table->string('url',512)->nullable();
            $table->string('thumbnail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_attachement');
    }
}
