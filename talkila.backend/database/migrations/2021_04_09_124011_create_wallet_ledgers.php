<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletLedgers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_ledgers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();;
            $table->integer('wallet_id')->unsigned()->nullable();;
            $table->integer('booking_id')->unsigned()->nullable();;
            $table->string('transaction_type',15);
            $table->string('transaction_id',50);
            $table->double('amount')->default(0);
            $table->tinyInteger('status')->comment('1=completed, 0=cancelled, 2=pending');
            $table->tinyInteger('is_delete')->comment('0=chargeable, 1=not chargeable, 2=refundable');
            $table->timestamps();

            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_ledgers');
    }
}
