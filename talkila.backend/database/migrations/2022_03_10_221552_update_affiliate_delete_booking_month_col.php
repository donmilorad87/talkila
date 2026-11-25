<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAffiliateDeleteBookingMonthCol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('affiliates_revenue', function (Blueprint $table) {
            $table->dropForeign('affiliates_revenue_booking_id_foreign');
        });

        Schema::table('affiliates_revenue', function (Blueprint $table) {
            $table->dropColumn('month');
            $table->dropColumn('booking_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliates_revenue', function (Blueprint $table) {
            $table->timestamp('month');
            $table->unsignedInteger('booking_id');
            $table->foreign('booking_id')->references('id')->on('bookings');
        });
    }
}
