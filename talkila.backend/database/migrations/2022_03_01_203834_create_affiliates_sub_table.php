<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliatesSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliates_sub', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('affiliate_id');
            $table->string('tracking_id', 45);
            $table->string('name', 50);
            $table->string('email', 50);
            $table->boolean('state')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('affiliate_id')->references('id')->on('affiliates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affiliates_sub');
    }
}
