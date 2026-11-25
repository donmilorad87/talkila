<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticForbiddenNamesTable extends Migration
{
    public function up()
    {
        Schema::create('static_forbidden_names', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->integer('statistics')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['name']);
        });
    }
}
