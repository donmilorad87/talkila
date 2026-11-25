<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;

class Filters
{
    /**
     * Talk filters.
     */
    public $filters;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->filters = config('filters');
    }

    /**
     * Returns an array of all active filters for given talks.
     *
     * @param Collection $talks
     *
     * @return array
     */
    public function active(Collection $talks): array
    {
        return [
            'durations'      => $talks->pluck('duration')->unique()->sortKeysDesc(),
            'weekdays'       => $talks->pluck('availabilities')->flatten()->pluck('weekday')->unique()->sortKeysDesc(),
            'prices'         => $this->getPriceFilters($talks),
            'anonymous'      => $talks->pluck('anonym_call')->unique(),
            'calls'          => $talks->pluck('call_type')->unique(),
            'talks'          => $talks->pluck('talk_type')->unique(),
            'language_ids'   => $talks->pluck('language_id')->unique(),
            'language_names' => $talks->pluck('language')->unique(),
        ];
    }

    /**
     * Returns an array of ALL price filters.
     *
     * @param Collection $filters
     *
     * @return array
     */
    protected function getPriceFilters(Collection $filters): array
    {
        return [
            '1-10'  => $filters->pluck('price')->unique()->contains(function ($value) {
                return $value <= 10;
            }),
            '10-50' => $filters->pluck('price')->unique()->contains(function ($value) {
                return ($value >= 10) && ($value <= 50);
            }),
            '50+'   => $filters->pluck('price')->unique()->contains(function ($value) {
                return ($value > 50) && ($value < 100);
            }),
            '100+'  => $filters->pluck('price')->unique()->contains(function ($value) {
                return $value >= 100;
            }),
        ];
    }

    /**
     * Returns an array of active price range filters.
     *
     * @param $priceRange
     *
     * @return array
     */
    public function prices($priceRange): array
    {
        $prices = [];

        foreach ($priceRange as $key => $value) {
            $prices[$key] = [
                'from' => $value ? $this->filters['prices'][$key]['from'] : 0,
                'to'   => $value ? $this->filters['prices'][$key]['to'] : 0,
            ];
        }

        return $prices;
    }

    /**
     * Returns an array of active available days.
     *
     * @param $availability
     *
     * @return array
     */
    public function days($availability): array
    {
        $days = [];

        foreach ($availability as $key => $value) {
            if ($value) $days[$key] = $this->filters['days'][$key];
        }

        return $days;
    }

    /**
     * Returns an array of active call types.
     *
     * @param $talkTypes
     *
     * @return array
     */
    public function talkTypes($talkTypes): array
    {
        $talks = [];

        foreach ($talkTypes as $key => $value) {
            if ($value) $talks[$key] = $this->filters['talks'][$key];
        }

        return $talks;
    }

    /**
     * Returns decoded filters JSON.
     *
     * @param $filters
     *
     * @return mixed
     */
    public function decode($filters)
    {
        return json_decode($filters, TRUE);
    }
}
