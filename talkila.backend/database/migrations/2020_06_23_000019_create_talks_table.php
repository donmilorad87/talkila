<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalksTable extends Migration
{
    public function up()
    {
        Schema::create('talks', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('anonym_call')->default(0);
            $table->boolean('call_type')->default(1);
            $table->boolean('talk_type')->default(1);
            $table->string('headline', 100);
            $table->longText('description')->nullable();
            $table->smallInteger('duration')->default(5)->comment = "Minutes";
            $table->time('start_time_call')->nullable();
            $table->time('end_time_call')->nullable();
            $table->tinyInteger('weekday')->nullable();
            $table->decimal('price', 7, 2)->comment = "Preis pro Kurs";
            $table->tinyInteger('max_participiants')->nullable()->default(1);
            $table->smallInteger('state')->default(1);
            $table->integer('reviews')->default(0);
            $table->decimal('ratings', 10, 1)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
