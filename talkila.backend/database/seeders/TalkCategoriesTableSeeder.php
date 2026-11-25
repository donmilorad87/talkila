<?php

namespace Database\Seeders;

use App\Models\TalkCategories;
use Illuminate\Database\Seeder;

class TalkCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [	"id"=>"1",	"german"=>"Sprachen",	"english"=>"Languages",	"croatian"=>"Jezici",	],
            [	"id"=>"2",	"german"=>"Nachhilfe",	"english"=>"Tutoring",	"croatian"=>"Podučavanje",	],
            [	"id"=>"3",	"german"=>"Musik",	"english"=>"Music",	"croatian"=>"Muzika",	],
            [	"id"=>"4",	"german"=>"Astrologie",	"english"=>"Astrology",	"croatian"=>"Astrologija",	],
            [	"id"=>"5",	"german"=>"Influencer",	"english"=>"Influencer",	"croatian"=>"Influenceri",	],
            [	"id"=>"6",	"german"=>"Sport",	"english"=>"Sports",	"croatian"=>"Sport",	],
            [	"id"=>"7",	"german"=>"Religion",	"english"=>"Religion",	"croatian"=>"Religija",	],
            [	"id"=>"8",	"german"=>"Experten",	"english"=>"Experts",	"croatian"=>"Stručnjaci",	],
            [	"id"=>"9",	"german"=>"Zuhörer",	"english"=>"Listeners",	"croatian"=>"Slušatelji",	],
            [	"id"=>"10",	"german"=>"Gesundheit",	"english"=>"Health",	"croatian"=>"Zdravlje",	],
            [	"id"=>"11",	"german"=>"Flirten",	"english"=>"Flirt",	"croatian"=>"Flirt",	],
            [	"id"=>"12",	"german"=>"Persönlichkeit",	"english"=>"Personality",	"croatian"=>"Ličnost",	],
            [	"id"=>"13",	"german"=>"Unterhaltung",	"english"=>"Fun",	"croatian"=>"Fun",	],
            [	"id"=>"14",	"german"=>"Andere",	"english"=>"Other",	"croatian"=>"Ostalo",	],
        ];

        TalkCategories::insert($categories);
    }
}
