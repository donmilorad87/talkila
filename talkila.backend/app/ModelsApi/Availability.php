<?php

namespace App\ModelsApi;

use App\Models;
use App\Scopes\UserApiScope;

/**
 * App\ModelsApi\Availability
 *
 * @property int $id
 * @property int|null $recurrent
 * @property int|null $weekday
 * @property int|null $state
 * @property string|null $start_time
 * @property string|null $end_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Availability newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Availability newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Availability query()
 * @method static \Illuminate\Database\Eloquent\Builder|Availability whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Availability whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Availability whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Availability whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Availability whereRecurrent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Availability whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Availability whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Availability whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Availability whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Availability whereWeekday($value)
 * @mixin \Eloquent
 */
class Availability extends Models\Availability
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
