<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUserFollowedsTable extends Migration
{
    public function up()
    {
        Schema::table('user_followeds', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_1664263')->references('id')->on('users');
            $table->unsignedInteger('follower_user_id');
            $table->foreign('follower_user_id', 'follower_user_fk_1664264')->references('id')->on('users');
        });
    }
}
