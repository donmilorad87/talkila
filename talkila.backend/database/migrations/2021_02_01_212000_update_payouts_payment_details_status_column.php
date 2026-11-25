<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdatePayoutsPaymentDetailsStatusColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Normalise the old string values first, so the type change works on every database engine.
        DB::table('bookings_payment_details')->whereIn('status', ['1', 'true'])->update(['status' => '1']);
        DB::table('bookings_payment_details')->whereNotIn('status', ['1', 'true'])->update(['status' => '0']);

        Schema::table('bookings_payment_details', function (Blueprint $table) {
            $table->boolean('status')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings_payment_details', function (Blueprint $table) {
            $table->string('status', 50)->change();
        });
    }
}
