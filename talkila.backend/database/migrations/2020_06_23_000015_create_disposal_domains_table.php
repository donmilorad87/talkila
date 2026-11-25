<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisposalDomainsTable extends Migration
{
    public function up()
    {
        Schema::create('disposal_domains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('domain', 45)->nullable();
            $table->integer('statistics')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['domain']);
        });
    }
}
