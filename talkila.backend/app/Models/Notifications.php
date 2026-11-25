<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\Serializable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Notifications
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $values
 * @property string $pushed_at
 * @property int $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications newQuery()
 * @method static \Illuminate\Database\Query\Builder|Notifications onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications wherePushedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifications whereValues($value)
 * @method static \Illuminate\Database\Query\Builder|Notifications withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Notifications withoutTrashed()
 * @mixin \Eloquent
 */
class Notifications extends Model
{
    use SoftDeletes, Auditable, Serializable;

    public $table = 'notifications';

    protected $fillable = [
        'users_id',
        'type',
        'values',
        'pushed_at',
        'state',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    const STATE = [
        'read' => '0',
        'seen' => '1',
        'new'  => '2',
    ];

    const VALUE = [
        'new_booking'               => 101,
        'canceled_by_supplier'      => 102,
        'booking_postponed'         => 103,
        'following_user'            => 201,
        'following_talk'            => 202,
        'offer_your_talks'          => 401,
        'account_verified'          => 403,
        'account_not_verified'      => 404,
        'new_talk'                  => 501,
        'talk_unpaused'             => 502,
        'talk_deleted'              => 503,
        'talk_paused'               => 505,
        'new_rating'                => 601,
        'about_me_changed'          => 701,
        'new_cv'                    => 702,
        'language_settings_changed' => 703,
        'profession_changed'        => 704,
    ];
}
