<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUserReportedsTable extends Migration
{
    public function up()
    {
        Schema::table('user_reporteds', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_1695906')->references('id')->on('users');
            $table->unsignedInteger('reporter_user_id');
            $table->foreign('reporter_user_id', 'reporter_user_fk_1695907')->references('id')->on('users');
        });
    }
}
