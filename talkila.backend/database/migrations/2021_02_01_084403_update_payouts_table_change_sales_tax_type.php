<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdatePayoutsTableChangeSalesTaxType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE payouts ALTER COLUMN sales_tax TYPE json USING sales_tax::text::json');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE payouts ALTER COLUMN sales_tax TYPE smallint USING (sales_tax::text)::smallint');
    }
}
