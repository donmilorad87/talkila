<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSocketTableDropUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('socket_rooms', function (Blueprint $table) {
            $table->dropUnique('socket_rooms_talk_id_unique');
        });
    }
}
