<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\EmailChangeVerification
 *
 * @property int $id
 * @property string $requested_email
 * @property int $user_id
 * @property string $verification_code
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeVerification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeVerification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeVerification query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeVerification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeVerification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeVerification whereRequestedEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeVerification whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeVerification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeVerification whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeVerification whereVerificationCode($value)
 * @mixin \Eloquent
 */
class EmailChangeVerification extends Models\EmailChangeVerification
{
    protected static function boot()
    {
        parent::boot();
    }
}
