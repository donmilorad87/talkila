<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocketNetworkQualityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socket_network_quality', function (Blueprint $table) {
            $table->integer('socket_room_id', false, true);
            $table->integer('socket_participant_id', false, true);
            $table->dateTime('created_at')->useCurrent();
            $table->tinyInteger('quality_level', false, true)->default(0);
            $table->foreign('socket_room_id')->references('id')->on('socket_rooms');
            $table->foreign('socket_participant_id')->references('id')->on('socket_participants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socket_network_quality');
    }
}
