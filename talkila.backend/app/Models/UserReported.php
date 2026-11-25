<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\UserReported
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
 * @property int $reason_id
 * @property-read \App\Models\User|null $reporter_user
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserReported newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReported newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserReported onlyTrashed()
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
 * @method static \Illuminate\Database\Query\Builder|UserReported withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserReported withoutTrashed()
 * @mixin \Eloquent
 */
class UserReported extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'user_reporteds';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'reporter_user_id',
        'reason_id',
        'description',
        'state',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const TYPE = [
        '1' => 'SPAM',
        '2' => 'Beleidigung',
        '3' => 'Sex',
        '4' => 'Sonstiges',
    ];

    const STATE = [
        'not_valid' => 0,
        'valid'     => 1,
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reporter_user()
    {
        return $this->belongsTo(User::class, 'reporter_user_id');
    }
}
