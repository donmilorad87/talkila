<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('stars_content')->nullable()->default(9);
            $table->smallInteger('stars_voice_quality')->nullable()->default(9);
            $table->longText('description')->nullable();
            $table->tinyInteger('state')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
