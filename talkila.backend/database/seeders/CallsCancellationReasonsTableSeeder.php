<?php

namespace Database\Seeders;

use App\Models\CallsCancellationReason;
use Illuminate\Database\Seeder;

class CallsCancellationReasonsTableSeeder extends Seeder
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
                "id"       => "1",
                "state"    => "1",
                "type"     => "1",
                "german"   => "Ich habe einen günstigeren Talk gefunden.",
                "english"  => "I have found a cheaper Talk.",
                "croatian" => "Pronašao sam jeftiniji razgovor.",
                "polish"   => "Znalazłem/am tańszy Talk.",
            ],
            [
                "id"       => "2",
                "state"    => "1",
                "type"     => "1",
                "german"   => "Ich habe kein Interesse mehr.",
                "english"  => "I am no longer interested.",
                "croatian" => "Više me ne zanima.",
                "polish"   => "Nie jestem już zainteresowany/a.",
            ],
            [
                "id"       => "3",
                "state"    => "1",
                "type"     => "1",
                "german"   => "Mir ist etwas dazwischen gekommen.",
                "english"  => "Something has come up for me.",
                "croatian" => "Neman vremena.",
                "polish"   => "Coś mi wypadło.",
            ],
            [
                "id"       => "4",
                "state"    => "1",
                "type"     => "1",
                "german"   => "Anbieter gefällt mir nicht mehr.",
                "english"  => "I dont like the provider anymore.",
                "croatian" => "Ne sviđa mi se više usluga.",
                "polish"   => "Prowadzący już mi nie odpowiada.",
            ],
            [
                "id"       => "5",
                "state"    => "1",
                "type"     => "1",
                "german"   => "Keinen Grund angeben.",
                "english"  => "Do not give a reason.",
                "croatian" => "Ne želim navesti razlog.",
                "polish"   => "Bez powodu.",
            ],
            [
                "id"       => "6",
                "state"    => "0",
                "type"     => "1",
                "german"   => "Vortrag gelöscht.",
                "english"  => "Talk Deleted.",
                "croatian" => "Razgovor izbrisan.",
                "polish"   => "Talk usunięty.",
            ],

            [
                "id"       => "7",
                "state"    => "1",
                "type"     => "2",
                "german"   => "Ich kann den Talk aus Zeitgründen nicht annehmen.",
                "english"  => "I cannot accept the Talk due to time constraints.",
                "croatian" => "Zbog nedostatka vremena nemogu održati razgovor.",
                "polish"   => "Nie mogę przyjąć rozmowy ze względu na ograniczenia czasowe.",
            ],
            [
                "id"       => "8",
                "state"    => "1",
                "type"     => "2",
                "german"   => "Ich möchte mit diesem Teilnehmer keinen Talk durchführen",
                "english"  => "I do not want to make a Talk with this participant",
                "croatian" => "Ne želim sa ovim sudionikom više Talk održati.",
                "polish"   => "Nie chcę prowadzić rozmowy z tym uczestnikiem.",
            ],
            [
                "id"       => "9",
                "state"    => "1",
                "type"     => "2",
                "german"   => "Keinen Grund angeben",
                "english"  => "Do not specify a reason",
                "croatian" => "Bez odgovarajućeg razloga",
                "polish"   => "Bez powodu.",
            ],
            [
                "id"       => "10",
                "state"    => "1",
                "type"     => "4",
                "german"   => "Ich habe keine Zeit mehr und möchte den Talk frühzeitig verlassen. Der Teilnehmer erhält eine 100% Rückerstattung und ich verzichte auf meine Einnahmen.",
                "english"  => "I have no more time and would like to leave the talk early. The participant receives a 100% refund and I waive my earnings.",
                "croatian" => "Nemam više vremena i želim završiti Talk. Sudionik će ostvariti 100% povrat sredstava, te se osobno odričem svojih primanja.",
                "polish"   => "Nie mam więcej czasu i chcę wcześniej opuścić rozmowę. Uczestnik otrzymuje 100% zwrotu kosztów, a ja zrzekam się dochodu.",
            ],
            [
                "id"       => "11",
                "state"    => "1",
                "type"     => "4",
                "german"   => "Der Teilnehmer ist nicht mehr anwesend. Ich füge eine Beschwerde hinzu.",
                "english"  => "The participant is no longer present. I'll add a complaint.",
                "croatian" => "Ponuditelj nije više prisutan u Talk-u. Priložit ću pritužbu i želim da se Talk provjeri.",
                "polish"   => "Uczestnik nie pojawił się. Składam skargę.",
            ],
            [
                "id"       => "12",
                "state"    => "1",
                "type"     => "4",
                "german"   => "Der Teilnehmer ist unfreundlich oder beleidigend. Ich füge eine Beschwerde hinzu.",
                "english"  => "The participant is rude or insulting. I'll add a complaint.",
                "croatian" => "Sudionik je nepristojan, te vrijeđa. Priložit ću pritužbu i želim da se Talk provjeri.",
                "polish"   => "Uczestnik jest niemiły lub obraźliwy. Składam skargę.",
            ],
            [
                "id"       => "13",
                "state"    => "1",
                "type"     => "4",
                "german"   => "Die Internetverbindung des Teilnehmers ist ziemlich schlecht",
                "english"  => "The participant's internet connection is quite poor",
                "croatian" => "Internetska veza je loša.",
                "polish"   => "Połączenie internetowa uczestnika jest słabe.",
            ],
            [
                "id"       => "14",
                "state"    => "1",
                "type"     => "4",
                "german"   => "Keinen Grund angeben",
                "english"  => "Do not specify a reason",
                "croatian" => "Bez odgovarajućeg razloga",
                "polish"   => "Bez powodu.",
            ],
            [
                "id"       => "15",
                "state"    => "1",
                "type"     => "3",
                "german"   => "Ich bin mit meinem Talk zufrieden und möchte ihn frühzeitig beenden.",
                "english"  => "I am satisfied with my talk and would like to end it early.",
                "croatian" => "Zadovoljan/-na sam sa svojim Talk, te ga želim ranije završiti.",
                "polish"   => "Jestem zadowolony/a z Talk-a i chcę go wcześniej zakończyć.",
            ],
            [
                "id"       => "16",
                "state"    => "1",
                "type"     => "3",
                "german"   => "Ich habe keine Zeit mehr und möchte den Talk beenden.",
                "english"  => "I have no more time and would like to end the talk.",
                "croatian" => "Nemam više vremena i želim završiti Talk.",
                "polish"   => "Nie mam więcej czasu i chcę zakończyć ten Talk.",
            ],
            [
                "id"       => "17",
                "state"    => "1",
                "type"     => "3",
                "german"   => "Die Internetverbindung des Anbieters ist ziemlich schlecht",
                "english"  => "The Internet connection of the provider is quite bad",
                "croatian" => "Internetska veza je loša.",
                "polish"   => "Połączenie internetowa prowadzącego jest słabe.",
            ],
            [
                "id"       => "18",
                "state"    => "1",
                "type"     => "3",
                "german"   => "Ich bin mit der Qualität des Talks absolut nicht zufrieden. Ich füge eine Beschwerde hinzu und möchte das der Talk überprüft wird.",
                "english"  => "I am absolutely not satisfied with the quality of the talk. I add a complaint and want the Talk to be reviewed.",
                "croatian" => "Nisam zadovoljan/-na sa kvalitetom Talk-a. Priložit cu pritužbu i želim da se Talk provjeri.",
                "polish"   => "Jestem całkowicie niezadowolony/a z jakości Talk-a. Składam skargę i chcę, aby Talk został zweryfikowany.",
            ],
            [
                "id"       => "19",
                "state"    => "1",
                "type"     => "3",
                "german"   => "Der Anbieter ist nicht mehr im Talk. Ich füge eine Beschwerde hinzu und möchte das der Talk überprüft wird.",
                "english"  => "The provider is no longer in the Talk. I am adding a complaint and would like the Talk to be reviewed.",
                "croatian" => "Ponuditelj nije više prisutan u Talk-u. Priložit ću pritužbu i želim da se Talk provjeri.",
                "polish"   => "",
            ],
            [
                "id"       => "20",
                "state"    => "1",
                "type"     => "3",
                "german"   => "Keinen Grund angeben",
                "english"  => "Do not specify a reason",
                "croatian" => "Bez odgovarajućeg razloga",
                "polish"   => "Bez powodu.",
            ],
        ];


        CallsCancellationReason::insert($reasons);
    }
}
