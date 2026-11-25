<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTalksTable extends Migration
{
    public function up()
    {
        Schema::table('talks', function (Blueprint $table) {
            $table->unsignedInteger('teacher_user_id');
            $table->foreign('teacher_user_id', 'teacher_user_fk_1673855')->references('id')->on('users');
            $table->unsignedTinyInteger('languages_id');
            $table->foreign('languages_id', 'languages_fk_1673856')->references('id')->on('languages');
            $table->unsignedTinyInteger('finance_currencies_id');
            $table->foreign('finance_currencies_id', 'finance_currencies_fk_1673865')->references('id')->on('finance_currencies');
            $table->unsignedInteger('billing_address_id');
            $table->foreign('billing_address_id', 'billing_address_fk_1673866')->references('id')->on('billing_addresses');
        });
    }
}
