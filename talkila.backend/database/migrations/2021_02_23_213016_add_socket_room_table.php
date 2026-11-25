<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocketRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socket_rooms', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('talk_id', false, true);
            $table->string('room_name', 40);
            $table->smallInteger('duration', false, true);
            $table->tinyInteger('talk_type', false, true)->default(0);
            $table->tinyInteger('call_type', false, true)->default(0);
            $table->tinyInteger('teacher_joined', false, true)->default(0);
            $table->tinyInteger('student_joined', false, true)->default(0);
            $table->tinyInteger('call_extended', false, true)->default(0);
            $table->dateTime('talk_start_time');
            $table->dateTime('talk_end_time');
            $table->dateTime('created_at')->useCurrent();
            $table->tinyInteger('state');
            $table->unique('talk_id');
            $table->foreign('talk_id')->references('id')->on('talks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socket_room');
    }
}
