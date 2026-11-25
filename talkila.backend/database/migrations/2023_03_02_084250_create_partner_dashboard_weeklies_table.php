<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerDashboardWeekliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_dashboard_weeklies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('partner_dashboard_id');
            $table->foreign('partner_dashboard_id', 'partner_dashboard_id_fk_1673867')->references('id')->on('partner_dashboards');
            $table->integer('week');
            $table->integer('year');
            $table->integer('total_new_registrations')->default(0);
            $table->integer('total_jtc_finished')->default(0);
            $table->integer('total_jtc_verified')->default(0);
            $table->integer('total_active_users')->default(0);
            $table->integer('total_bookings')->default(0);
            $table->integer('total_bookings_cancelled')->default(0);
            $table->decimal('total_revenue', 10)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner_dashboard_weeklies');
    }
}
