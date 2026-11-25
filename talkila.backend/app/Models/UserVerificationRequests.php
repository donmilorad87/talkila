<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserVerificationRequests
 *
 * @package App\Models
 * @property int                   $user_id
 * @property string                $name
 * @property string                $image
 * @property string                $request_date
 * @property string                $approve_date
 * @property int                   $status
 * @property string                $created_at
 * @property string                $updated_at
 * @property string                $deleted_at
 * @property int                   $id
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerificationRequests newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerificationRequests newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserVerificationRequests onlyTrashed()
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
 * @method static \Illuminate\Database\Query\Builder|UserVerificationRequests withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserVerificationRequests withoutTrashed()
 * @mixin \Eloquent
 */
class UserVerificationRequests extends Model
{
    use SoftDeletes, Auditable;

    const STATUS = [
        '0' => 'Pending',
        '1' => 'Approved',
        '2' => 'Declined',
    ];

    const STATE = [
        'pending'  => '0',
        'approved' => '1',
        'declined' => '2',
    ];

    public $table = 'user_verification_requests';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'image',
        'request_date',
        'approve_date',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
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
