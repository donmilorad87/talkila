<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedInteger('talk_id');
            $table->foreign('talk_id', 'talk_id_fk_1663339')->references('id')->on('talks');
            $table->unsignedInteger('participant_user_id');
            $table->foreign('participant_user_id', 'participant_user_fk_1673728')->references('id')->on('users');
            $table->unsignedInteger('teacher_user_id');
            $table->foreign('teacher_user_id', 'teacher_user_id_fk_1663339')->references('id')->on('users');
            $table->unsignedInteger('cancellation_reason_id')->nullable();
            $table->foreign('cancellation_reason_id', 'cancellation_reason_fk_1673781')->references('id')->on('calls_cancellation_reasons');
            $table->unsignedTinyInteger('currency')->nullable();
            $table->foreign('currency', 'currency_fk_1673865')->references('id')->on('finance_currencies');
            $table->unsignedInteger('billing_address_id');
            $table->foreign('billing_address_id', 'billing_address_fk_1637685')->references('id')->on('billing_addresses');
        });
    }
}
