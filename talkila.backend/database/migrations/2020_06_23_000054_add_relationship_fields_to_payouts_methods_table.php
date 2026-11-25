<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPayoutsMethodsTable extends Migration
{
    public function up()
    {
        Schema::table('payouts_methods', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_1673162')->references('id')->on('users');
        });
    }
}
