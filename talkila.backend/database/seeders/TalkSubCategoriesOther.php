<?php

namespace Database\Seeders;

use App\Models\TalkSubcategories;
use Illuminate\Database\Seeder;

class TalkSubCategoriesOther extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategories = [

            [	"talk_categories_id"=>"13",	"german"=>"Andere",	"english"=>"Other",	"croatian"=>"Ostalo",	],
            [	"talk_categories_id"=>"14",	"german"=>"Andere",	"english"=>"Other",	"croatian"=>"Ostalo",	],
        ];

        TalkSubcategories::insert($subcategories);
    }
}
