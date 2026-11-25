<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocketParticipantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socket_participants', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('socket_room_id', false, true);
            $table->integer('booking_id', false, true);
            $table->integer('user_id', false, true);
            $table->string('name_of_user', 50)->nullable();
            $table->string('user_image', 255)->nullable();
            $table->string('firebase_id', 255)->nullable();
            $table->string('twilio_access_token', 100)->nullable();
            $table->tinyInteger('is_active');
            $table->tinyInteger('is_anonym');
            $table->tinyInteger('user_type')->default(0);
            $table->dateTime('room_joined')->nullable();
            $table->dateTime('room_end')->nullable();
            $table->unique(['socket_room_id', 'booking_id', 'user_id']);
            $table->foreign('socket_room_id')->references('id')->on('socket_rooms');
            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socket_participant');
    }
}
