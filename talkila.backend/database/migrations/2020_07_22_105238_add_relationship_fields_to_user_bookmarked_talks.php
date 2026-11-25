<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUserBookmarkedTalks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_bookmarked_talks', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_1673229')->references('id')->on('users');
            $table->unsignedInteger('talks_id');
            $table->foreign('talks_id', 'talks_fk_1673227')->references('id')->on('talks');
        });
    }

}
