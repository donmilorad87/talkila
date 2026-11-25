<?php

namespace App\Traits;

use App\Models\Language;
use App\ModelsApi\User;

trait Searchable
{
    /**
     * Get all talks for a given category.
     *
     * @param  null  $columns
     * @param  int   $offset
     * @param  int   $limit
     *
     * @return array
     */
    public function getTalks($columns = null, int $offset = 0, int $limit = 5): array
    {
        $talks = $this->talks()
            ->with('category', 'subcategory', 'teacher', 'language', 'availabilities')
            ->whereHas('teacher_user', function ($query) {
                $query->join('user_verification_requests', 'users.id', '=', 'user_verification_requests.user_id')
                    ->where('approved', User::STATE['approved'])
                    ->where('type', User::TYPE['supplier'])
                    ->where('visibility', User::VISIBILITY['open'])
                    ->where('user_verification_requests.status', 1);
            })
            ->where('teacher_user_id', '!=', auth()->id() ?? 0)
            ->where('state', '!=', 2)
            ->select($columns ?: ['duration ', 'weekday', 'price', 'anonym_call as anonymous', 'call_type', 'talk_type', 'languages_id as language_id', 'language' => Language::select('english')->whereColumn('id', 'languages_id')->take(1)]);

        return [
            'talks_count' => count($talks->get()),
            'filters'     => $this->filters->active($talks->get()),
            'data'        => $talks->offset($offset)->limit($limit)->get(),
        ];
    }
}
