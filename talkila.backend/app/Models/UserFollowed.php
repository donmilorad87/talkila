<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 *
 * @package App\Models
 * @property int                   $state
 * @property int                   $user_id
 * @property int                   $follower_user_id
 * @property string                $created_at
 * @property string                $updated_at
 * @property string                $deleted_at
 * @property int                   $id
 * @property-read \App\Models\User $follower_user
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserFollowed onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed whereFollowerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFollowed whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|UserFollowed withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserFollowed withoutTrashed()
 * @mixin \Eloquent
 */
class UserFollowed extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'user_followeds';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'follower_user_id',
        'state',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATE = [
        'not_valid' => '0',
        'valid'     => '1',
        'requested' => '2',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function follower_user()
    {
        return $this->belongsTo(User::class, 'follower_user_id', 'id')->withTrashed();
    }
}
