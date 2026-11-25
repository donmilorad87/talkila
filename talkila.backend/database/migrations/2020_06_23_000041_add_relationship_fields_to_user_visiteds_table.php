<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUserVisitedsTable extends Migration
{
    public function up()
    {
        Schema::table('user_visiteds', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_1695931')->references('id')->on('users');
            $table->unsignedInteger('visited_user_id');
            $table->foreign('visited_user_id', 'visited_user_fk_1695932')->references('id')->on('users');
        });
    }
}
