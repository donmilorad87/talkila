<?php

namespace App\ModelsApi;

use App\Models;
use App\Scopes\UserApiScope;

/**
 * App\ModelsApi\UserFollowed
 *
 * @property int $id
 * @property int $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property int $follower_user_id
 * @property-read \App\Models\User $follower_user
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed whereFollowerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed whereUserId($value)
 * @mixin \Eloquent
 */
class UserFollowed extends Models\UserFollowed
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
