<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('affiliates_sub_id')->unsigned()->nullable();
            $table->foreign('affiliates_sub_id', 'affiliates_sub_id_fk_1673855')->references('id')->on('affiliates_sub');
            $table->integer('affiliates_sub_affiliate_id')->unsigned()->nullable();
            $table->index('affiliates_sub_affiliate_id', 'affiliates_sub_affiliate_id_fk_1673856');
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
            $table->dropIndex('affiliates_sub_affiliate_id_fk_1673856');
            $table->dropIndex('affiliates_sub_id_fk_1673855');
        });
    }
}
