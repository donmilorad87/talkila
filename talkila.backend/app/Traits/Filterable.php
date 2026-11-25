<?php

namespace App\Traits;

use App\ModelsApi\User;

trait Filterable
{
    /**
     * Filter talks for a given Category/Subcategory.
     *
     * @param $filters
     * @param $offset
     * @param $limit
     *
     * @return array
     */
    public function filterTalksBy($filters, $offset = 0, $limit = 5)
    {
        $talks = $this->talks()
            ->with('category', 'category.talks', 'subcategory', 'subcategory.talks', 'availabilities')
            ->whereHas('teacher_user', function ($query) {
                $query->join('user_verification_requests', 'users.id', '=', 'user_verification_requests.user_id')
                    ->where('approved', User::STATE['approved'])
                    ->where('type', User::TYPE['supplier'])
                    ->where('visibility', User::VISIBILITY['open'])
                    ->where('user_verification_requests.status', 1);
            })
            ->where('teacher_user_id', '!=', auth()->id() ?? 0)
            ->where('talks.state', '!=', 2)
            ->whereDurations($filters['duration'])
            ->wherePrices($this->filters->prices($filters['priceRange']))
            ->whereDays($this->filters->days($filters['availability']))
            ->whereTalks($this->filters->talkTypes($filters['talks']))
            ->whereAnonymus(optional($filters)['anonTalks'] ?: false)
            ->whereLanguage(optional($filters)['language_id'])
            ->when($filters['order_by'], function ($query) use ($filters) {
                $query->orderBy($filters['order_by'] == 'rating' ? 'ratings' : $filters['order_by'], $filters['order_by_type']);
            })
            ->groupBy('talks.id');

        return [
            'talks_count' => $talks->count(),
            'data'        => $talks->offset($offset)->limit($limit)->get(),
        ];
    }
}
