<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixUsersVisibilityAndGenderColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Restores the types from the create migrations (a PostgreSQL import had turned them into booleans).
        Schema::table('users', function (Blueprint $table) {
            $table->smallInteger('visibility')->unsigned()->default(1)->change();
            $table->smallInteger('gender')->default(1)->change();
        });

        Schema::table('bookings_payment_details', function (Blueprint $table) {
            $table->decimal('amount_value', 10, 2)->change();
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
            $table->double('amount_value')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('visibility')->default(true)->change();
            $table->boolean('gender')->default(true)->change();
        });
    }
}
