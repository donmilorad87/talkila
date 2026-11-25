<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToProfilCvsTable extends Migration
{
    public function up()
    {
        Schema::table('profil_cvs', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_1673183')->references('id')->on('users');
            $table->unsignedInteger('profession_id')->nullable();
            $table->foreign('profession_id', 'profession_fk_1673195')->references('id')->on('static_professions');
        });
    }
}
