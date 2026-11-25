<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\CallsCancellationReason
 *
 * @property int $id
 * @property string $croatian
 * @property string $german
 * @property string $english
 * @property int|null $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Booking[] $cancellationReasonBookings
 * @property-read int|null $cancellation_reason_bookings_count
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason query()
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason whereCroatian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason whereEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason whereGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CallsCancellationReason extends Models\CallsCancellationReason
{
    protected static function boot()
    {
        parent::boot();
    }
}
