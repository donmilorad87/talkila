<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalkSubcategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talk_subcategories', function (Blueprint $table) {
            $table->unsignedInteger('id', 1);
            $table->string('croatian', 50)->nullable();
            $table->string('german', 50);
            $table->string('english', 50);
            $table->string('french', 50)->nullable();
            $table->string('dutch', 50)->nullable();
            $table->string('czech', 50)->nullable();
            $table->string('romanian', 50)->nullable();
            $table->string('italian', 50)->nullable();
            $table->string('spanish', 50)->nullable();
            $table->string('polish', 50)->nullable();
            $table->string('bulgarian', 50)->nullable();
            $table->string('turkish', 50)->nullable();
            $table->string('danish', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('talk_subcategories');
    }
}
