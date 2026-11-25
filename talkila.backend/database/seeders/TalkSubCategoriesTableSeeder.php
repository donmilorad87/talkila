<?php

namespace Database\Seeders;

use App\Models\TalkSubcategories;
use Illuminate\Database\Seeder;

class TalkSubCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategories = [
            [	"talk_categories_id"=>"1",	"german"=>"Deutsch",	"english"=>"German",	"croatian"=>"Njemački",	],
            [	"talk_categories_id"=>"1",	"german"=>"Kroatisch",	"english"=>"Croatian",	"croatian"=>"Hrvatski",	],
            [	"talk_categories_id"=>"1",	"german"=>"Englisch",	"english"=>"English",	"croatian"=>"Engleski",	],
            [	"talk_categories_id"=>"1",	"german"=>"Spanisch",	"english"=>"Spanish",	"croatian"=>"Španjolski",	],
            [	"talk_categories_id"=>"1",	"german"=>"Französisch",	"english"=>"French",	"croatian"=>"Francuski",	],
            [	"talk_categories_id"=>"1",	"german"=>"Italienisch",	"english"=>"Italian",	"croatian"=>"Talijanski",	],
            [	"talk_categories_id"=>"1",	"german"=>"Portugiesisch",	"english"=>"Portuguese",	"croatian"=>"Portugalski",	],
            [	"talk_categories_id"=>"1",	"german"=>"Niederländisch",	"english"=>"Dutch",	"croatian"=>"Nizozemski",	],
            [	"talk_categories_id"=>"1",	"german"=>"Russisch",	"english"=>"Russian",	"croatian"=>"Ruski",	],
            [	"talk_categories_id"=>"1",	"german"=>"Ukrainisch",	"english"=>"Ukrainian",	"croatian"=>"Uukrajinski",	],
            [	"talk_categories_id"=>"1",	"german"=>"Türkisch",	"english"=>"Turkish",	"croatian"=>"Turski",	],
            [	"talk_categories_id"=>"1",	"german"=>"Dänisch",	"english"=>"Danish",	"croatian"=>"Danski",	],
            [	"talk_categories_id"=>"1",	"german"=>"Schwedisch",	"english"=>"Swedish",	"croatian"=>"Švedski",	],
            [	"talk_categories_id"=>"1",	"german"=>"Finnisch",	"english"=>"Finnish",	"croatian"=>"Finski",	],
            [	"talk_categories_id"=>"1",	"german"=>"Norwegisch",	"english"=>"Norwegian",	"croatian"=>"Norveški",	],
            [	"talk_categories_id"=>"1",	"german"=>"Arabisch",	"english"=>"Arabian",	"croatian"=>"Arapski",	],
            [	"talk_categories_id"=>"1",	"german"=>"Polnisch",	"english"=>"Polish",	"croatian"=>"Polski",	],
            [	"talk_categories_id"=>"1",	"german"=>"Andere",	"english"=>"Other",	"croatian"=>"Ostalo",	],
            [	"talk_categories_id"=>"2",	"german"=>"Mathematik",	"english"=>"Mathematics",	"croatian"=>"Matematika",	],
            [	"talk_categories_id"=>"2",	"german"=>"Biologie",	"english"=>"Biology",	"croatian"=>"Biologija",	],
            [	"talk_categories_id"=>"2",	"german"=>"Physik",	"english"=>"Physics",	"croatian"=>"Fizika",	],
            [	"talk_categories_id"=>"2",	"german"=>"Chemie",	"english"=>"Chemistry",	"croatian"=>"Kemija",	],
            [	"talk_categories_id"=>"2",	"german"=>"BWL",	"english"=>"Business administration",	"croatian"=>"Poslovna administracija",	],
            [	"talk_categories_id"=>"2",	"german"=>"Rechnungwesen",	"english"=>"Accounting",	"croatian"=>"Računovodstvo",	],
            [	"talk_categories_id"=>"2",	"german"=>"Elektrotechnik",	"english"=>"Electrical engineering",	"croatian"=>"Elektrotehnika",	],
            [	"talk_categories_id"=>"2",	"german"=>"Geographie",	"english"=>"Geography",	"croatian"=>"Geografija",	],
            [	"talk_categories_id"=>"2",	"german"=>"Geschichte",	"english"=>"History",	"croatian"=>"Povijest",	],
            [	"talk_categories_id"=>"2",	"german"=>"Musik",	"english"=>"Music",	"croatian"=>"Muzika",	],
            [	"talk_categories_id"=>"2",	"german"=>"VWL",	"english"=>"Economics",	"croatian"=>"Ekonomija",	],
            [	"talk_categories_id"=>"2",	"german"=>"Statistik",	"english"=>"Statistics",	"croatian"=>"Statistika",	],
            [	"talk_categories_id"=>"2",	"german"=>"Andere",	"english"=>"Other",	"croatian"=>"Ostalo",	],
            [	"talk_categories_id"=>"3",	"german"=>"Akkordeon",	"english"=>"Accordion",	"croatian"=>"Harmonika",	],
            [	"talk_categories_id"=>"3",	"german"=>"Blasinstrumente",	"english"=>"Wind instruments",	"croatian"=>"Puhački instrumenti",	],
            [	"talk_categories_id"=>"3",	"german"=>"Geige",	"english"=>"Violin",	"croatian"=>"Violina",	],
            [	"talk_categories_id"=>"3",	"german"=>"Gesang",	"english"=>"Singing",	"croatian"=>"Pjevanje",	],
            [	"talk_categories_id"=>"3",	"german"=>"Gitarre",	"english"=>"Guitar",	"croatian"=>"Gitara",	],
            [	"talk_categories_id"=>"3",	"german"=>"Harfe",	"english"=>"Harp",	"croatian"=>"Harfa",	],
            [	"talk_categories_id"=>"3",	"german"=>"Keyboard",	"english"=>"Keyboard",	"croatian"=>"Tipkovnica",	],
            [	"talk_categories_id"=>"3",	"german"=>"Klavier",	"english"=>"Piano",	"croatian"=>"Klavir",	],
            [	"talk_categories_id"=>"3",	"german"=>"Orgel",	"english"=>"Organ",	"croatian"=>"Orgulje",	],
            [	"talk_categories_id"=>"3",	"german"=>"Percussion",	"english"=>"Percussion",	"croatian"=>"Udaraljke",	],
            [	"talk_categories_id"=>"3",	"german"=>"Saxophon",	"english"=>"Saxophone",	"croatian"=>"Saksofoni",	],
            [	"talk_categories_id"=>"3",	"german"=>"Schlagzeug",	"english"=>"Percussion",	"croatian"=>"Udaraljke",	],
            [	"talk_categories_id"=>"3",	"german"=>"Synthesizer",	"english"=>"Synthesizer",	"croatian"=>"Sintesajzer",	],
            [	"talk_categories_id"=>"3",	"german"=>"Andere",	"english"=>"Other",	"croatian"=>"Ostalo",	],
            [	"talk_categories_id"=>"4",	"german"=>"Horoskope",	"english"=>"Horoscopes",	"croatian"=>"Horoskopi",	],
            [	"talk_categories_id"=>"4",	"german"=>"Andere",	"english"=>"Other",	"croatian"=>"Ostalo",	],
            [	"talk_categories_id"=>"5",	"german"=>"Streamer",	"english"=>"Streamer",	"croatian"=>"Streamer",	],
            [	"talk_categories_id"=>"5",	"german"=>"Andere",	"english"=>"Other",	"croatian"=>"Ostalo",	],
            [	"talk_categories_id"=>"6",	"german"=>"Yoga",	"english"=>"Yoga",	"croatian"=>"Joga",	],
            [	"talk_categories_id"=>"6",	"german"=>"Pilates",	"english"=>"Pilates",	"croatian"=>"Pilates",	],
            [	"talk_categories_id"=>"6",	"german"=>"Workout",	"english"=>"Workout",	"croatian"=>"Vježbati",	],
            [	"talk_categories_id"=>"6",	"german"=>"Rücken",	"english"=>"Back",	"croatian"=>"Leđa",	],
            [	"talk_categories_id"=>"6",	"german"=>"Personal Training",	"english"=>"Personal Training",	"croatian"=>"Osobni trening",	],
            [	"talk_categories_id"=>"6",	"german"=>"Andere",	"english"=>"Other",	"croatian"=>"Ostalo",	],
            [	"talk_categories_id"=>"7",	"german"=>"Christentum",	"english"=>"Christianity",	"croatian"=>"Kršćanstvo",	],
            [	"talk_categories_id"=>"7",	"german"=>"Judentum",	"english"=>"Judaism",	"croatian"=>"Judaizam",	],
            [	"talk_categories_id"=>"7",	"german"=>"Islam",	"english"=>"Islam",	"croatian"=>"Islam",	],
            [	"talk_categories_id"=>"7",	"german"=>"Hinduismus",	"english"=>"Hinduism",	"croatian"=>"Hinduizam",	],
            [	"talk_categories_id"=>"7",	"german"=>"Buddhismus",	"english"=>"Buddhism",	"croatian"=>"Budizam",	],
            [	"talk_categories_id"=>"7",	"german"=>"Andere",	"english"=>"Other",	"croatian"=>"Ostalo",	],
            [	"talk_categories_id"=>"8",	"german"=>"Rechtsanwalt",	"english"=>"Lawyer",	"croatian"=>"Odvjetnik",	],
            [	"talk_categories_id"=>"8",	"german"=>"Steuerberater",	"english"=>"Tax consultant",	"croatian"=>"Porezni savjetnik",	],
            [	"talk_categories_id"=>"8",	"german"=>"Finanzberater",	"english"=>"Financial advisor",	"croatian"=>"Financijski savjetnik",	],
            [	"talk_categories_id"=>"8",	"german"=>"Versicherung",	"english"=>"Insurance",	"croatian"=>"Osiguranje",	],
            [	"talk_categories_id"=>"8",	"german"=>"Andere",	"english"=>"Other",	"croatian"=>"Ostalo",	],
            [	"talk_categories_id"=>"9",	"german"=>"Seelsorge",	"english"=>"Pastoral care",	"croatian"=>"Pastoralna skrb",	],
            [	"talk_categories_id"=>"9",	"german"=>"Andere",	"english"=>"Other",	"croatian"=>"Ostalo",	],
            [	"talk_categories_id"=>"10",	"german"=>"Ernährungsberatung",	"english"=>"Nutritional counseling",	"croatian"=>"Nutricionističko savjetovanje",	],
            [	"talk_categories_id"=>"10",	"german"=>"Vegan",	"english"=>"Vegan",	"croatian"=>"Vegan",	],
            [	"talk_categories_id"=>"10",	"german"=>"Vegetarismus",	"english"=>"Vegetarianism",	"croatian"=>"Vegetarijanstvo",	],
            [	"talk_categories_id"=>"10",	"german"=>"Andere",	"english"=>"Other",	"croatian"=>"Ostalo",	],
            [	"talk_categories_id"=>"11",	"german"=>"Allgemein",	"english"=>"General",	"croatian"=>"Općenito",	],
            [	"talk_categories_id"=>"11",	"german"=>"NLP",	"english"=>"NLP",	"croatian"=>"NLP",	],
            [	"talk_categories_id"=>"11",	"german"=>"Pick Up",	"english"=>"Pick Up",	"croatian"=>"Pokupiti",	],
            [	"talk_categories_id"=>"11",	"german"=>"Andere",	"english"=>"Other",	"croatian"=>"Ostalo",	],
            [	"talk_categories_id"=>"12",	"german"=>"Persönlichkeitsentwicklung",	"english"=>"Personality development",	"croatian"=>"Razvoj osobnosti",	],
            [	"talk_categories_id"=>"12",	"german"=>"Angstzustände",	"english"=>"Anxiety",	"croatian"=>"Anksioznost",	],
            [	"talk_categories_id"=>"12",	"german"=>"Eheberatung",	"english"=>"Marriage counseling",	"croatian"=>"Bračno savjetovanje",	],
            [	"talk_categories_id"=>"12",	"german"=>"Sexualberatung",	"english"=>"Sex counseling",	"croatian"=>"Spolno savjetovanje",	],
            [	"talk_categories_id"=>"12",	"german"=>"Depressionen",	"english"=>"Depressions",	"croatian"=>"Depresije",	],
            [	"talk_categories_id"=>"12",	"german"=>"Andere",	"english"=>"Other",	"croatian"=>"Ostalo",	],
        ];

        TalkSubcategories::insert($subcategories);
    }
}
