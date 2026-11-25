<?php

namespace Database\Seeders;

use App\Models\TalkSubcategories;
use Illuminate\Database\Seeder;

class PolishSubcategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategories = TalkSubcategories::all();

        $polish = [
            'Niemiecki',
            'Chorwacki',
            'Język Angielski',
            'Hiszpański',
            'Francuski',
            'Włoski',
            'Portugalski',
            'Holenderski',
            'Rosyjski',
            'Ukraiński',
            'Turecki',
            'Duński',
            'Szwedzki',
            'Fiński',
            'Norweski',
            'Arabski',
            'Polski',
            'Inny',
            'Matematyka',
            'Biologia',
            'Fizyka',
            'Chemia',
            'Biznes',
            'Fakturowanie',
            'Inżynieria Elektryczna',
            'Geografia',
            'Fabuła',
            'Muzyka',
            'Vwl',
            'Statystyka',
            'Inny',
            'Akordeon',
            'Instrumenty Dęte',
            'Skrzypce',
            'Śpiewanie',
            'Gitara',
            'Harfa',
            'Klawiatura',
            'Fortepian',
            'Organ',
            'Perkusja',
            'Saksofon',
            'Bębny',
            'Syntezator',
            'Inny',
            'Horoskopy',
            'Inny',
            'Serpentyna',
            'Inny',
            'Joga',
            'Pilates',
            'Ćwiczyć',
            'Powrót',
            'Trening Osobisty',
            'Inny',
            'Chrześcijaństwo',
            'Judaizm',
            'Islam',
            'Hinduizm',
            'Buddyzm',
            'Inny',
            'Prawnik',
            'Konsultant Podatkowy',
            'Doradca Finansowy',
            'Ubezpieczenie',
            'Inny',
            'Duszpasterstwo',
            'Inny',
            'Porady Żywieniowe',
            'Wegański',
            'Wegetarianizm',
            'Inny',
            'Ogólny',
            'Nlp',
            'Ulec Poprawie',
            'Inny',
            'Rozwój Osobowości',
            'Lęk',
            'Poradnia Małżeńska',
            'Porada Seksualna',
            'Depresje',
            'Inny',
            'Inny',
            'Inny',
            'MPU',
        ];

        foreach ($subcategories as $key => $subcategory) {
            $subcategory->update([
                'polish' => $polish[$key],
            ]);
        }
    }
}
