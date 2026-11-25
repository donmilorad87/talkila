<?php

namespace App\ModelsApi;

use App\Models;
use App\Scopes\UserApiScope;

/**
 * App\ModelsApi\UserDontShowAgain
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property int $dont_show_again_user_id
 * @property-read \App\Models\User $dont_show_again_user
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserDontShowAgain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDontShowAgain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDontShowAgain query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDontShowAgain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDontShowAgain whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDontShowAgain whereDontShowAgainUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDontShowAgain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDontShowAgain whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDontShowAgain whereUserId($value)
 * @mixin \Eloquent
 */
class UserDontShowAgain extends Models\UserDontShowAgain
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
