<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStaticMetricsAddColumnsForBlockedAndReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('static_metrics', function (Blueprint $table) {
            $table->integer('received_blocks')->default(0);
            $table->integer('my_blocked')->default(0);
            $table->integer('received_reports')->default(0);
            $table->integer('my_reports')->default(0);
            $table->integer('talks_reported')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('static_metrics', function (Blueprint $table) {
            $table->dropColumn('received_blocks');
            $table->dropColumn('my_blocked');
            $table->dropColumn('received_reports');
            $table->dropColumn('my_reports');
            $table->dropColumn('talks_reported');
        });
    }
}
