<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToStaticMetricsTable extends Migration
{
    public function up()
    {
        Schema::table('static_metrics', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_1695916')->references('id')->on('users');
        });
    }
}
