<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReportTypesTable extends Migration
{
    public function up()
    {
        Schema::create('user_report_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('croatian')->nullable();
            $table->string('english')->nullable();
            $table->string('german')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
