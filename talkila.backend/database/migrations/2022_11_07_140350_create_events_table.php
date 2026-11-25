<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('calendar_id');
            $table->foreign('calendar_id')->references('id')->on('calendars');
            $table->string('event_id');
            $table->string('status');
            $table->string('name');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->boolean('is_whole_day');
            $table->string('timezone');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
