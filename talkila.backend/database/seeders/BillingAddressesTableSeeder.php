<?php

namespace Database\Seeders;

use App\Models\BillingAddress;
use Illuminate\Database\Seeder;

class BillingAddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reasons = [
            [
                "user_id"             => "1",
                "countries_id"        => "1",
                "email"               => "holder@address.com",
                "company_name"        => "",
                "street"              => "",
                "zipcode"             => "",
                "city"                => "",
                "iban_recipient_name" => "",
                "tax_number"          => "",
                "tel_number"          => "",
                "vat"                 => null,
                "pays_vat"            => "0",
                "state"               => "1",
            ],
        ];

        BillingAddress::insert($reasons);
    }
}
