<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocketRoomErrorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socket_room_error', function (Blueprint $table) {
            $table->integer('socket_room_id', false, true);
            $table->text('error');
            $table->dateTime('created_at')->useCurrent();
            $table->foreign('socket_room_id')->references('id')->on('socket_rooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socket_room_error');
    }
}
