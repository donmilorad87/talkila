<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmailChangeVerification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_change_verification', function (Blueprint $table) {
            $table->foreign('user_id', 'user_fk_1673883')->references('id')->on('users');
        });
    }

}
