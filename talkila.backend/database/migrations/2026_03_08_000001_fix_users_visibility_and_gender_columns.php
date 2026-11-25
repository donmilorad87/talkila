<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FixUsersVisibilityAndGenderColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE users ALTER COLUMN visibility DROP DEFAULT');
        DB::statement('ALTER TABLE users ALTER COLUMN visibility TYPE smallint USING visibility::integer');
        DB::statement('ALTER TABLE users ALTER COLUMN visibility SET DEFAULT 1');

        DB::statement('ALTER TABLE users ALTER COLUMN gender DROP DEFAULT');
        DB::statement('ALTER TABLE users ALTER COLUMN gender TYPE smallint USING gender::integer');
        DB::statement('ALTER TABLE users ALTER COLUMN gender SET DEFAULT 1');

        DB::statement('ALTER TABLE bookings_payment_details ALTER COLUMN amount_value TYPE decimal(10,2)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE bookings_payment_details ALTER COLUMN amount_value TYPE double precision');

        DB::statement('ALTER TABLE users ALTER COLUMN visibility DROP DEFAULT');
        DB::statement('ALTER TABLE users ALTER COLUMN visibility TYPE boolean USING visibility::boolean');
        DB::statement('ALTER TABLE users ALTER COLUMN visibility SET DEFAULT true');

        DB::statement('ALTER TABLE users ALTER COLUMN gender DROP DEFAULT');
        DB::statement('ALTER TABLE users ALTER COLUMN gender TYPE boolean USING gender::boolean');
        DB::statement('ALTER TABLE users ALTER COLUMN gender SET DEFAULT true');
    }
}
