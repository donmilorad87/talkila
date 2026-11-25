<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUserBlockedsTable extends Migration
{
    public function up()
    {
        Schema::table('user_blockeds', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_1664234')->references('id')->on('users');
            $table->unsignedInteger('blocked_user_id');
            $table->foreign('blocked_user_id', 'blocked_user_fk_1664235')->references('id')->on('users');
        });
    }
}
