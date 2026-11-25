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
        DB::statement("ALTER TABLE bookings_payment_details ALTER COLUMN status TYPE boolean USING CASE WHEN status IN ('1','true') THEN true ELSE false END");
        DB::statement("ALTER TABLE bookings_payment_details ALTER COLUMN status SET DEFAULT false");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE bookings_payment_details ALTER COLUMN status TYPE varchar(50) USING status::text");
    }
}
