<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFeedbackTable extends Migration
{
    public function up()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_1673892')->references('id')->on('users');
            $table->unsignedInteger('talks_id');
            $table->foreign('talks_id', 'talks_fk_1673893')->references('id')->on('bookings');
        });
    }
}
