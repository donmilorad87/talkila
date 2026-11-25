<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUserVerificationRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_verification_requests', function (Blueprint $table) {
            $table->foreign('user_id', 'user_fk_1673813')->references('id')->on('users');
        });
    }
}
