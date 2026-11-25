<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
//            $table->unsignedInteger('affiliates_sub_id');
//            $table->unsignedInteger('affiliates_sub_affiliate_id');
            $table->timestamp('affiliates_registration_date')->nullable();
            $table->boolean('affiliate_revenue_limit_reached')->default(0);
//            $table->foreign('affiliates_sub_id')->references('id')->on('affiliates_sub');
//            $table->foreign('affiliates_sub_affiliate_id')->references('affiliate_id')->on('affiliates_sub');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
//            $table->dropColumn('affiliates_sub_id');
//            $table->dropColumn('affiliates_sub_affiliate_id');
            $table->dropColumn('affiliates_registration_date');
            $table->dropColumn('affiliate_revenue_limit_reached');
        });
    }
}
