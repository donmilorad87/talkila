<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUnnecessaryStepsFromJtcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jtc', function (Blueprint $table) {
            $table->dropColumn('step_5');
            $table->dropColumn('step_6');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jtc', function (Blueprint $table) {
            $table->boolean('step_5')->default(0);
            $table->boolean('step_6')->default(0);
        });
    }
}
