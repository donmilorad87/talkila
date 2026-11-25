<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserReportTypesAddLanguages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_report_types', function (Blueprint $table) {
            $table->boolean('state');
            $table->tinyInteger('type');
            $table->string('french', 255)->nullable();
            $table->string('dutch', 255)->nullable();
            $table->string('czech', 255)->nullable();
            $table->string('romanian', 255)->nullable();
            $table->string('italian', 255)->nullable();
            $table->string('spanish', 255)->nullable();
            $table->string('polish', 255)->nullable();
            $table->string('bulgarian', 255)->nullable();
            $table->string('turkish', 255)->nullable();
            $table->string('danish', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_report_types', function (Blueprint $table) {
            $table->dropColumn('state');
            $table->dropColumn('type');
            $table->dropColumn('type');
            $table->dropColumn('french');
            $table->dropColumn('dutch');
            $table->dropColumn('czech');
            $table->dropColumn('romanian');
            $table->dropColumn('italian');
            $table->dropColumn('spanish');
            $table->dropColumn('polish');
            $table->dropColumn('bulgarian');
            $table->dropColumn('turkish');
            $table->dropColumn('danish');
        });
    }
}
