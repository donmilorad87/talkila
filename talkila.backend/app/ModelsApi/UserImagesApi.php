<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\UserImagesApi
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $image
 * @property int|null $state
 * @property int|null $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserImagesApi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserImagesApi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserImagesApi query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserImagesApi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserImagesApi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserImagesApi whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserImagesApi whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserImagesApi whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserImagesApi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserImagesApi whereUserId($value)
 * @mixin \Eloquent
 */
class UserImagesApi extends Models\UserImages
{
    protected static function boot()
    {
        parent::boot();
    }
}
