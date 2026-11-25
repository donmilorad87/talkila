<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->unsignedTinyInteger('id', 1);
            $table->string('shorter_code', 2);
            $table->string('short_code', 3)->nullable();
            $table->string('english', 60);
            $table->string('german', 60);
            $table->string('croatian', 60)->nullable();
            $table->string('spanish', 60)->nullable();
            $table->string('french', 60)->nullable();
            $table->string('italian', 60)->nullable();
            $table->string('dutch', 60)->nullable();
            $table->string('polish', 60)->nullable();
            $table->string('danish', 60)->nullable();
            $table->string('hungarian', 60)->nullable();
            $table->string('portuguese', 60)->nullable();
            $table->string('russian', 60)->nullable();
            $table->string('turkish', 60)->nullable();
            $table->string('bulgarian', 60)->nullable();
            $table->string('romanian', 60)->nullable();
            $table->string('slovak', 60)->nullable();
            $table->string('czech', 60)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
