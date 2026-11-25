<?php

namespace Database\Seeders;

use App\Models\BillingAddress;
use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserBillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            $exist_billing = BillingAddress::query()->where('user_id', $user->id)->exists();

            if (! $exist_billing) {
                $billing = BillingAddress::create([
                    'countries_id' => Country::GERMANY,
                    'email'        => $user->email,
                    'company_name' => $user->name,
                    'user_id'      => $user->id,
                ]);

                $user->update([
                    'billing_address_id' => $billing->id,
                ]);
            }
        }
    }
}
