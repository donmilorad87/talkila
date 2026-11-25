<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\BookingsPayout
 *
 * @property-read \App\Models\Booking $calls
 * @property-read \App\Models\Payout $payouts
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPayout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPayout newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPayout query()
 * @mixin \Eloquent
 */
class BookingsPayout extends Models\BookingsPayout
{
    protected static function boot()
    {
        parent::boot();
    }
}
