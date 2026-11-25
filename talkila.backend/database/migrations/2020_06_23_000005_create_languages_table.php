<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->unsignedTinyInteger('id', 1);
            $table->string('code', 3);
            $table->string('croatian', 35)->nullable();
            $table->string('english', 35)->nullable();
            $table->string('german', 35)->nullable();
            $table->string('french', 35)->nullable();
            $table->string('dutch', 35)->nullable();
            $table->string('czech', 35)->nullable();
            $table->string('romanian', 35)->nullable();
            $table->string('italian', 35)->nullable();
            $table->string('spanish', 35)->nullable();
            $table->string('polish', 35)->nullable();
            $table->string('bulgarian', 35)->nullable();
            $table->string('turkish', 35)->nullable();
            $table->string('danish', 35)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
