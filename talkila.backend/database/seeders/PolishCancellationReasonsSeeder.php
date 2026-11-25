<?php

namespace Database\Seeders;

use App\Models\CallsCancellationReason;
use Illuminate\Database\Seeder;

class PolishCancellationReasonsSeeder extends Seeder
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
                'id'     => '1',
                'polish' => 'Znalazłem/am tańszy Talk.',
            ],
            [
                'id'     => '2',
                'polish' => 'Nie jestem już zainteresowany/a.',
            ],
            [
                'id'     => '3',
                'polish' => 'Coś mi wypadło.',
            ],
            [
                'id'     => '4',
                'polish' => 'Prowadzący już mi nie odpowiada.',
            ],
            [
                'id'     => '5',
                'polish' => 'Bez powodu.',
            ],
            [
                'id'     => '6',
                'polish' => 'Talk usunięty.',
            ],
            [
                'id'     => '7',
                'polish' => 'Nie mogę przyjąć rozmowy ze względu na ograniczenia czasowe.',
            ],
            [
                'id'     => '8',
                'polish' => 'Nie chcę prowadzić rozmowy z tym uczestnikiem.',
            ],
            [
                'id'     => '9',
                'polish' => 'Bez powodu.',
            ],
            [
                'id'     => '10',
                'polish' => 'Nie mam więcej czasu i chcę wcześniej opuścić rozmowę. Uczestnik otrzymuje 100% zwrotu kosztów, a ja zrzekam się dochodu.',
            ],
            [
                'id'     => '11',
                'polish' => 'Uczestnik nie pojawił się. Składam skargę.',
            ],
            [
                'id'     => '12',
                'polish' => 'Uczestnik jest niemiły lub obraźliwy. Składam skargę.',
            ],
            [
                'id'     => '13',
                'polish' => 'Połączenie internetowa uczestnika jest słabe.',
            ],
            [
                'id'     => '14',
                'polish' => 'Bez powodu.',
            ],
            [
                'id'     => '15',
                'polish' => 'Jestem zadowolony/a z Talk-a i chcę go wcześniej zakończyć.',
            ],
            [
                'id'     => '16',
                'polish' => 'Nie mam więcej czasu i chcę zakończyć ten Talk.',
            ],
            [
                'id'     => '17',
                'polish' => 'Połączenie internetowa prowadzącego jest słabe.',
            ],
            [
                'id'     => '18',
                'polish' => 'Jestem całkowicie niezadowolony/a z jakości Talk-a. Składam skargę i chcę, aby Talk został zweryfikowany.',
            ],
            [
                'id'     => '19',
                'polish' => null,
            ],
            [
                'id'     => '20',
                'polish' => 'Bez powodu.',
            ],
        ];

        foreach ($reasons as $reason) {
            CallsCancellationReason::query()
                ->find($reason['id'])
                ->update([
                    'polish' => $reason['polish'],
                ]);
        }
    }
}
