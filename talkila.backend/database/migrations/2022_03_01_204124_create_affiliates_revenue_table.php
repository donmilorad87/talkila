<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliatesRevenueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliates_revenue', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('month');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('booking_id');
            $table->unsignedInteger('affiliates_sub_id');
            $table->unsignedInteger('affiliates_sub_affiliate_id');
            $table->string('revenue', 45);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->foreign('affiliates_sub_id')->references('id')->on('affiliates_sub');
            $table->index('affiliates_sub_affiliate_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affiliates_revenue');
    }
}
