<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAffiliateRevenueAddStageColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('affiliates_revenue', function (Blueprint $table) {
            $table->tinyInteger('stage_1')->unsigned()->nullable();
            $table->tinyInteger('stage_2')->unsigned()->nullable();
            $table->tinyInteger('stage_3')->unsigned()->nullable();
            $table->timestamp('stage_1_month')->nullable();
            $table->timestamp('stage_2_month')->nullable();
            $table->timestamp('stage_3_month')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliates_revenue', function (Blueprint $table) {
            $table->dropColumn('stage_1');
            $table->dropColumn('stage_2');
            $table->dropColumn('stage_3');
            $table->dropColumn('stage_1_month');
            $table->dropColumn('stage_2_month');
            $table->dropColumn('stage_3_month');
        });
    }
}
