<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\UserVisited
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id
 * @property int|null $visited_user_id
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\User|null $visited_user
 * @method static \Illuminate\Database\Eloquent\Builder|UserVisited newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserVisited newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserVisited query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserVisited whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVisited whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVisited whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVisited whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVisited whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVisited whereVisitedUserId($value)
 * @mixin \Eloquent
 */
class UserVisited extends Models\UserVisited
{
    protected static function boot()
    {
        parent::boot();
    }
}
