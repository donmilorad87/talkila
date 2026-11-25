<?php

namespace App\Models;

use App\Entity\CallTypes;
use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Booking
 *
 * @property int                                                                                $id
 * @property int|null                                                                           $state
 * @property int|null                                                                           $extension
 * @property int|null                                                                           $anonym
 * @property \Illuminate\Support\Carbon|null                                                    $start_call
 * @property \Illuminate\Support\Carbon|null                                                    $end_call
 * @property int|null                                                                           $duration
 * @property int|null                                                                           $pin     Random number between 1000 and 9999
 * @property string|null                                                                        $price
 * @property string|null                                                                        $message Message from fan to the organizer
 * @property string                                                                             $currency
 * @property \Illuminate\Support\Carbon|null                                                    $created_at
 * @property \Illuminate\Support\Carbon|null                                                    $updated_at
 * @property \Illuminate\Support\Carbon|null                                                    $deleted_at
 * @property int|null                                                                           $participant_user_id
 * @property int|null                                                                           $cancellation_reason_id
 * @property int|null                                                                           $course_id
 * @property int|null                                                                           $teacher_user_id
 * @property-read Booking                                                                       $booking_parent
 * @property-read \App\Models\BookingsPaymentDetails|null                                       $booking_payment_authorization_details
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BookingsPaymentDetails[] $booking_payment_details
 * @property-read int|null                                                                      $booking_payment_details_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BookingsProtocol[]       $booking_protocol
 * @property-read int|null                                                                      $booking_protocol_count
 * @property-read \App\Models\CallsCancellationReason|null                                      $cancellation_reason
 * @property-read \App\Models\FinanceCurrency                                                   $finance_currencies
 * @property-read \App\Models\User|null                                                         $participant_user
 * @property-read \App\Models\Talk                                                              $talk
 * @property-read \App\Models\BookingsPayout|null                                               $talksBookingsPayouts
 * @property-read \App\Models\Feedback|null                                                     $talksFeedback
 * @property-read \App\Models\User|null                                                         $teacher_user
 * @property-read \App\Models\Availability                                                      $user_availabilities
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newQuery()
 * @method static \Illuminate\Database\Query\Builder|Booking onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereAnonym($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCancellationReasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereEndCall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereParticipantUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereStartCall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereTeacherUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Booking withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Booking withoutTrashed()
 * @mixin \Eloquent
 */
class Booking extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'bookings';

    protected $dates = [
        'start_call',
        'end_call',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'state',
        'booking_type',
        'supplier_billing_address_id',
        'client_billing_address_id',
        'vat_id',
        'vat',
        'anonym',
        'participant_user_id',
        'start_call',
        'end_call',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'duration',
        'price',
        //        'finance_currencies_id',
        'talk_id',
        'payout_id',
        'message',
        'cancellation_reason_id',
        'cancel_type',
        'teacher_user_id',
        'currency',
        'notification_before_meeting',
        'reference',
        'state_payout',
        'parent_id',
        'calendar_id',
        'event_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATE = [
        'waiting'                          => '0',
        'paid'                             => '1',
        'rejected'                         => '2',
        'review'                           => '3',
        'refunded'                         => '4',
        'completed'                        => '5',
        'payout'                           => '6',
        'canceled'                         => '7',
        // 'waiting_adyen_capture'           => '11',
        'canceled_without_refund'          => '11',
        // 'waiting_cancellation_teacher'    => '12',
        // 'waiting_cancellation_client'     => '13',
        'canceled_by_teacher'              => '12',
        'waiting_refund'                   => '14',
        'rejected_capture'                 => '15',
        'rejected_refund'                  => '16',
        'rejected_cancellation'            => '17',
        'rejected_cancellation_or_refund'  => '18',
        'postponed'                        => '19',
        'postponed_to'                     => '20',
        'captured'                         => '21',
        'not_enough_coins'                 => '22',
        'cancelled_due_supplier'           => '23',
        'cancelled_due_client'             => '24',
        'cancelled_due_supplier_processed' => '25',
        'cancelled_due_client_processed'   => '26',
    ];

    const BOOKING_TYPE = [
        'regular_call'  => 1,
        'extended_call' => 2,
        'extension'     => 3,
    ];

    const ANONYM = [
        'anonym'     => '1',
        'not_anonym' => '2',
    ];

    const CANCEL_TYPE = [
        'client'               => '1',
        'supplier'             => '2',
        'active_talk_client'   => '3',
        'active_talk_supplier' => '4',
    ];

    // Delay period is in minutes
    // TODO Return this value to 120 minutes when testing period of app is done
    // const DELAY_PERIOD        = 120;
    const DELAY_PERIOD        = 0;
    const CHANGE_PERIOD       = 48;
    const MAX_DAYS_IN_ADVANCE = 28;
    const COMMISSION_PERCENT  = 15;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::created(function ($booking) {
            if ($booking->state === self::STATE['paid'] && $booking->talk->call_type === CallTypes::ONE_TO_ONE) {
                $slotDatetime = $booking->start_call;
                $endCall      = $booking->end_call;

                while ($slotDatetime <= $endCall) {
                    $tmpDate = explode(' ', $slotDatetime);
                    $booking->bookedSlots()->create([
                        'talk_id'             => $booking->talk_id,
                        'teacher_user_id'     => $booking->teacher_user_id,
                        'participant_user_id' => $booking->participant_user_id,
                        'slot_datetime'       => $slotDatetime,
                        'slot_date'           => $tmpDate[0],
                        'slot_time'           => $tmpDate[1],
                    ]);

                    $slotDatetime = date('Y-m-d H:i:00', strtotime('+15 minutes', strtotime($slotDatetime)));
                }
            }
        });

        static::updated(function ($booking) {
            if ($booking->state != self::STATE['paid']) {
                $booking->bookedSlots()->delete();
            }
        });

        static::deleted(function ($booking) {
            if ($booking->state != self::STATE['paid']) {
                $booking->bookedSlots()->delete();
            }
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function talksBookingsPayouts()
    {
        return $this->hasOne(BookingsPayout::class, 'bookings_id', 'id');
    }

    public function talksFeedback()
    {
        return $this->hasOne(Feedback::class, 'booking_id', 'id');
    }

    public function talk()
    {
        return $this->belongsTo(Talk::class, 'talk_id');
    }

    public function teacher_user()
    {
        return $this->belongsTo(User::class, 'teacher_user_id');
    }

    public function supplier()
    {
        return $this->belongsTo(User::class, 'teacher_user_id');
    }

    public function teacher_user_with_trashed()
    {
        return $this->belongsTo(User::class, 'teacher_user_id')->withTrashed();
    }

    public function participant_user()
    {
        return $this->belongsTo(User::class, 'participant_user_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'participant_user_id');
    }

    public function booking_protocol()
    {
        return $this->hasMany(BookingsProtocol::class, 'booking_id', 'id');
    }

    public function booking_payment_details()
    {
        return $this->hasMany(BookingsPaymentDetails::class, 'booking_id', 'id');
    }

    public function booking_payment_authorization_details()
    {
        return $this->hasOne(BookingsPaymentDetails::class, 'booking_id', 'id')->limit(1);
    }

    /**
     * Payments attached to the Booking.
     */
    public function payment()
    {
        return $this->hasMany(WalletHistory::class);
    }

    /**
     * VAT attached to the Booking.
     */
    public function vat(): HasOne
    {
        // This used to be a relationship with VAT Model, but was changed when we decided to merge 'static_vat' and 'countries'.
        return $this->hasOne(Country::class, 'id', 'vat_id');
    }

    /**
     * Room attached to the Booking.
     */
    public function socketRoom()
    {
        return $this->hasOne(SocketRoom::class);
    }

    /**
     * Return Booking's active Socket Room.
     *
     * @return SocketRoom|null
     */
    public function activeSocketRoom(): ?SocketRoom
    {
        return $this->socketRoom;
    }

    /**
     * Payout that the Booking belongs to.
     */
    public function payout()
    {
        return $this->belongsTo(Payout::class, 'payout_id', 'id');
    }

    public function supplierBilling()
    {
        return $this->belongsTo(BillingAddress::class, 'supplier_billing_address_id');
    }

    public function clientBilling()
    {
        return $this->belongsTo(BillingAddress::class, 'client_billing_address_id');
    }

    /**
     * Slots that the Booking is booked for.
     *
     * @return HasMany
     */
    public function bookedSlots(): HasMany
    {
        return $this->hasMany(BookingsBookedSlots::class);
    }

    public function getStartCallAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setStartCallAttribute($value)
    {
        $this->attributes['start_call'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getEndCallAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEndCallAttribute($value)
    {
        $this->attributes['end_call'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function finance_currencies()
    {
        return $this->belongsTo(FinanceCurrency::class, 'currency');
    }

    public function cancellation_reason()
    {
        return $this->belongsTo(CallsCancellationReason::class, 'cancellation_reason_id');
    }

    public function user_availabilities()
    {
        return $this->belongsTo(Availability::class, 'user_id', 'void_id');
    }

    public function booking_parent()
    {
        return $this->belongsTo(Booking::class, 'parent_id');
    }

    /**
     * Calendar that owns the Booking.
     *
     * @return BelongsTo
     */
    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class);
    }

    public function getBookingDetailsById($bookingId)
    {
        $data = Booking::where('id', $bookingId)->first();
        return $data;
    }

    public function whoQuitTalk()
    {
        $booking = Booking::where('id', $this->id)->first();

        if (! empty($booking->cancel_type)) {
            if ($booking->cancel_type == Booking::CANCEL_TYPE['client'] || $booking->cancel_type == Booking::CANCEL_TYPE['active_talk_client']) {
                return 'client';
            } else {
                if ($booking->cancel_type == Booking::CANCEL_TYPE['supplier'] || $booking->cancel_type == Booking::CANCEL_TYPE['active_talk_supplier']) {
                    return 'supplier';
                }
            }
            return '';
        } else {
            return '';
        }
    }

    /**
     * Returns Bookings' revenue.
     *
     * @return float
     */
    public function getRevenue(): float
    {
        return round(
            $this->whereHas('teacher_user', function ($query) {
                $query->where('type', User::TYPE['supplier']);
            })->whereNull('cancel_type')->sum('price'),
            2
        );
    }

    /**
     * Returns Bookings' commission.
     *
     * @return float
     */
    public function getCommission(): float
    {
        return round($this->getRevenue() * 0.2, 2);
    }

    /**
     * Return Supplier Payouts.
     *
     * @return float
     */
    public function getPayout(): float
    {
        return round($this->getRevenue() - $this->getCommission(), 2);
    }

    /**
     * Return Bookings' transaction count.
     *
     * @return int
     */
    public function getTransactionsCount(): int
    {
        return $this->all()->whereNull('cancel_type')->count();
    }
}
