<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticProfessionsTable extends Migration
{
    public function up()
    {
        Schema::create('static_professions', function (Blueprint $table) {
            $table->unsignedInteger('id', 1);
            $table->string('croatian', 255)->nullable();
            $table->string('german', 255)->nullable();
            $table->string('english', 255)->nullable();
            $table->string('spanish', 255)->nullable();
            $table->string('french', 255)->nullable();
            $table->string('italien', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
