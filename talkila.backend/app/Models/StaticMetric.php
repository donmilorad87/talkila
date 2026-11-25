<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\StaticMetric
 *
 * @property int $id
 * @property int|null $follower
 * @property int|null $reviews
 * @property int|null $calls
 * @property int|null $revenue
 * @property int|null $bad_reports
 * @property int|null $send_emails
 * @property int|null $searches_per_day
 * @property int|null $visited_user_profils_per_day
 * @property int|null $dont_show_again
 * @property int|null $visited
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|StaticMetric newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticMetric newQuery()
 * @method static \Illuminate\Database\Query\Builder|StaticMetric onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticMetric query()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticMetric whereBadReports($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticMetric whereCalls($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticMetric whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticMetric whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticMetric whereDontShowAgain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticMetric whereFollower($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticMetric whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticMetric whereRevenue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticMetric whereReviews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticMetric whereSearchesPerDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticMetric whereSendEmails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticMetric whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticMetric whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticMetric whereVisited($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticMetric whereVisitedUserProfilsPerDay($value)
 * @method static \Illuminate\Database\Query\Builder|StaticMetric withTrashed()
 * @method static \Illuminate\Database\Query\Builder|StaticMetric withoutTrashed()
 * @mixin \Eloquent
 */
class StaticMetric extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'static_metrics';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'received_followers',
        'my_follows',
        'received_blocks',
        'my_blocked',
        'received_reports',
        'my_reports',
        'received_reviews',
        'my_reviews',
        'my_booked_hours',
        'received_booked_hours',
        'talks',
        'talks_reported',
        'received_bookings',
        'my_bookings',
        'revenue',
        'received_bad_reports',
        'my_bad_reports',
        'send_emails',
        'searches_per_day',
        'visited_user_profiles_per_day',
        'visited',
        'received_dont_show_again',
        'my_dont_show_again',
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
