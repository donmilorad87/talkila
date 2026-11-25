<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\StaticMetric
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
 * @mixin \Eloquent
 */
class StaticMetric extends Models\StaticMetric
{
    protected static function boot()
    {
        parent::boot();
    }
}
