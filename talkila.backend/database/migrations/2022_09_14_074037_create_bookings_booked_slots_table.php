<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsBookedSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings_booked_slots', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('booking_id');
            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->unsignedInteger('talk_id');
            $table->foreign('talk_id')->references('id')->on('talks');
            $table->unsignedInteger('teacher_user_id');
            $table->foreign('teacher_user_id')->references('id')->on('users');
            $table->unsignedInteger('participant_user_id');
            $table->foreign('participant_user_id')->references('id')->on('users');
            $table->dateTime('slot_datetime');
            $table->date('slot_date');
            $table->time('slot_time');
            $table->timestamps();

            $table->unique(['teacher_user_id', 'slot_datetime']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings_booked_slots');
    }
}
