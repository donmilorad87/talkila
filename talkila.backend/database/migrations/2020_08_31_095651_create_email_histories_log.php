<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailHistoriesLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_histories_log', function (Blueprint $table) {
            $table->id();
            $table->boolean('type')->nullable();
            $table->string('from_user', 100);
            $table->string('to_user', 100);
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->string('template_id')->nullable();
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
        Schema::dropIfExists('email_histories_log');
    }
}
