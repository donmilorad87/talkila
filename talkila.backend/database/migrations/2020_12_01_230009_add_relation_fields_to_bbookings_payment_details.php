<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationFieldsToBbookingsPaymentDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings_payment_details', function (Blueprint $table) {
            $table->unsignedInteger('booking_id');
            $table->foreign('booking_id', 'booking_id_fk_1622239')->references('id')->on('bookings');
        });
    }
}
