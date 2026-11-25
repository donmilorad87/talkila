<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticBlockedUsersTable extends Migration
{
    public function up()
    {
        Schema::create('static_blocked_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 45)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
