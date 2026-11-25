<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsPaymentDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings_payment_details', function (Blueprint $table) {
            $table->id();
            $table->string('payment_reference', 100);
            $table->string('status', 50);
            $table->decimal('amount_value', 10, 2);
            $table->string('amount_currency', 10);
            $table->text('payload');
            $table->dateTime('creation_date')->nullable();
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
        Schema::dropIfExists('bookings_payment_details');
    }
}
