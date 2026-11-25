<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\BookingsPaymentDetails
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
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetails whereAmountCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetails whereAmountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetails whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetails whereCreationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetails wherePaymentReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetails whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPaymentDetails whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BookingsPaymentDetails extends Model
{
    use Auditable;

    const STATUS = [
        'pending'   => 0,
        'success'   => 1,
        'refunded'  => 2,
    ];

    public $table = 'bookings_payment_details';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'booking_id',
        'payment_reference',
        'event_code',
        'status',
        'amount_value',
        'amount_currency',
        'creation_date',
        'payload',
        'created_at',
        'updated_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
