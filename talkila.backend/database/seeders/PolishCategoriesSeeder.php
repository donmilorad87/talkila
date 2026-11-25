<?php

namespace Database\Seeders;

use App\Models\TalkCategories;
use Illuminate\Database\Seeder;

class PolishCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = TalkCategories::all();

        $polish = [
            'Języki',
            'Korepetycje',
            'Muzyka',
            'Astrologia',
            'Wpływowy',
            'Sporty',
            'Religia',
            'Eksperci',
            'Słuchacze',
            'Zdrowie',
            'Flirtować',
            'Osobowość',
            'Zabawa',
            'Inny',
        ];

        foreach ($categories as $key => $category) {
            $category->update([
                'polish' => $polish[$key],
            ]);
        }
    }
}
