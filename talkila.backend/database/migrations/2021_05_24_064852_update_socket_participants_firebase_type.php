<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSocketParticipantsFirebaseType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('socket_participants', function (Blueprint $table) {
            $table->text('firebase_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('socket_participants', function (Blueprint $table) {
            $table->string('firebase_id', 100)->nullable()->change();
        });
    }
}
