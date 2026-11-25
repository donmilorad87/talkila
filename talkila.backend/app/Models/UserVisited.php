<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\UserVisited
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id
 * @property int|null $visited_user_id
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\User|null $visited_user
 * @method static \Illuminate\Database\Eloquent\Builder|UserVisited newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserVisited newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserVisited onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserVisited query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserVisited whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVisited whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVisited whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVisited whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVisited whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVisited whereVisitedUserId($value)
 * @method static \Illuminate\Database\Query\Builder|UserVisited withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserVisited withoutTrashed()
 * @mixin \Eloquent
 */
class UserVisited extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'user_visiteds';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'visited_user_id',
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

    public function visited_user()
    {
        return $this->belongsTo(User::class, 'visited_user_id');
    }
}
