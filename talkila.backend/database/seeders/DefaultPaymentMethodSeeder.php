<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DefaultPaymentMethodSeeder extends Seeder
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
            if ($user->defaultPaymentMethod()) {
                $user->update([
                    'default_payment_method' => $user->defaultPaymentMethod()->id,
                ]);
            }
        }
    }
}
