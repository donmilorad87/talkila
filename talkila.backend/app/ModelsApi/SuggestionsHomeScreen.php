<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\SuggestionsHomeScreen
 *
 * @property int $id
 * @property int $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property-read \App\Models\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|SuggestionsHomeScreen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuggestionsHomeScreen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuggestionsHomeScreen query()
 * @method static \Illuminate\Database\Eloquent\Builder|SuggestionsHomeScreen whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuggestionsHomeScreen whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuggestionsHomeScreen whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuggestionsHomeScreen whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuggestionsHomeScreen whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuggestionsHomeScreen whereUserId($value)
 * @mixin \Eloquent
 */
class SuggestionsHomeScreen extends Models\SuggestionsHomeScreen
{
    protected static function boot()
    {
        parent::boot();
    }
}
