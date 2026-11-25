<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisposalEmails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposal_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 45)->nullable();
            $table->integer('statistics')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disposal_emails');
    }
}
