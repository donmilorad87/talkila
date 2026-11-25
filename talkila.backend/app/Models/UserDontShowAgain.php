<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\UserDontShowAgain
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property int $dont_show_again_user_id
 * @property-read \App\Models\User $dont_show_again_user
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserDontShowAgain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDontShowAgain newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserDontShowAgain onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDontShowAgain query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDontShowAgain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDontShowAgain whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDontShowAgain whereDontShowAgainUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDontShowAgain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDontShowAgain whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDontShowAgain whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|UserDontShowAgain withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserDontShowAgain withoutTrashed()
 * @mixin \Eloquent
 */
class UserDontShowAgain extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'user_dont_show_agains';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'dont_show_again_user_id',
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

    public function dont_show_again_user()
    {
        return $this->belongsTo(User::class, 'dont_show_again_user_id');
    }
}
