<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DefaultNotificationSettingsSeeder extends Seeder
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
            $user->notificationSettings()->updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'bookings'   => true,
                    'payments'   => true,
                    'followings' => true,
                    'reviews'    => true,
                    'payouts'    => true,
                ]
            );
        }
    }
}
