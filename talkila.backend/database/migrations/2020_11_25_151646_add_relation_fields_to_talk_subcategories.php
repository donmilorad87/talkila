<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationFieldsToTalkSubcategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('talks', function (Blueprint $table) {
            $table->unsignedInteger('talk_subcategories_id');
            $table->foreign('talk_subcategories_id', 'talk_subcategories_id_fk_1673339')->references('id')->on('talk_subcategories');
        });

        Schema::table('talk_subcategories', function (Blueprint $table) {
            $table->unsignedInteger('talk_categories_id');
            $table->foreign('talk_categories_id', 'talk_categories_id_fk_1673129')->references('id')->on('talk_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
