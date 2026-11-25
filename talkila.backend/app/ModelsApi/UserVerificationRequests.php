<?php

namespace App\ModelsApi;

use App\Models;
use App\Scopes\UserApiScope;

/**
 * App\ModelsApi\UserVerificationRequests
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $image
 * @property string|null $request_date
 * @property string|null $approve_date
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerificationRequests newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerificationRequests newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerificationRequests query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerificationRequests whereApproveDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerificationRequests whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerificationRequests whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerificationRequests whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerificationRequests whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerificationRequests whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerificationRequests whereRequestDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerificationRequests whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerificationRequests whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerificationRequests whereUserId($value)
 * @mixin \Eloquent
 */
class UserVerificationRequests extends Models\UserVerificationRequests
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
