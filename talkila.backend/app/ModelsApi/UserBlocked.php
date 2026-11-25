<?php

namespace App\ModelsApi;

use App\Models;
use App\Scopes\UserApiScope;

/**
 * App\ModelsApi\UserBlocked
 *
 * @property int $id
 * @property int $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property int $blocked_user_id
 * @property-read \App\Models\User $blocked_user
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked whereBlockedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked whereUserId($value)
 * @mixin \Eloquent
 */
class UserBlocked extends Models\UserBlocked
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
