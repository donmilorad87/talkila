<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('state')->unsigned()->default(1);
            $table->boolean('booking_type')->nullable()->default(0);
            $table->boolean('anonym')->default(0);
            $table->tinyInteger('duration');
            $table->decimal('price', 10, 2);
            $table->string('wallet_id', 10);
            $table->boolean('notification_before_meeting')->default(0);
            $table->longText('message')->nullable()->comment('Message from fan to the organizer');
            $table->datetime('start_call')->nullable();
            $table->datetime('end_call')->nullable();
            $table->boolean('state_payout')->nullable();
            $table->string('reference', 10)->nullable();
            $table->string('transaction_id', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
        });
    }
}
