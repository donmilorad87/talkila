<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\BookingsProtocol
 *
 * @property-read \App\Models\Booking $booking
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsProtocol newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsProtocol newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsProtocol query()
 * @mixin \Eloquent
 */
class BookingsProtocol extends Models\BookingsProtocol
{
    protected static function boot()
    {
        parent::boot();
    }
}
