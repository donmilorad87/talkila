<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBlockedsTable extends Migration
{
    public function up()
    {
        Schema::create('user_blockeds', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('state')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
