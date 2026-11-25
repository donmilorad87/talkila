<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\BookingsPaymentDetailsApi
 *
 * @property int $id
 * @property int|null $booking_id
 * @property string|null $payment_reference
 * @property string|null $status
 * @property float|null $amount_value
 * @property string|null $amount_currency
 * @property string|null $creation_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Booking|null $booking
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetailsApi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetailsApi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetailsApi query()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetailsApi whereAmountCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetailsApi whereAmountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetailsApi whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetailsApi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetailsApi whereCreationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetailsApi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetailsApi wherePaymentReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetailsApi whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetailsApi whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BookingsPaymentDetailsApi extends Models\BookingsPaymentDetails
{
    protected static function boot()
    {
        parent::boot();
    }
}
