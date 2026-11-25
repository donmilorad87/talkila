<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientBillingForeignKeyToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->renameColumn('billing_address_id', 'supplier_billing_address_id');
            $table->unsignedInteger('client_billing_address_id')->nullable();
            $table->foreign('client_billing_address_id', 'billing_address_fk_1673868')->references('id')->on('billing_addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->renameColumn('supplier_billing_address_id', 'billing_address_id');
            $table->dropForeign('billing_address_fk_1673868');
            $table->dropColumn('client_billing_address_id');
        });
    }
}
