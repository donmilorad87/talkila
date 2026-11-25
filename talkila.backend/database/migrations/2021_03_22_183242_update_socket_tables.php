<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSocketTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('socket_rooms', function (Blueprint $table) {
            $table->index('talk_id');
        });

        Schema::table('socket_participants', function (Blueprint $table) {
            $table->text('twilio_access_token')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('socket_rooms', function (Blueprint $table) {
            $table->dropIndex('talk_id');
            $table->unique('talk_id');
        });

        Schema::table('socket_participants', function (Blueprint $table) {
            $table->string('twilio_access_token', 100)->nullable()->change();
        });
    }
}
