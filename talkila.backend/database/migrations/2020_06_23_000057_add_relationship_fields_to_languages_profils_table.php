<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToLanguagesProfilsTable extends Migration
{
    public function up()
    {
        Schema::table('languages_profils', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_1673226')->references('id')->on('users');
            $table->unsignedTinyInteger('language_id');
            $table->foreign('language_id', 'language_fk_1673227')->references('id')->on('languages');
        });
    }
}
