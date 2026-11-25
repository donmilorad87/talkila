<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\UserBlocked
 *
 * @property int $id
 * @property int $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property int $blocked_user_id
 * @property-read \App\Models\User $blocked_user
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserBlocked onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked whereBlockedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBlocked whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|UserBlocked withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserBlocked withoutTrashed()
 * @mixin \Eloquent
 */
class UserBlocked extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'user_blockeds';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'blocked_user_id',
        'state',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATE = [
      'not_valid'   => 0,
      'valid'       => 1,
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function blocked_user()
    {
        return $this->belongsTo(User::class, 'blocked_user_id');
    }
}
