<?php

namespace App\ModelsApi;

use App\Models;
use App\Scopes\UserApiScope;

/**
 * App\ModelsApi\UserBookmarkedTalks
 *
 * @property-read \App\Models\Talk $talk
 * @property-read \App\Models\User $teacher
 * @method static \Illuminate\Database\Eloquent\Builder|UserBookmarkedTalks newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBookmarkedTalks newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBookmarkedTalks query()
 * @mixin \Eloquent
 */
class UserBookmarkedTalks extends Models\UserBookmarkedTalks
{
    protected static function boot()
    {
        parent::boot();
        $user = auth()->user();

        if(!empty($user)) {
            static::addGlobalScope(new UserApiScope());

            self::creating(function ($model) {
                $model->user_id = auth()->user()->id;
            });

            self::created(function ($model) {
                $model->user_id = auth()->user()->id;
            });

            self::updating(function ($model) {
                $model->user_id = auth()->user()->id;
            });

            self::updated(function ($model) {
                $model->user_id = auth()->user()->id;
            });

            self::saving(function ($model) {
                $model->user_id = auth()->user()->id;
            });

            self::saved(function ($model) {
                $model->user_id = auth()->user()->id;
            });

            self::deleting(function ($model) {
                $model->user_id = auth()->user()->id;
            });

            self::deleted(function ($model) {
                $model->user_id = auth()->user()->id;
            });
        }
    }
}
