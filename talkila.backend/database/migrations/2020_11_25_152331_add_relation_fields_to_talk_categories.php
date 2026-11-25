<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationFieldsToTalkCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('talks', function (Blueprint $table) {
            $table->unsignedInteger('talk_categories_id');
            $table->foreign('talk_categories_id', 'talk_categories_id_fk_1673229')->references('id')->on('talk_categories');
        });
    }
}
