<?php

namespace App\ModelsApi;

use App\Models;
use App\Scopes\UserApiScope;

/**
 * App\ModelsApi\Notifications
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $values
 * @property string $pushed_at
 * @property int $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications wherePushedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereValues($value)
 * @mixin \Eloquent
 */
class Notifications extends Models\Notifications
{
    protected static function boot()
    {
        parent::boot();
//        $user = auth()->user();
//
//        if(!empty($user)) {
//            static::addGlobalScope(new UserApiScope);
//
//            self::creating(function ($model) {
//                $model->user_id = auth()->user()->id;
//            });
//
//            self::created(function ($model) {
//                $model->user_id = auth()->user()->id;
//            });
//
//            self::updating(function ($model) {
//
//                $model->user_id = auth()->user()->id;
//            });
//
//            self::updated(function ($model) {
//                $model->user_id = auth()->user()->id;
//            });
//
//            self::saving(function ($model) {
//                $model->user_id = auth()->user()->id;
//            });
//
//            self::saved(function ($model) {
//                $model->user_id = auth()->user()->id;
//            });
//
//            self::deleting(function ($model) {
//
//                $model->user_id = auth()->user()->id;
//            });
//
//            self::deleted(function ($model) {
//
//                $model->user_id = auth()->user()->id;
//            });
//        }
    }
}
