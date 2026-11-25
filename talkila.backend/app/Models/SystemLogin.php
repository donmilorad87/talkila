<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\SystemLogin
 *
 * @property int $id
 * @property int|null $login_type
 * @property int|null $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin newQuery()
 * @method static \Illuminate\Database\Query\Builder|SystemLogin onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin whereLoginType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|SystemLogin withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SystemLogin withoutTrashed()
 * @mixin \Eloquent
 */
class SystemLogin extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'system_logins';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'login_type',
        'type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const LOGIN_TYPE = [
        '1' => 'mail',
        '2' => 'gmail',
        '3' => 'facebook',
        '4' => 'apple',
        '5' => 'twitter',
    ];

    const TYPE = [
        '1' => 'login',
        '2' => 'logout',
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
