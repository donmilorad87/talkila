<?php

namespace App\ModelsApi;

use App\Models;
use App\Scopes\UserApiScope;

/**
 * App\ModelsApi\ProfilCv
 *
 * @property int $id
 * @property int|null $type
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property string|null $company_name
 * @property \App\Models\StaticProfession|null $profession
 * @property string|null $location
 * @property int $work_here
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id
 * @property int|null $profession_id
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereProfessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereWorkHere($value)
 * @mixin \Eloquent
 */
class ProfilCv extends Models\ProfilCv
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
