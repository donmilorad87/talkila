<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EmailChangeVerification
 *
 * @package App\Models
 * @property string $requested_email
 * @property int $user_id
 * @property string $verification_code
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $id
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
class EmailChangeVerification extends Model
{
    public $table = 'email_change_verification';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'requested_email',
        'user_id',
        'verification_code',
        'status',
        'created_at',
        'updated_at',
    ];

    const STATE = [
        'requested' => '0',
        'approved'  => '1',
        'declined'  => '2'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
