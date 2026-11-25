<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'                 => 1,
                'name'               => 'Admin',
                'email'              => 'admin@admin.com',
                'password'           => '$2y$10$c42WNv5j6piehcmEXCKM1OD7PZHcfaj9sB2Qv5KRJQD3mDyQ0IQe2',
                'remember_token'     => null,
                'approved'           => 1,
                'verified'           => 1,
                'vat_id'             => Country::GERMANY,
                'verified_at'        => '2020-06-18 08:40:59',
                'verification_token' => '',
            ],
        ];

        User::insert($users);
    }
}
