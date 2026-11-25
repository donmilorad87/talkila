<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('image', 65);
            $table->tinyInteger('state');
            $table->smallInteger('size');
            $table->timestamps();
        });

        Schema::table('user_images', function (Blueprint $table) {
            $table->foreign('user_id', 'user_fk_1677736')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_images');
    }
}
