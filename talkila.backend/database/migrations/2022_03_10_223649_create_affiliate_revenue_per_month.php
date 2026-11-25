<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateRevenuePerMonth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_revenue_per_month', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('affiliate_id');
            $table->unsignedInteger('affiliates_sub_id');
            $table->timestamp('date');
            $table->timestamp('month');
            $table->integer('registrations')->default(0);
            $table->string('paypal', 50);
            $table->integer('revenue')->default(0);
            $table->tinyInteger('stage_1')->unsigned()->nullable();
            $table->tinyInteger('stage_2')->unsigned()->nullable();
            $table->tinyInteger('stage_3')->unsigned()->nullable();
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
        Schema::dropIfExists('affiliate_revenue_per_month');
    }
}
