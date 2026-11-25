<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\BookingsPayout
 *
 * @property-read \App\Models\Booking $calls
 * @property-read \App\Models\Payout $payouts
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPayout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPayout newQuery()
 * @method static \Illuminate\Database\Query\Builder|BookingsPayout onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingsPayout query()
 * @method static \Illuminate\Database\Query\Builder|BookingsPayout withTrashed()
 * @method static \Illuminate\Database\Query\Builder|BookingsPayout withoutTrashed()
 * @mixin \Eloquent
 */
class BookingsPayout extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'bookings_payouts';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'payouts_id',
        'bookings_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function payouts()
    {
        return $this->belongsTo(Payout::class, 'payouts_id');
    }

    public function calls()
    {
        return $this->belongsTo(Booking::class, 'talk_id');
    }
}
