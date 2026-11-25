<?php

namespace Database\Seeders;

use App\Models\FinanceCurrency;
use Illuminate\Database\Seeder;

class FinanceCurrenciesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'iso_code' => 'EUR',
                'name' => 'Euro',
                'symbol' => '€',
            ],
            [
                'id'    => 2,
                'iso_code' => 'HRK',
                'name' => 'Kuna',
                'symbol' => 'kn',
            ],
            [
                'id'    => 3,
                'iso_code' => 'GBP',
                'name' => 'Pound',
                'symbol' => '£',
            ],
            [
                'id'    => 4,
                'iso_code' => 'USD',
                'name' => 'US Dollar',
                'symbol' => '$',
            ],
        ];

        FinanceCurrency::insert($roles);
    }
}
