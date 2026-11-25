<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJtcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jtc', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('users_id');
            $table->smallInteger('state')->default(0);
            $table->boolean('step_1')->default(0);
            $table->boolean('step_2')->default(0);
            $table->boolean('step_3')->default(0);
            $table->boolean('step_4')->default(0);
            $table->boolean('step_5')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jtc');
    }
}
