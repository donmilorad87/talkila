<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $partners = config('partner');

        foreach ($partners as $partner) {
            $partner = Partner::query()->updateOrCreate(['slug' => $partner['slug']], $partner);
            $partner->dashboard()->updateOrCreate([
                'partner_id' => $partner->id,
            ]);
        }
    }
}
