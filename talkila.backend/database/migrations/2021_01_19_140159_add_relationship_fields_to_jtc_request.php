<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToJtcRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jtc', function (Blueprint $table) {
            $table->foreign('users_id', 'user_fk_1743813')->references('id')->on('users');
        });
    }
}
