<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBookingsPayoutsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings_payouts', function (Blueprint $table) {
            $table->unsignedInteger('payouts_id');
            $table->foreign('payouts_id', 'payouts_fk_1673823')->references('id')->on('payouts');
            $table->unsignedInteger('bookings_id');
            $table->foreign('bookings_id', 'bookings_fk_1673824')->references('id')->on('bookings');
        });
    }
}
