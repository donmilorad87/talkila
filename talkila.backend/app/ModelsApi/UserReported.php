<?php

namespace App\ModelsApi;

use App\Models;
use App\Scopes\UserApiScope;

/**
 * App\ModelsApi\UserReported
 *
 * @property int $id
 * @property string|null $description
 * @property int $type_id
 * @property int $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id
 * @property int|null $reporter_user_id
 * @property-read \App\Models\User|null $reporter_user
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserReported newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReported newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReported query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReported whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReported whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReported whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReported whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReported whereReporterUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReported whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReported whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReported whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReported whereUserId($value)
 * @mixin \Eloquent
 */
class UserReported extends Models\UserReported
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
