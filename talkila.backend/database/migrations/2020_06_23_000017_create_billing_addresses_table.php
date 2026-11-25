<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('billing_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 50)->nullable();
            $table->string('company_name', 40)->nullable();
            $table->string('street', 45)->nullable();
            $table->string('zipcode', 10)->nullable();
            $table->string('city', 30)->nullable();
            $table->string('iban_recipient_name', 20)->nullable();
            $table->string('tax_number', 20)->nullable();
            $table->string('tel_number', 20)->nullable();
            $table->tinyInteger('vat')->nullable();
            $table->boolean('state')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
