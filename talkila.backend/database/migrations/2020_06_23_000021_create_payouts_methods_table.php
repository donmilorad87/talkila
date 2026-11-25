<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutsMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('payouts_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('method')->default(0);
            $table->string('value', 45);
            $table->boolean('state')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
