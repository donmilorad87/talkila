<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\BookingsProtocol
 *
 * @property-read \App\Models\Booking $booking
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsProtocol newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsProtocol newQuery()
 * @method static \Illuminate\Database\Query\Builder|BookingsProtocol onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsProtocol query()
 * @method static \Illuminate\Database\Query\Builder|BookingsProtocol withTrashed()
 * @method static \Illuminate\Database\Query\Builder|BookingsProtocol withoutTrashed()
 * @mixin \Eloquent
 */
class BookingsProtocol extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'bookings_protocol';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'booking_id',
        'state',
        'created_at',
        'updated_at',
        'deleted_at',
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
