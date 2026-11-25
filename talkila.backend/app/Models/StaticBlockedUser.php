<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\StaticBlockedUser
 *
 * @property int $id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|StaticBlockedUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticBlockedUser newQuery()
 * @method static \Illuminate\Database\Query\Builder|StaticBlockedUser onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticBlockedUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticBlockedUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticBlockedUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticBlockedUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticBlockedUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticBlockedUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|StaticBlockedUser withTrashed()
 * @method static \Illuminate\Database\Query\Builder|StaticBlockedUser withoutTrashed()
 * @mixin \Eloquent
 */
class StaticBlockedUser extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'static_blocked_users';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'email',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
