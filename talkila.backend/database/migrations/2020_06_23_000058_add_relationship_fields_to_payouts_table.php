<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPayoutsTable extends Migration
{
    public function up()
    {
        Schema::table('payouts', function (Blueprint $table) {
            $table->foreign('user_id', 'user_fk_1673283')->references('id')->on('users');
            $table->unsignedTinyInteger('finance_currencies_id');
            $table->foreign('finance_currencies_id', 'finance_currencies_fk_1673281')->references('id')->on('finance_currencies');
        });
    }
}
