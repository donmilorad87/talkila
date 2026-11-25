<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersVATSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::with('billing')->get() as $user) {
            $user->update([
                'vat_id' => Country::GERMANY,
            ]);

            $user->billing()
                ->update([
                    'countries_id' => Country::GERMANY,
                ]);
        }
    }
}
