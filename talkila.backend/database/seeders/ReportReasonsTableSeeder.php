<?php

namespace Database\Seeders;

use App\Models\CallsCancellationReason;
use App\Models\UserReportType;
use Illuminate\Database\Seeder;

class ReportReasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reasons = [
            [	"id"=>"1", "state"=>"1", "type"=>"1",	"german"=>"Es ist ein Talk, der nicht auf Talkila sein sollte",	"english"=>"It's a Talk that shouldn't be on Talkila",	"croatian"=>"To je razgovor koji ne bi trebao biti na Talkili.",	],
            [	"id"=>"2", "state"=>"1", "type"=>"1",	"german"=>"Es gibt vor, jemand anderes zu sein",	"english"=>"It's pretending to be someone else",	"croatian"=>"Pretvara se da je netko drugi.",	],
            [	"id"=>"3", "state"=>"1", "type"=>"1",	"german"=>"Es kann unter 13 Jahre alt sein",	"english"=>"It may be under the age of 13",	"croatian"=>"Možda nema više od 13 godina",	],


            [	"id"=>"4", "state"=>"1", "type"=>"2",	"german"=>"Es ist Spam",	"english"=>"It's spam",	"croatian"=>"To je spam",	],
            [	"id"=>"5", "state"=>"1", "type"=>"2",	"german"=>"Nacktheit oder sexuelle Aktivität",	"english"=>"Nudity or sexual activity",	"croatian"=>"Golotinja ili seksualna aktivnost",	],
            [	"id"=>"6", "state"=>"1", "type"=>"2",	"german"=>"Hassreden oder Symbole",	"english"=>"Hate speech or symbols",	"croatian"=>"Govor mržnje ili simboli",],
            [	"id"=>"7", "state"=>"1", "type"=>"2",	"german"=>"Gewalt gefährlicher Organisationen",	"english"=>"Violence of danerous organizations",	"croatian"=>"Nasilje podrugljivih organizacija",],
            [	"id"=>"8", "state"=>"1", "type"=>"2",	"german"=>"Verkauf von illegalen oder regulierten Waren",	"english"=>"Sale of illegal or regulated goods",	"croatian"=>"Prodaja ilegalne ili regulirane robe",],
            [	"id"=>"9", "state"=>"1", "type"=>"2",	"german"=>"Mobbing oder Belästigung",	"english"=>"Bullying or harassment",	"croatian"=>"Zlostavljanje ili uznemiravanje",],
            [	"id"=>"10", "state"=>"1", "type"=>"2",	"german"=>"Selbstmord oder Selbstverletzung",	"english"=>"Suicide or self-injury",	"croatian"=>"Samoubojstvo ili samoozljeđivanje",],
            [	"id"=>"11", "state"=>"1", "type"=>"2",	"german"=>"Betrug oder Betrug",	"english"=>"Scam or fraud",	"croatian"=>"Prijevara ili prijevara",],
            [	"id"=>"12", "state"=>"1", "type"=>"2",	"german"=>"Falsche Information",	"english"=>"False information",	"croatian"=>"Lažne informacije",],
            [	"id"=>"13", "state"=>"1", "type"=>"2",	"german"=>"Gefällt mir einfach nicht",	"english"=>"I just don't like it",	"croatian"=>"Jednostavno mi se ne sviđa",],
        ];

        UserReportType::insert($reasons);
    }
}
