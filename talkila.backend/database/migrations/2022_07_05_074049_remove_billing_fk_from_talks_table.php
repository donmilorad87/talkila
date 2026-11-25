<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveBillingFkFromTalksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('talks', function (Blueprint $table) {
            $table->dropForeign('billing_address_fk_1673866');
            $table->dropColumn('billing_address_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('talks', function (Blueprint $table) {
            $table->unsignedInteger('billing_address_id')->nullable();
            $table->foreign('billing_address_id', 'billing_address_fk_1673866')->references('id')->on('billing_addresses');
        });
    }
}
