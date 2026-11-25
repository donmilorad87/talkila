<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceCurrenciesTable extends Migration
{
    public function up()
    {
        Schema::create('finance_currencies', function (Blueprint $table) {
            $table->unsignedTinyInteger('id', 1);
            $table->string('iso_code');
            $table->string('short_code')->nullable();
            $table->string('name');
            $table->string('value', 15)->nullable();
            $table->string('symbol', 5)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
