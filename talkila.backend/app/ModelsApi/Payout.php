<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\Payout
 *
 * @property-read \App\Models\FinanceCurrency $finance_currencies
 * @property mixed $payout_date
 * @property mixed $transferred_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BookingsPayout[] $payoutsBookingsPayouts
 * @property-read int|null $payouts_bookings_payouts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Payout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payout newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payout query()
 * @mixin \Eloquent
 */
class Payout extends Models\Payout
{
    protected static function boot()
    {
        parent::boot();
    }
}
