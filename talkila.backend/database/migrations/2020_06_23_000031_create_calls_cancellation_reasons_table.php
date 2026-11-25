<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallsCancellationReasonsTable extends Migration
{
    public function up()
    {
        Schema::create('calls_cancellation_reasons', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('state')->default(0);
            $table->string('croatian', 255)->nullable();
            $table->string('german', 255);
            $table->string('english', 255);
            $table->string('french', 255)->nullable();
            $table->string('dutch', 255)->nullable();
            $table->string('czech', 255)->nullable();
            $table->string('romanian', 255)->nullable();
            $table->string('italian', 255)->nullable();
            $table->string('spanish', 255)->nullable();
            $table->string('polish', 255)->nullable();
            $table->string('bulgarian', 255)->nullable();
            $table->string('turkish', 255)->nullable();
            $table->string('danish', 255)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }
}
