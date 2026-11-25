<?php

namespace Database\Seeders;

use App\Models\PartnerUser;
use Illuminate\Database\Seeder;

class PartnerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PartnerUser::all()
            ->each(function ($user) {
                $user->update([
                    'hash' => sha1($user->email),
                ]);
            });
    }
}
