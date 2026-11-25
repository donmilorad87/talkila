<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReportedsTable extends Migration
{
    public function up()
    {
        Schema::create('user_reporteds', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type_id')->default(9);
            $table->longText('description')->nullable();
            $table->tinyInteger('state')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
