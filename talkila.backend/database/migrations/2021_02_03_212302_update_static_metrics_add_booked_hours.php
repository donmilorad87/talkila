<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStaticMetricsAddBookedHours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('static_metrics', function (Blueprint $table) {
            $table->integer('my_booked_hours')->default(0);
            $table->integer('received_booked_hours')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('static_metrics', function (Blueprint $table) {
            $table->dropColumn('my_booked_hours');
            $table->dropColumn('received_booked_hours');
        });
    }
}
