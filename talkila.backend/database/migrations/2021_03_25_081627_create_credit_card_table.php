<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_card', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stripe_card_id',100);
            $table->string('stripe_customer_id',100);
            $table->string('user_id',11);
            $table->string('card_last_four_digit',11);
            $table->string('card_month_expire',11);
            $table->string('card_year_expire',11);
            $table->string('card_brand',25);
            $table->tinyInteger('default_card');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_card');
    }
}
