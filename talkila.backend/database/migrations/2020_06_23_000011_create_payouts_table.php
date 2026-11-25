<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutsTable extends Migration
{
    public function up()
    {
        Schema::create('payouts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->datetime('payout_date');
            $table->decimal('price', 10, 2);
            $table->string('invoice_number', 10);
            $table->tinyInteger('sales_tax');
            $table->string('reference', 45);
            $table->datetime('transferred_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
