<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToReportedTalks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reported_talks', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_1424242')->references('id')->on('users');
            $table->unsignedInteger('reported_talk_id');
            $table->foreign('reported_talk_id', 'reported_talk_fk_1664264')->references('id')->on('talks');
        });
    }
}
