<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUserDontShowAgainsTable extends Migration
{
    public function up()
    {
        Schema::table('user_dont_show_agains', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_1664274')->references('id')->on('users');
            $table->unsignedInteger('dont_show_again_user_id');
            $table->foreign('dont_show_again_user_id', 'dont_show_again_user_fk_1664275')->references('id')->on('users');
        });
    }
}
