<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemLoginsTable extends Migration
{
    public function up()
    {
        Schema::create('system_logins', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('login_type');
            $table->tinyInteger('type')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
