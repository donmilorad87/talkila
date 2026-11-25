<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticMetricsTable extends Migration
{
    public function up()
    {
        Schema::create('static_metrics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('received_followers')->unsigned()->default(0);
            $table->integer('my_follows')->unsigned()->default(0);
            $table->integer('received_reviews')->unsigned()->default(0);
            $table->integer('my_reviews')->unsigned()->default(0);
            $table->integer('talks')->default(0);
            $table->integer('received_bookings')->default(0);
            $table->integer('my_bookings')->default(0);
            $table->integer('revenue')->unsigned()->default(0);
            $table->integer('received_bad_reports')->unsigned()->default(0);
            $table->integer('my_bad_reports')->unsigned()->default(0);
            $table->integer('send_emails')->unsigned()->default(0);
            $table->integer('searches_per_day')->unsigned()->default(0);
            $table->boolean('visited_user_profiles_per_day')->unsigned()->default(0);
            $table->integer('visited')->unsigned()->default(0);
            $table->integer('received_dont_show_again')->unsigned()->default(0);
            $table->integer('my_dont_show_again')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
