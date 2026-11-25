<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBillingAddressesTable extends Migration
{
    public function up()
    {
        Schema::table('billing_addresses', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_1673232')->references('id')->on('users');
            $table->unsignedTinyInteger('countries_id');
            $table->foreign('countries_id', 'countries_fk_1673434')->references('id')->on('countries');
        });
    }
}
