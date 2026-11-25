<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesProfilsTable extends Migration
{
    public function up()
    {
        Schema::create('languages_profils', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('level');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
