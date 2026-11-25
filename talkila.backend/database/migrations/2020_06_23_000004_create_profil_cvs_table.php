<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilCvsTable extends Migration
{
    public function up()
    {
        Schema::create('profil_cvs', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('type')->nullable()->default(1);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('company_name', 40)->nullable();
            $table->string('profession', 40)->nullable();
            $table->string('location', 100)->nullable();
            $table->boolean('work_here');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
