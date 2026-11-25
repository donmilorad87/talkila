<?php

namespace App\ModelsApi;

use App\Models;
use App\Scopes\UserApiScope;

/**
 * App\ModelsApi\AppFeedback
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AppFeedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppFeedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppFeedback query()
 * @mixin \Eloquent
 */
class AppFeedback extends Models\AppFeedback
{
    protected static function boot()
    {
        parent::boot();
        $user = auth()->user();

        if(!empty($user)) {
            static::addGlobalScope(new UserApiScope);

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
